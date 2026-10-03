<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('images')
            ->where('status', 'published')
            ->latest('event_date')
            ->paginate(9);

        return view('public.galeri.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        if ($gallery->status !== 'published') {
            abort(404);
        }

        $gallery->load('images', 'creator');

        return view('public.galeri.show', compact('gallery'));
    }
}
