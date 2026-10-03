@extends('layouts.admin')

@section('page-title', 'Tulis Warta Berita')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
        &larr; Kembali ke Daftar Berita
    </a>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Tuliskan judul berita yang menarik..."
                       class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white focus:border-emerald-600 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status Publikasi <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Langsung Terbit)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan Draf)</option>
                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Ringkasan / Excerpt</label>
                <textarea name="excerpt" rows="2" placeholder="Ringkasan singkat berita..."
                          class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Konten Lengkap Berita <span class="text-red-500">*</span></label>
                <textarea name="content" rows="10" required placeholder="Tuliskan isi berita selengkapnya di sini..."
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:border-emerald-600 outline-none leading-relaxed">{{ old('content') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Gambar Utama (Featured Image)</label>
                <input type="file" name="featured_image" accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                <p class="text-[10px] text-gray-400 mt-1">Maks 3MB. Format JPG, PNG, WEBP.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Terbitkan Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
