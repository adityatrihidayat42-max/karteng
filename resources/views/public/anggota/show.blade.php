@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12 px-4">
    <div class="max-w-4xl mx-auto flex items-center justify-between">
        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200 hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Direktori</span>
        </a>
        <span class="text-xs font-mono bg-white/10 px-3 py-1 rounded-full text-amber-300">
            NIS: {{ $member->nis ?? '-' }}
        </span>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 -mt-8 pb-16">
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100" data-aos="fade-up">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 border-b border-gray-100 pb-8">
            <img src="{{ $member->foto_url }}" alt="{{ $member->nama_lengkap }}" class="w-32 h-32 rounded-3xl object-cover border-4 border-emerald-700 shadow-xl">
            <div class="space-y-2 text-center sm:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 font-playfair">{{ $member->nama_lengkap }}</h1>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <i class="fas fa-check-circle mr-1 text-emerald-600"></i> Anggota Resmi
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-medium">
                    {{ $member->jabatan ? $member->jabatan . ' — ' : '' }} {{ $member->banom ? $member->banom->nama : 'Pengurus Ranting Karangtengah' }}
                </p>
                <div class="text-xs text-gray-400 pt-1 flex flex-wrap items-center justify-center sm:justify-start gap-4">
                    <span><i class="fas fa-calendar-alt text-emerald-600 mr-1"></i> Bergabung: {{ $member->tanggal_bergabung ? $member->tanggal_bergabung->format('d M Y') : $member->created_at->format('d M Y') }}</span>
                    <span><i class="fas fa-map-pin text-emerald-600 mr-1"></i> {{ $member->desa_kelurahan ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8">
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Informasi Keanggotaan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Nomor Induk Santri (NIS)</span>
                        <span class="font-mono font-bold text-gray-800">{{ $member->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Badan Otonom (Banom)</span>
                        <span class="font-semibold text-emerald-700">{{ $member->banom ? $member->banom->nama : 'Umum (PRNU)' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Amanah / Jabatan</span>
                        <span class="font-semibold text-gray-800">{{ $member->jabatan ?? 'Kader / Warga Nahdliyin' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Status Keanggotaan</span>
                        <span class="font-bold text-emerald-600 capitalize">{{ $member->status }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Verifikasi &amp; Legalitas</h3>
                <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-100 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center">
                            <i class="fas fa-shield-alt text-lg"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-emerald-950">Terverifikasi Digital</div>
                            <div class="text-[11px] text-emerald-700">Tercatat pada Pangkalan Data PRNU</div>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-800 leading-relaxed">
                        Data identitas publik ini telah melalui tahapan verifikasi pengurus ranting dan sah sebagai tanda keikutsertaan dalam jam'iyyah.
                    </p>
                    <a href="{{ route('anggota.verify', $member->nis ?? $member->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-900">
                        <i class="fas fa-qrcode"></i>
                        <span>Buka Halaman Verifikasi KTA</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
