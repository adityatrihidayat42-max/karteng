@extends('layouts.admin')

@section('page-title', 'Tambah Anggota Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
            &larr; Kembali ke Daftar Anggota
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Data Pribadi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Alamat Domisili</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RT</label>
                            <input type="text" name="rt" value="{{ old('rt') }}" class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">RW</label>
                            <input type="text" name="rw" value="{{ old('rw') }}" class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Desa/Kelurahan</label>
                            <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Status & Organisasi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Badan Otonom (Banom)</label>
                        <select name="banom_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                            <option value="">-- Warga NU / Pengurus --</option>
                            @foreach($banoms as $b)
                                <option value="{{ $b->id }}" {{ old('banom_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama }} ({{ $b->singkatan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jabatan / Amanah</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Anggota, Pengurus Tanfidziyah"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Keanggotaan <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif (Terbitkan NIS Otomatis)</option>
                            <option value="menunggu_verifikasi" {{ old('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-2 mb-4">Foto & Privasi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Pas Foto Anggota</label>
                        <input type="file" name="foto" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer mt-3 sm:mt-0">
                            <input type="checkbox" name="tampil_publik" value="1" {{ old('tampil_publik', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 rounded border-gray-300">
                            <span class="text-xs font-semibold text-gray-700">Tampilkan di Direktori Publik</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500 hover:text-gray-700">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow transition">
                    Simpan Anggota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
