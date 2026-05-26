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
 
    private function respondWithCart(Request $request, string $message = 'Success')
    {
        $cart = $this->cartService->current($request);
        $coupon = $this->cartService->couponFromSession($request);
        $totals = $this->cartService->totals($cart, $coupon);
 
        $html = view('shop.partials.cart-drawer-content', compact('cart', 'coupon', 'totals'))->render();
 
        return response()->json([
            'success' => true,
            'message' => $message,
            'cart' => $cart->load('items.product.images', 'items.variant'),
            'coupon' => $coupon,
            'totals' => $totals,
            'html' => $html
        ]);
    }
 
    public function index(Request $request)
    {
        $cart = $this->cartService->current($request);
        $coupon = $this->cartService->couponFromSession($request);
        $totals = $this->cartService->totals($cart, $coupon);
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Cart fetched.');
        }
 
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
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Product added to cart.');
        }
 
        return back()->with('success', 'Product added to cart.');
    }
 
    public function update(Request $request, CartItem $item)
    {
        abort_unless($item->cart_id === $this->cartService->current($request)->id, 403);
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $this->cartService->updateQuantity($item, (int) $request->input('quantity'));
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Cart updated.');
        }
 
        return back()->with('success', 'Cart updated.');
    }
 
    public function destroy(Request $request, CartItem $item)
    {
        abort_unless($item->cart_id === $this->cartService->current($request)->id, 403);
        $this->cartService->remove($item);
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Item removed from cart.');
        }
 
        return back()->with('success', 'Item removed from cart.');
    }
 
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => ['required', 'string']]);
 
        $coupon = Coupon::where('code', strtoupper($request->input('code')))->first();
        $cart = $this->cartService->current($request);
 
        if (! $coupon || ! $coupon->is_valid || $coupon->calculateDiscount((float) $cart->subtotal) <= 0) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon is not valid for the current cart.'
                ], 422);
            }
            return back()->withErrors(['coupon' => 'This coupon is not valid for the current cart.']);
        }
 
        $request->session()->put('cart_coupon', $coupon->code);
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Coupon applied successfully.');
        }
 
        return back()->with('success', 'Coupon applied successfully.');
    }
 
    public function removeCoupon(Request $request)
    {
        $request->session()->forget('cart_coupon');
 
        if ($request->expectsJson() || $request->ajax()) {
            return $this->respondWithCart($request, 'Coupon removed.');
        }
 
        return back()->with('success', 'Coupon removed.');
    }
}
