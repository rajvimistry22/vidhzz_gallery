<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->search($request->string('search')->toString());
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category')));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => Category::ordered()->get(),
            'imagePath' => '',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $product = Product::create($data);
        $this->syncPrimaryImage($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('primaryImage', 'images');

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::ordered()->get(),
            'imagePath' => $product->primaryImage?->image_path ?? '',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request, $product);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $product->update($data);
        $this->syncPrimaryImage($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    protected function validatedData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product?->id)],
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product?->id)],
            'subcategory' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'weight' => ['nullable', 'string', 'max:50'],
            'sizes' => ['nullable', 'string'],
            'colors' => ['nullable', 'string'],
            'material' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_trending' => ['nullable', 'boolean'],
            'is_new_arrival' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'primary_image_file' => ['nullable', 'image', 'max:4096'],
'gallery_image_files.*' => ['nullable', 'image', 'max:8192'],
        ]);

        $data['sizes'] = $this->csvToArray($request->input('sizes'));
        $data['colors'] = $this->csvToArray($request->input('colors'));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['unit'] = $request->input('unit', 'piece');

        unset($data['primary_image_file']);

        return $data;
    }

    protected function csvToArray(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    protected function syncPrimaryImage(Product $product, Request $request): void
    {
        if (! $request->hasFile('primary_image_file')) {
            $this->storeGalleryImages($product, $request);
            return;
        }

        $product->images()->where('is_primary', true)->each(function ($image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();
        });

        $imagePath = $request->file('primary_image_file')->store('products', 'public');

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'alt_text' => $product->name,
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $this->storeGalleryImages($product, $request);
    }

    protected function storeGalleryImages(Product $product, Request $request): void
    {
        if (! $request->hasFile('gallery_image_files')) {
            return;
        }

        $nextSortOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($request->file('gallery_image_files') as $file) {
            if (! $file) {
                continue;
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $file->store('products/gallery', 'public'),
                'alt_text' => $product->name,
                'is_primary' => false,
                'sort_order' => $nextSortOrder++,
            ]);
        }
    }

    public function deletePrimaryImage(Product $product)
    {
        $primaryImage = $product->primaryImage;
        if ($primaryImage) {
            if ($primaryImage->image_path) {
                Storage::disk('public')->delete($primaryImage->image_path);
            }
            $primaryImage->delete();
        }

        return response()->json(['success' => true]);
    }

    public function deleteGalleryImage(ProductImage $image)
    {
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }
}
