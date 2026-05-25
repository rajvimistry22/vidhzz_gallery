<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create', ['banner' => new Banner()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request, true);
        $data['image'] = $request->file('image_file')->store('banners', 'public');
        $data['mobile_image'] = $request->hasFile('mobile_image_file')
            ? $request->file('mobile_image_file')->store('banners/mobile', 'public')
            : null;

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image_file')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image_file')->store('banners', 'public');
        }

        if ($request->hasFile('mobile_image_file')) {
            if ($banner->mobile_image) {
                Storage::disk('public')->delete($banner->mobile_image);
            }
            $data['mobile_image'] = $request->file('mobile_image_file')->store('banners/mobile', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        if ($banner->mobile_image) {
            Storage::disk('public')->delete($banner->mobile_image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    protected function validatedData(Request $request, bool $isCreate = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'position' => ['required', 'in:hero,category,promo'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
'image_file' => [$isCreate ? 'required' : 'nullable', 'image', 'max:8192'],
'mobile_image_file' => ['nullable', 'image', 'max:8192'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
