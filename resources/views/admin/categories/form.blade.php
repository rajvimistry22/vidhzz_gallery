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
        <input type="file" name="image_file" accept="image/*" class="input">
        @if (!empty($category->image))
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="mt-3 h-24 w-24 rounded-xl object-cover">
        @endif
    </div>
    <div>
        <label class="label">Banner image</label>
        <input type="file" name="banner_image_file" accept="image/*" class="input">
        @if (!empty($category->banner_image))
            <img src="{{ $category->banner_url }}" alt="{{ $category->name }}" class="mt-3 h-24 w-40 rounded-xl object-cover">
        @endif
    </div>
    <div class="lg:col-span-2">
        <label class="label">Gallery images</label>
        <input type="file" name="gallery_image_files[]" accept="image/*" multiple class="input">
        @if ($category->exists && $category->images->isNotEmpty())
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($category->images as $image)
                    <div class="overflow-hidden rounded-xl border border-stone-200 bg-stone-50 p-2">
                        <img src="{{ $image->url }}" alt="{{ $category->name }}" class="h-24 w-full rounded-lg object-cover">
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
