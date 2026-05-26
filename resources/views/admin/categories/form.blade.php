<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="label">Category name</label>
        <input name="name" value="{{ old('name', $category->name) }}" class="input" required>
    </div>
    <div>
        <label class="label">Slug</label>
        <input name="slug" value="{{ old('slug', $category->slug) }}" class="input" placeholder="auto-generated if blank">
    </div>
    <div class="lg:col-span-2">
        <label class="label">Description</label>
        <textarea name="description" rows="4" class="input">{{ old('description', $category->description) }}</textarea>
    </div>
    <div>
        <label class="label">Category image</label>
        <input type="file" id="category_image_input" name="image_file" accept="image/*" class="input" onchange="previewSingleImage(this, 'category_image_preview_container', 'category_image_preview_img', 'existing_category_image_container')">
        
        {{-- Selected file preview --}}
        <div class="mt-3 relative inline-block group" id="category_image_preview_container" style="display: none;">
            <img id="category_image_preview_img" src="" class="h-24 w-24 rounded-xl object-cover border border-stone-200 shadow-sm">
            <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="clearSelectedFile('category_image_input', 'category_image_preview_container', 'existing_category_image_container')">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Existing image preview --}}
        @if (!empty($category->image))
            <div class="mt-3 relative inline-block group" id="existing_category_image_container">
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-24 w-24 rounded-xl object-cover border border-stone-200 shadow-sm">
                <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="deleteExistingImage('{{ route('admin.categories.delete-image', $category) }}', 'existing_category_image_container')">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        @endif
    </div>
    <div>
        <label class="label">Banner image</label>
        <input type="file" id="banner_image_input" name="banner_image_file" accept="image/*" class="input" onchange="previewSingleImage(this, 'banner_image_preview_container', 'banner_image_preview_img', 'existing_banner_image_container')">
        
        {{-- Selected file preview --}}
        <div class="mt-3 relative inline-block group" id="banner_image_preview_container" style="display: none;">
            <img id="banner_image_preview_img" src="" class="h-24 w-40 rounded-xl object-cover border border-stone-200 shadow-sm">
            <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="clearSelectedFile('banner_image_input', 'banner_image_preview_container', 'existing_banner_image_container')">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Existing image preview --}}
        @if (!empty($category->banner_image))
            <div class="mt-3 relative inline-block group" id="existing_banner_image_container">
                <img src="{{ $category->banner_url }}" alt="{{ $category->name }}" class="h-24 w-40 rounded-xl object-cover border border-stone-200 shadow-sm">
                <button type="button" class="absolute -top-2 -right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition" onclick="deleteExistingImage('{{ route('admin.categories.delete-banner', $category) }}', 'existing_banner_image_container')">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        @endif
    </div>
    <div class="lg:col-span-2">
        <label class="label">Gallery images</label>
        <input type="file" id="category_gallery_input" name="gallery_image_files[]" accept="image/*" multiple class="input" onchange="previewMultipleImages(this, 'category_gallery_preview_container')">
        
        {{-- Selected gallery preview --}}
        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4" id="category_gallery_preview_container"></div>

        {{-- Existing gallery images --}}
        @if ($category->exists && $category->images->isNotEmpty())
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($category->images as $image)
                    <div class="relative overflow-hidden rounded-xl border border-stone-200 bg-stone-50 p-2 group" id="existing_gallery_container_{{ $image->id }}">
                        <img src="{{ $image->url }}" alt="{{ $category->name }}" class="h-24 w-full rounded-lg object-cover">
                        <button type="button" class="absolute top-2 right-2 bg-rose-600 hover:bg-rose-700 text-white rounded-full p-1.5 shadow-md flex items-center justify-center transition opacity-0 group-hover:opacity-100 focus:opacity-100" onclick="deleteExistingImage('{{ route('admin.categories.delete-gallery-image', $image->id) }}', 'existing_gallery_container_{{ $image->id }}')">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div>
        <label class="label">Sort order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="input">
    </div>
    <div class="flex items-center gap-3 pt-8">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
        <label class="text-sm text-stone-700">Active</label>
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
