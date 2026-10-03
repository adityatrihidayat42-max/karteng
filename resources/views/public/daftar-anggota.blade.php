@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-3xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Registrasi Digital
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Pendaftaran Anggota NU</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Bergabunglah dalam barisan Nahdlatul Ulama. Dapatkan Kartu Tanda Anggota (KTA) digital resmi setelah diverifikasi.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100" data-aos="fade-up">

        @if(session('success'))
            <div class="mb-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start gap-4">
                <i class="fas fa-check-circle text-emerald-600 text-2xl mt-0.5"></i>
                <div class="space-y-1">
                    <h3 class="font-bold text-base">Alhamdulillah, Pendaftaran Berhasil Terkirim!</h3>
                    <p class="text-xs sm:text-sm text-emerald-800 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-6 rounded-2xl bg-red-50 border border-red-200 text-red-900">
                <div class="flex items-center gap-2 font-bold text-sm text-red-700 mb-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Terdapat beberapa kesalahan pengisian form:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('daftar-anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Bagian 1: Data Identitas -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center">1</span>
                    <span>Identitas Diri</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                               placeholder="Contoh: Ahmad Fauzi, S.Pd.">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            NIK (Nomor Induk Kependudukan) 16 Digit
                        </label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                               placeholder="330xxxxxxxxxxxxx">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                               placeholder="Kota / Kabupaten Lahir">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Nomor WhatsApp / HP Aktif <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                               placeholder="081234567890">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                               placeholder="nama@email.com">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Alamat Domisili -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center">2</span>
                    <span>Alamat Domisili</span>
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Alamat Jalan / Dusun / Gang <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" rows="2" required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition"
                                  placeholder="Nama jalan, nomor rumah, atau patokan...">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">RT</label>
                            <input type="text" name="rt" value="{{ old('rt') }}" maxlength="5"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none" placeholder="001">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">RW</label>
                            <input type="text" name="rw" value="{{ old('rw') }}" maxlength="5"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none" placeholder="002">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Organisasi & Foto -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center">3</span>
                    <span>Afiliasi Banom & Pas Foto</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Badan Otonom (Banom)
                        </label>
                        <select name="banom_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none transition">
                            <option value="">-- Pengurus / Warga NU Umum --</option>
                            @foreach($banoms as $b)
                                <option value="{{ $b->id }}" {{ old('banom_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama }} ({{ $b->singkatan }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-gray-400 mt-1">Pilih sesuai keterikatan banom Anda (Ansor, Banser, Fatayat, IPNU, IPPNU, dll).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            Pas Foto (Untuk KTA Digital)
                        </label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200">
                        <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB. Disarankan foto formal.</p>
                    </div>
                </div>
            </div>

            <!-- Persetujuan -->
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-3">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="persetujuan" value="1" required
                           class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 mt-1">
                    <span class="text-xs text-gray-700 leading-relaxed">
                        Saya dengan sungguh-sungguh menyatakan kesediaan menjadi anggota Nahdlatul Ulama, siap mentaati Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART), mengamalkan aqidah Islam Ahlussunnah wal Jama'ah an-Nahdliyyah, dan menjaga nama baik jam'iyyah.
                    </span>
                </label>
            </div>

            <div class="text-center pt-2">
                <button type="submit"
                        class="px-10 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold rounded-full shadow-lg shadow-emerald-700/30 hover:scale-105 transition-all text-sm sm:text-base inline-flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Formulir Pendaftaran</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
