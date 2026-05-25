<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="label">Title</label>
        <input name="title" value="{{ old('title', $banner->title) }}" class="input" required>
    </div>
    <div>
        <label class="label">Subtitle</label>
        <input name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="input">
    </div>
    <div>
        <label class="label">Desktop image</label>
        <input type="file" name="image_file" accept="image/*" class="input" {{ $banner->exists ? '' : 'required' }}>
        @if ($banner->image)
            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="mt-3 h-24 w-40 rounded-xl object-cover">
        @endif
    </div>
    <div>
        <label class="label">Mobile image</label>
        <input type="file" name="mobile_image_file" accept="image/*" class="input">
        @if ($banner->mobile_image)
            <img src="{{ asset('storage/' . $banner->mobile_image) }}" alt="{{ $banner->title }}" class="mt-3 h-24 w-32 rounded-xl object-cover">
        @endif
    </div>
    <div>
        <label class="label">CTA text</label>
        <input name="cta_text" value="{{ old('cta_text', $banner->cta_text) }}" class="input">
    </div>
    <div>
        <label class="label">CTA URL</label>
        <input name="cta_url" value="{{ old('cta_url', $banner->cta_url) }}" class="input">
    </div>
    <div>
        <label class="label">Badge text</label>
        <input name="badge_text" value="{{ old('badge_text', $banner->badge_text) }}" class="input">
    </div>
    <div>
        <label class="label">Position</label>
        <select name="position" class="input">
            @foreach (['hero', 'category', 'promo'] as $position)
                <option value="{{ $position }}" @selected(old('position', $banner->position ?: 'hero') === $position)>{{ ucfirst($position) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Sort order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" class="input">
    </div>
    <div class="flex items-center gap-3 pt-8">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active ?? true))>
        <label class="text-sm text-stone-700">Active</label>
    </div>
</div>
