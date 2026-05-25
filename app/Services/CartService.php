<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartService
{
    public function current(Request $request): Cart
    {
        $cart = Cart::query()
            ->with(['items.product.images', 'items.variant'])
            ->when(
                $request->user(),
                fn ($query) => $query->where('user_id', $request->user()->id),
                fn ($query) => $query->where('session_id', $request->session()->getId())
            )
            ->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => $request->user()?->id,
                'session_id' => $request->user() ? null : $request->session()->getId(),
            ]);
        }

        if ($request->user() && ! $cart->user_id) {
            $cart->update(['user_id' => $request->user()->id, 'session_id' => null]);
        }

        return $cart->load(['items.product.images', 'items.variant']);
    }

    public function add(Request $request, Product $product, int $quantity = 1, ?int $variantId = null): Cart
    {
        $cart = $this->current($request);
        $variant = $variantId ? ProductVariant::find($variantId) : null;

        $item = $cart->items()->firstOrNew([
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + max(1, $quantity);
        $item->price = $product->effective_price + (float) ($variant?->price_adjustment ?? 0);
        $item->save();

        return $this->current($request);
    }

    public function updateQuantity(CartItem $item, int $quantity): void
    {
        if ($quantity <= 0) {
            $item->delete();
            return;
        }

        $item->update(['quantity' => $quantity]);
    }

    public function remove(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(Request $request): void
    {
        $this->current($request)->items()->delete();
        $request->session()->forget('cart_coupon');
    }

    public function couponFromSession(Request $request): ?Coupon
    {
        $code = $request->session()->get('cart_coupon');

        if (! $code) {
            return null;
        }

        return Coupon::where('code', $code)->first();
    }

    public function totals(Cart $cart, ?Coupon $coupon = null): array
    {
        $subtotal = (float) $cart->items->sum(fn (CartItem $item) => $item->subtotal);
        $discount = $coupon && $coupon->is_valid ? $coupon->calculateDiscount($subtotal) : 0;
        $shipping = $subtotal >= 1999 || $subtotal === 0.0 ? 0 : 99;
        $taxable = max(0, $subtotal - $discount);
        $tax = round($taxable * 0.03, 2);
        $total = max(0, $taxable + $shipping + $tax);

        return compact('subtotal', 'discount', 'shipping', 'tax', 'total');
    }
}
