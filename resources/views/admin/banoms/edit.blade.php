@extends('layouts.admin')

@section('page-title', 'Edit Badan Otonom')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <a href="{{ route('admin.banoms.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
        &larr; Kembali ke Daftar Banom
    </a>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.banoms.update', $banom->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Banom <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $banom->nama) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $banom->singkatan) }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Banom</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">{{ old('deskripsi', $banom->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Ketua</label>
                    <input type="text" name="ketua" value="{{ old('ketua', $banom->ketua) }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kontak / No HP</label>
                    <input type="text" name="kontak" value="{{ old('kontak', $banom->kontak) }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="active" {{ $banom->status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $banom->status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Logo Banom</label>
                <div class="flex items-center gap-4">
                    @if($banom->logo)
                        <img src="{{ asset('storage/' . $banom->logo) }}" alt="" class="w-12 h-12 object-contain rounded-xl border border-gray-200 p-1">
                    @endif
                    <input type="file" name="logo" accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.banoms.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Perbarui Banom
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
