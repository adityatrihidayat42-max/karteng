<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('images')->latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(1000, 9999);
        $validated['created_by'] = Auth::id() ?? 1;

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        $gallery = Gallery::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $idx => $imageFile) {
                $path = $imageFile->store('galleries', 'public');
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'sort_order' => $idx,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri berhasil dibuat.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        $gallery->update($validated);

        if ($request->hasFile('images')) {
            $startOrder = $gallery->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $idx => $imageFile) {
                $path = $imageFile->store('galleries', 'public');
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'sort_order' => $startOrder + $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        foreach ($gallery->images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri beserta seluruh fotonya berhasil dihapus.');
    }

    public function destroyImage(Gallery $gallery, GalleryImage $image)
    {
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
