<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        $wishlist = $request->user()->wishlist();
        $exists = $wishlist->where('product_id', $product->id)->exists();

        if ($exists) {
            $wishlist->where('product_id', $product->id)->delete();
            return back()->with('success', 'Removed from wishlist.');
        }

        $wishlist->create(['product_id' => $product->id]);

        return back()->with('success', 'Added to wishlist.');
    }
}
