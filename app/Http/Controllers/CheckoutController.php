<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\RazorpayService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly RazorpayService $razorpayService,
    ) {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->current($request);
        abort_if($cart->items->isEmpty(), 404);
 
        $coupon = $this->cartService->couponFromSession($request);
        $totals = $this->cartService->totals($cart, $coupon);
        $addresses = $request->user()->addresses()->latest()->get();
 
        // Query active spin coupon for this session or user
        $spinCoupon = null;
        $spinResult = \App\Models\SpinWheelResult::where('session_id', $request->session()->getId())
            ->when(auth()->check(), fn($q) => $q->orWhere('user_id', auth()->id()))
            ->whereNotNull('coupon_code')
            ->latest()
            ->first();
 
        if ($spinResult) {
            $spinCoupon = \App\Models\Coupon::where('code', $spinResult->coupon_code)
                ->where('is_active', true)
                ->where('used_count', 0)
                ->first();
        }
 
        return view('checkout.index', compact('cart', 'coupon', 'totals', 'addresses', 'spinCoupon'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_state' => ['required', 'string', 'max:255'],
            'shipping_pincode' => ['required', 'string', 'max:20'],
            'billing_name' => ['required', 'string', 'max:255'],
            'billing_phone' => ['required', 'string', 'max:20'],
            'billing_address' => ['required', 'string'],
            'billing_city' => ['required', 'string', 'max:255'],
            'billing_state' => ['required', 'string', 'max:255'],
            'billing_pincode' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
        ]);

        $cart = $this->cartService->current($request);
        abort_if($cart->items->isEmpty(), 404);

        $coupon = $this->cartService->couponFromSession($request);
        $totals = $this->cartService->totals($cart, $coupon);

        $order = DB::transaction(function () use ($request, $data, $cart, $coupon, $totals) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'coupon_id' => $coupon?->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'razorpay',
                'subtotal' => $totals['subtotal'],
                'discount' => $totals['discount'],
                'shipping_charge' => $totals['shipping'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'coupon_code' => $coupon?->code,
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_pincode' => $data['shipping_pincode'],
                'shipping_country' => 'India',
                'billing_name' => $data['billing_name'],
                'billing_phone' => $data['billing_phone'],
                'billing_address' => $data['billing_address'],
                'billing_city' => $data['billing_city'],
                'billing_state' => $data['billing_state'],
                'billing_pincode' => $data['billing_pincode'],
                'billing_country' => 'India',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->variant?->sku ?: $item->product->sku,
                    'variant_info' => trim(collect([
                        $item->variant?->size ? 'Size: ' . $item->variant->size : null,
                        $item->variant?->color ? 'Color: ' . $item->variant->color : null,
                    ])->filter()->implode(', ')),
                    'product_image' => $item->product->images->first()->image_path ?? null,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'currency' => 'INR',
                'status' => 'pending',
            ]);

            return $order->load('payment', 'items.product');
        });

        $razorpayOrder = $this->razorpayService->createOrder($order);

        if (! $razorpayOrder) {
            return redirect()->route('checkout.success', $order)->with('warning', 'Razorpay keys are not configured yet. Order created in pending payment mode.');
        }

        return view('checkout.pay', [
            'order' => $order->fresh('payment'),
            'razorpayOrder' => $razorpayOrder,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

    public function success(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if ($order->payment && $request->filled('razorpay_payment_id')) {
            $valid = $this->razorpayService->verifySignature([
                'razorpay_order_id' => $request->input('razorpay_order_id'),
                'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                'razorpay_signature' => $request->input('razorpay_signature'),
            ]);

            if ($valid) {
                $this->razorpayService->markPaid($order->payment, $request->all());
            }
        }

        $this->cartService->clear($request);

        // Send email notification on order completion
        // Important: only mark email_sent=true AFTER a successful send.
        $order = $order->fresh(['items.product', 'user']);

        // Always attempt if email was not sent.
        if (! $order->email_sent) {
            try {
                \Illuminate\Support\Facades\Log::info('Sending order email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'recipient' => 'mistryvaidehi263@gmail.com',
                ]);

                \Illuminate\Support\Facades\Mail::to('mistryvaidehi263@gmail.com')
                    ->send(new \App\Mail\OrderCompletedMail($order));

                $order->update(['email_sent' => true]);

                \Illuminate\Support\Facades\Log::info('Order email sent', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Order email failed', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'recipient' => 'mistryvaidehi263@gmail.com',
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            \Illuminate\Support\Facades\Log::info('Order email already marked as sent - skipping', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
        }

        return view('checkout.success', compact('order'));
    }

    public function failure(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if ($order->payment) {
            $this->razorpayService->markFailed($order->payment);
        }

        return view('checkout.failure', compact('order'));
    }

    public function invoice(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->isAdmin(), 403);

        $order->load('items.product', 'user');

        return Pdf::loadView('pdf.invoice', compact('order'))->download($order->order_number . '.pdf');
    }
}
