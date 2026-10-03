@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12 px-4">
    <div class="max-w-6xl mx-auto space-y-3">
        <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200 hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Semua Album</span>
        </a>
        <h1 class="text-2xl sm:text-4xl font-extrabold font-playfair text-white leading-tight">
            {{ $gallery->title }}
        </h1>
        <div class="flex items-center gap-4 text-xs text-emerald-200 pt-1">
            <span><i class="fas fa-calendar-alt mr-1"></i> {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : $gallery->created_at->format('d M Y') }}</span>
            <span>&bull;</span>
            <span><i class="fas fa-camera mr-1"></i> {{ $gallery->images->count() }} Dokumentasi Foto</span>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-8">
    @if($gallery->description)
        <div class="bg-white rounded-2xl p-6 border border-gray-100 text-gray-700 text-sm leading-relaxed shadow-sm">
            {{ $gallery->description }}
        </div>
    @endif

    <!-- Photo Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @forelse($gallery->images as $img)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group">
                <div class="relative aspect-square overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?? $gallery->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                @if($img->caption)
                    <div class="p-3 text-xs text-gray-600 truncate">
                        {{ $img->caption }}
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-4 py-8 text-center text-gray-400 text-xs">
                Album ini belum memiliki foto di dalamnya.
            </div>
        @endforelse
    </div>
</div>
@endsection
