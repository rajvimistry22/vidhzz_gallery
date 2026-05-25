<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->current($request);
        $coupon = $this->cartService->couponFromSession($request);
        $totals = $this->cartService->totals($cart, $coupon);

        return view('shop.cart', compact('cart', 'coupon', 'totals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $this->cartService->add(
            $request,
            Product::findOrFail($data['product_id']),
            $data['quantity'],
            $data['variant_id'] ?? null
        );

        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        abort_unless($item->cart_id === $this->cartService->current($request)->id, 403);
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $this->cartService->updateQuantity($item, (int) $request->input('quantity'));

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, CartItem $item)
    {
        abort_unless($item->cart_id === $this->cartService->current($request)->id, 403);
        $this->cartService->remove($item);

        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => ['required', 'string']]);

        $coupon = Coupon::where('code', strtoupper($request->input('code')))->first();
        $cart = $this->cartService->current($request);

        if (! $coupon || ! $coupon->is_valid || $coupon->calculateDiscount((float) $cart->subtotal) <= 0) {
            return back()->withErrors(['coupon' => 'This coupon is not valid for the current cart.']);
        }

        $request->session()->put('cart_coupon', $coupon->code);

        return back()->with('success', 'Coupon applied successfully.');
    }

    public function removeCoupon(Request $request)
    {
        $request->session()->forget('cart_coupon');

        return back()->with('success', 'Coupon removed.');
    }
}
