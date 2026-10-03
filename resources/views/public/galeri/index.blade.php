@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Dokumentasi
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Galeri Foto Jam'iyyah</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Koleksi dokumentasi visual kegiatan, pengajian, aksi sosial, dan peringatan hari besar Islam.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <a href="{{ route('galeri.show', $gallery->slug) }}" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 80 }}"
               class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 card-hover group block">
                <div class="relative aspect-video bg-emerald-900 overflow-hidden">
                    @if($gallery->cover_image)
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/30 text-4xl">
                            <i class="fas fa-images"></i>
                        </div>
                    @endif
                    <span class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1.5">
                        <i class="fas fa-camera text-[10px]"></i>
                        <span>{{ $gallery->images->count() }} Foto</span>
                    </span>
                </div>
                <div class="p-6 space-y-2">
                    <span class="text-[11px] font-semibold text-emerald-700 block">
                        {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : $gallery->created_at->format('d M Y') }}
                    </span>
                    <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-emerald-700 transition">
                        {{ $gallery->title }}
                    </h3>
                    @if($gallery->description)
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $gallery->description }}</p>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-3 bg-white rounded-3xl p-12 text-center border border-gray-100 text-gray-400">
                <i class="fas fa-images text-4xl mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">Belum Ada Album Foto</h3>
                <p class="text-xs text-gray-500 mt-1">Dokumentasi kegiatan akan segera dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $galleries->links() }}
    </div>
</div>
@endsection
