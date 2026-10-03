@extends('layouts.admin')

@section('page-title', 'Manajemen Galeri')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Album & Dokumentasi Foto</h2>
            <p class="text-xs text-gray-500">Kelola album kegiatan dan kumpulan foto dokumentasi.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
            <i class="fas fa-camera"></i>
            <span>Buat Album Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($galleries as $g)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="relative aspect-video bg-emerald-900 overflow-hidden">
                        @if($g->cover_image)
                            <img src="{{ asset('storage/' . $g->cover_image) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/30 text-3xl">
                                <i class="fas fa-images"></i>
                            </div>
                        @endif
                        <span class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $g->images_count }} Foto
                        </span>
                    </div>

                    <div class="p-4 space-y-1">
                        <span class="text-[10px] text-gray-400 block">{{ $g->event_date ? $g->event_date->format('d M Y') : $g->created_at->format('d M Y') }}</span>
                        <h4 class="font-bold text-gray-800 text-sm leading-snug line-clamp-1">{{ $g->title }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $g->description }}</p>
                    </div>
                </div>

                <div class="p-4 pt-2 border-t border-gray-100 flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $g->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($g->status) }}
                    </span>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.galleries.edit', $g->id) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta seluruh fotonya?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-white rounded-2xl p-8 text-center border border-gray-100 text-gray-400 text-xs">
                Belum ada album galeri.
            </div>
        @endforelse
    </div>

    <div>
        {{ $galleries->links() }}
    </div>
</div>
@endsection
