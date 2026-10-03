@extends('layouts.admin')

@section('page-title', 'Edit Album Galeri')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.galleries.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
        &larr; Kembali ke Daftar Galeri
    </a>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Album <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $gallery->event_date ? $gallery->event_date->format('Y-m-d') : '') }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="published" {{ $gallery->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $gallery->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Kegiatan</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Ganti Foto Sampul</label>
                <input type="file" name="cover_image" accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tambah Foto Baru ke Album (Multiple)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Perbarui Album
                </button>
            </div>
        </form>
    </div>

    <!-- Photos Management in Album -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-3 flex items-center justify-between">
            <span>Foto dalam Album Ini ({{ $gallery->images->count() }})</span>
            <span class="text-xs text-gray-400">Klik tombol hapus untuk membuang foto tertentu</span>
        </h3>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
            @forelse($gallery->images as $img)
                <div class="relative rounded-xl overflow-hidden aspect-square border border-gray-200 group">
                    <img src="{{ asset('storage/' . $img->image) }}" alt="" class="w-full h-full object-cover">
                    <form action="{{ route('admin.galleries.images.destroy', [$gallery->id, $img->id]) }}" method="POST"
                          onsubmit="return confirm('Hapus foto ini?')" class="absolute top-1 right-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px] shadow hover:bg-red-700 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-6 text-center py-6 text-gray-400 text-xs">
                    Belum ada foto dalam album ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
