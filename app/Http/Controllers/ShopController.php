<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Support\StorefrontData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class ShopController extends Controller
{
    protected function hasSubcategoryColumn(): bool
    {
        return Schema::hasColumn('products', 'subcategory');
    }

    protected function applyPriceFilters(Builder $query, Request $request): Builder
    {
        $min = $request->input('min_price');
        $max = $request->input('max_price');

        if ($min !== null && $min !== '') {
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [(float) $min]);
        }

        if ($max !== null && $max !== '') {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [(float) $max]);
        }

        return $query;
    }

    public function home()
    {
        $categories = Category::active()->ordered()->with('images')->withCount('products')->get();
        $heroBanners = Banner::where('position', 'hero')->where('is_active', true)->orderBy('sort_order')->get();
        $trendingProducts = Product::active()->with(['images', 'category'])->trending()->take(8)->get();
        $newArrivals = Product::active()->with(['images', 'category'])->newArrival()->take(8)->get();
        $featuredProducts = Product::active()->with(['images', 'category'])->featured()->take(6)->get();

        return view('welcome', [
            'categories' => $categories,
            'heroBanners' => $heroBanners,
            'trendingProducts' => $trendingProducts,
            'newArrivals' => $newArrivals,
            'featuredProducts' => $featuredProducts,
            'testimonials' => StorefrontData::testimonials(),
            'galleryItems' => StorefrontData::gallery(),
        ]);
    }

    public function categories()
    {
        $categories = Category::active()->ordered()->with('images')->withCount('products')->paginate(12);

        return view('shop.categories', compact('categories'));
    }

    public function category(Category $category, Request $request)
    {
        $hasSubcategoryColumn = $this->hasSubcategoryColumn();

        $products = Product::query()
            ->with(['images', 'category'])
            ->whereBelongsTo($category)
            ->active()
            ->when($request->string('search')->toString(), fn ($query, $term) => $query->search($term))
            ->when($hasSubcategoryColumn && $request->string('subcategory')->toString(), fn ($query, $value) => $query->where('subcategory', $value))
            ->tap(fn ($query) => $this->applyPriceFilters($query, $request))
            ->sorted($request->input('sort'))
            ->paginate(12)
            ->withQueryString();

        $subcategories = collect();

        if ($hasSubcategoryColumn) {
            $subcategories = Product::whereBelongsTo($category)
                ->whereNotNull('subcategory')
                ->active()
                ->distinct()
                ->orderBy('subcategory')
                ->pluck('subcategory');
        }

        return view('shop.category', compact('category', 'products', 'subcategories'));
    }

    public function products(Request $request)
    {
        $hasSubcategoryColumn = $this->hasSubcategoryColumn();
        $selectedCategory = null;

        if ($request->filled('category')) {
            $selectedCategory = Category::active()->where('slug', $request->string('category'))->first();
        }

        $products = Product::query()
            ->with(['images', 'category'])
            ->active()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category')));
            })
            ->when($hasSubcategoryColumn && $request->string('subcategory')->toString(), fn ($query, $value) => $query->where('subcategory', $value))
            ->when($request->string('search')->toString(), fn ($query, $term) => $query->search($term))
            ->tap(fn ($query) => $this->applyPriceFilters($query, $request))
            ->sorted($request->input('sort'))
            ->paginate(15)
            ->withQueryString();

        $categories = Category::active()->ordered()->get();
        $subcategories = collect();

        if ($hasSubcategoryColumn) {
            $subcategories = Product::query()
                ->active()
                ->when($selectedCategory, fn ($query) => $query->whereBelongsTo($selectedCategory))
                ->whereNotNull('subcategory')
                ->distinct()
                ->orderBy('subcategory')
                ->pluck('subcategory');
        }

        return view('shop.products', compact('products', 'categories', 'subcategories', 'selectedCategory'));
    }

    public function product(Product $product)
    {
        $product->increment('views');
        $product->load(['images', 'variants', 'category', 'reviews.user']);

        $relatedProducts = Product::active()
            ->with(['images', 'category'])
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $hasSubcategoryColumn = $this->hasSubcategoryColumn();
        $term = $request->string('q')->trim()->toString();

        $products = Product::with(['images', 'category'])
            ->active()
            ->when($term, fn ($query) => $query->search($term))
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category')));
            })
            ->when($hasSubcategoryColumn && $request->string('subcategory')->toString(), fn ($query, $value) => $query->where('subcategory', $value))
            ->paginate(15)
            ->withQueryString();

        $categories = Category::active()->ordered()->get();

        return view('shop.search', compact('products', 'term', 'categories'));
    }

    public function wishlist()
    {
        $products = auth()->user()
            ->wishlist()
            ->with('product.images', 'product.category')
            ->latest()
            ->get()
            ->pluck('product')
            ->filter();

        return view('shop.wishlist', compact('products'));
    }

    public function about()
    {
        $categories = Category::active()->ordered()->with('images')->get();

        return view('shop.about', compact('categories'));
    }

    public function contact()
    {
        return view('shop.contact');
    }
}
