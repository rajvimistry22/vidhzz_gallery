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
        <input type="file" id="primary_image_input" name="primary_image_file" accept="image/*" class="input" onchange="previewSingleImage(this, 'primary_image_preview_container', 'primary_image_preview_img', 'existing_primary_image_container')">
        
        {{-- Selected file preview --}}
        <div class="mt-3 relative inline-block group" id="primary_image_preview_container" style="display: none;">
            <img id="primary_image_preview_img" src="" class="h-24 w-24 rounded-xl object-cover border border-stone-200 shadow-sm">
            <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="clearSelectedFile('primary_image_input', 'primary_image_preview_container', 'existing_primary_image_container')">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Existing image preview --}}
        @if (!empty($imagePath))
            <div class="mt-3 relative inline-block group" id="existing_primary_image_container">
                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }}" class="h-24 w-24 rounded-xl object-cover border border-stone-200 shadow-sm">
                <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="deleteExistingImage('{{ route('admin.products.delete-primary-image', $product) }}', 'existing_primary_image_container')">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        @endif
    </div>
    <div class="lg:col-span-2">
        <label class="label">Gallery images</label>
        <input type="file" id="product_gallery_input" name="gallery_image_files[]" accept="image/*" multiple class="input" onchange="previewMultipleImages(this, 'product_gallery_preview_container')">
        
        {{-- Selected gallery preview --}}
        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4" id="product_gallery_preview_container"></div>

        {{-- Existing gallery images --}}
        @if ($product->exists && $product->images->where('is_primary', false)->isNotEmpty())
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($product->images->where('is_primary', false) as $image)
                    <div class="relative overflow-hidden rounded-xl border border-stone-200 bg-stone-50 p-2 group" id="existing_gallery_container_{{ $image->id }}">
                        <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-24 w-full rounded-lg object-cover">
                        <button type="button" class="absolute top-2 right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition opacity-0 group-hover:opacity-100 focus:opacity-100" onclick="deleteExistingImage('{{ route('admin.products.delete-gallery-image', $image->id) }}', 'existing_gallery_container_{{ $image->id }}')">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
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

<script>
    function previewSingleImage(input, previewContainerId, previewImgId, existingContainerId) {
        const previewContainer = document.getElementById(previewContainerId);
        const previewImg = document.getElementById(previewImgId);
        const existingContainer = document.getElementById(existingContainerId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'inline-block';
                if (existingContainer) {
                    existingContainer.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearSelectedFile(inputId, previewContainerId, existingContainerId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const existingContainer = document.getElementById(existingContainerId);

        input.value = '';
        previewContainer.style.display = 'none';
        if (existingContainer) {
            existingContainer.style.display = 'inline-block';
        }
    }

    function previewMultipleImages(input, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative overflow-hidden rounded-xl border border-stone-200 bg-stone-50 p-2 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="h-24 w-full rounded-lg object-cover">
                        <button type="button" class="absolute top-2 right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="removeSelectedGalleryFile(this, ${index}, '${input.id}', '${containerId}')">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function removeSelectedGalleryFile(buttonEl, index, inputId, containerId) {
        const input = document.getElementById(inputId);
        const dt = new DataTransfer();
        const { files } = input;
        
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
            }
        }
        
        input.files = dt.files;
        previewMultipleImages(input, containerId);
    }

    function deleteExistingImage(url, containerId) {
        if (!confirm('Are you sure you want to delete this image permanently?')) {
            return;
        }
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById(containerId);
                if (el) el.remove();
            } else {
                alert(data.message || 'Failed to delete image.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the image.');
        });
    }
</script>
