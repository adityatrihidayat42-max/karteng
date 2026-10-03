@extends('layouts.admin')

@section('page-title', 'Buat Album Galeri')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <a href="{{ route('admin.galleries.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
        &larr; Kembali ke Daftar Galeri
    </a>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Album / Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Peringatan Maulid Nabi Muhammad SAW 1446 H"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="published">Published (Publikasikan)</option>
                        <option value="draft">Draft (Simpan Draf)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Kegiatan</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Foto Sampul (Cover Image)</label>
                <input type="file" name="cover_image" accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Upload Foto-Foto Kegiatan Sekaligus (Multiple)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                <p class="text-[10px] text-gray-400 mt-1">Anda bisa memilih banyak foto sekaligus (Ctrl / Shift + klik).</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Simpan Album & Foto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
