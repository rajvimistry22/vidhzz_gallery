<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::ordered()->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', [
            'category' => new Category(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['image'] = $this->storeImage($request, 'image_file', 'categories');
        $data['banner_image'] = $this->storeImage($request, 'banner_image_file', 'categories/banners');

        $category = Category::create($data);
        $this->storeGalleryImages($request, $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $category->load('images');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validatedData($request, $category);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['image'] = $this->storeImage($request, 'image_file', 'categories', $category->image);
        $data['banner_image'] = $this->storeImage($request, 'banner_image_file', 'categories/banners', $category->banner_image);

        $category->update($data);
        $this->storeGalleryImages($request, $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        foreach ($category->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    protected function validatedData(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category?->id)],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'banner_image_file' => ['nullable', 'image', 'max:4096'],
'gallery_image_files.*' => ['nullable', 'image', 'max:8192'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }

    protected function storeImage(Request $request, string $field, string $directory, ?string $currentPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $currentPath;
        }

        if ($currentPath) {
            Storage::disk('public')->delete($currentPath);
        }

        return $request->file($field)->store($directory, 'public');
    }

    protected function storeGalleryImages(Request $request, Category $category): void
    {
        if (! $request->hasFile('gallery_image_files')) {
            return;
        }

        $nextSortOrder = (int) $category->images()->max('sort_order') + 1;

        foreach ($request->file('gallery_image_files') as $file) {
            if (! $file) {
                continue;
            }

            CategoryImage::create([
                'category_id' => $category->id,
                'image_path' => $file->store('categories/gallery', 'public'),
                'alt_text' => $category->name,
                'is_primary' => false,
                'sort_order' => $nextSortOrder++,
            ]);
        }
    }
}
