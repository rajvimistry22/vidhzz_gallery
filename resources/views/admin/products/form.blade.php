@php
    $sizeValue = old('sizes', isset($product->sizes) ? implode(', ', $product->sizes ?? []) : '');
    $colorValue = old('colors', isset($product->colors) ? implode(', ', $product->colors ?? []) : '');
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="label">Category</label>
        <select name="category_id" class="input" required>
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Subcategory</label>
        <input name="subcategory" value="{{ old('subcategory', $product->subcategory) }}" class="input" placeholder="earrings, keychain, haldi-accessories">
    </div>
    <div>
        <label class="label">Product name</label>
        <input name="name" value="{{ old('name', $product->name) }}" class="input" required>
    </div>
    <div>
        <label class="label">Slug</label>
        <input name="slug" value="{{ old('slug', $product->slug) }}" class="input" placeholder="auto-generated if blank">
    </div>
    <div>
        <label class="label">SKU</label>
        <input name="sku" value="{{ old('sku', $product->sku) }}" class="input" required>
    </div>
    <div>
        <label class="label">Primary image</label>
        <input type="file" name="primary_image_file" accept="image/*" class="input">
        @if (!empty($imagePath))
            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }}" class="mt-3 h-24 w-24 rounded-xl object-cover">
        @endif
    </div>
    <div class="lg:col-span-2">
        <label class="label">Gallery images</label>
        <input type="file" name="gallery_image_files[]" accept="image/*" multiple class="input">
        @if ($product->exists && $product->images->isNotEmpty())
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($product->images as $image)
                    <div class="overflow-hidden rounded-xl border border-stone-200 bg-stone-50 p-2">
                        <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-24 w-full rounded-lg object-cover">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="lg:col-span-2">
        <label class="label">Short description</label>
        <textarea name="short_description" rows="3" class="input">{{ old('short_description', $product->short_description) }}</textarea>
    </div>
    <div class="lg:col-span-2">
        <label class="label">Full description</label>
        <textarea name="description" rows="5" class="input">{{ old('description', $product->description) }}</textarea>
    </div>
    <div>
        <label class="label">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="input" required>
    </div>
    <div>
        <label class="label">Sale price</label>
        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="input">
    </div>
    <div>
        <label class="label">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="input" required>
    </div>
    <div>
        <label class="label">Unit</label>
        <input name="unit" value="{{ old('unit', $product->unit ?: 'piece') }}" class="input">
    </div>
    <div>
        <label class="label">Weight</label>
        <input name="weight" value="{{ old('weight', $product->weight) }}" class="input">
    </div>
    <div>
        <label class="label">Material</label>
        <input name="material" value="{{ old('material', $product->material) }}" class="input">
    </div>
    <div>
        <label class="label">Sizes</label>
        <input name="sizes" value="{{ $sizeValue }}" class="input" placeholder="One Size, Adjustable, 2.4">
    </div>
    <div>
        <label class="label">Colors</label>
        <input name="colors" value="{{ $colorValue }}" class="input" placeholder="Red, Gold, Multicolor">
    </div>
    <div>
        <label class="label">Sort order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="input">
    </div>
    <div class="grid gap-3 sm:grid-cols-2">
        <label class="flex items-center gap-3 rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-700">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
            Featured
        </label>
        <label class="flex items-center gap-3 rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-700">
            <input type="hidden" name="is_trending" value="0">
            <input type="checkbox" name="is_trending" value="1" @checked(old('is_trending', $product->is_trending ?? false))>
            Trending
        </label>
        <label class="flex items-center gap-3 rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-700">
            <input type="hidden" name="is_new_arrival" value="0">
            <input type="checkbox" name="is_new_arrival" value="1" @checked(old('is_new_arrival', $product->is_new_arrival ?? false))>
            New arrival
        </label>
        <label class="flex items-center gap-3 rounded-xl border border-stone-200 px-4 py-3 text-sm text-stone-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
            Active
        </label>
    </div>
</div>
