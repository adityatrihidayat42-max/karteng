@extends('layouts.admin')

@section('page-title', 'Profil Organisasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Pengaturan Profil Organisasi</h2>
        <p class="text-xs text-gray-500">Informasi nama ranting, sejarah, visi misi, rekening donasi, dan kontak sekretariat.</p>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.organization.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Identitas Utama -->
            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Identitas Ranting / Wilayah</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_organisasi" value="{{ old('nama_organisasi', $profile->nama_organisasi) }}" required
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tingkatan Organisasi</label>
                        <input type="text" name="tingkat" value="{{ old('tingkat', $profile->tingkat ?? 'Pengurus Ranting') }}" placeholder="Pengurus Ranting / MWC"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Wilayah / Desa</label>
                        <input type="text" name="wilayah" value="{{ old('wilayah', $profile->wilayah) }}" placeholder="Contoh: Desa Gumelar"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Kepengurusan</label>
                        <input type="text" name="periode" value="{{ old('periode', $profile->periode) }}" placeholder="Contoh: 2024 - 2029"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Semboyan / Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                </div>
            </div>

            <!-- Narasi Profil -->
            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Visi, Misi & Sejarah</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tentang Organisasi Singkat</label>
                        <textarea name="tentang" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('tentang', $profile->tentang) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Visi</label>
                            <textarea name="visi" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('visi', $profile->visi) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Misi</label>
                            <textarea name="misi" rows="3" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('misi', $profile->misi) }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Sejarah Singkat Ranting</label>
                        <textarea name="sejarah" rows="4" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('sejarah', $profile->sejarah) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Rekening Infaq / Donasi -->
            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Rekening Infaq & Donasi Resmi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Bank</label>
                        <input type="text" name="rekening_bank" value="{{ old('rekening_bank', $profile->rekening_bank) }}" placeholder="BSI / BRI / Mandiri"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening', $profile->nomor_rekening) }}" placeholder="7123-4567-8901"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Atas Nama Rekening</label>
                        <input type="text" name="nama_rekening" value="{{ old('nama_rekening', $profile->nama_rekening) }}" placeholder="PRNU Gumelar"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Foto / Barcode QRIS Resmi (Infaq Tanpa Minimal)</label>
                    <div class="flex items-center gap-4">
                        @if($profile->qris_image)
                            <div class="w-16 h-16 rounded-xl border border-gray-200 p-1 bg-white flex items-center justify-center">
                                <img src="{{ asset('storage/' . $profile->qris_image) }}" alt="QRIS" class="w-full h-full object-contain">
                            </div>
                        @endif
                        <div>
                            <input type="file" name="qris_image" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                            <p class="text-[10px] text-gray-400 mt-1">Unggah gambar QRIS ranting (GoPay, OVO, Dana, ShopeePay, BCA, Livin, BSI, dll). Format JPG, PNG.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak & Alamat -->
            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Kontak & Alamat Sekretariat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Kantor / Gedung Sekretariat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $profile->alamat) }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp Resmi</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" placeholder="628123456789"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Email Resmi</label>
                        <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Logo Organisasi</label>
                        <input type="file" name="logo" accept="image/*" class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
