@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-16 px-4 bg-gray-50">
    <div class="w-full max-w-lg bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 text-center space-y-6" data-aos="zoom-in">
        <!-- Verification Success Shield -->
        <div class="w-20 h-20 mx-auto rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-4xl shadow-inner border-2 border-emerald-300 animate-bounce">
            <i class="fas fa-check-double"></i>
        </div>

        <div>
            <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Pangkalan Data Resmi Nahdlatul Ulama
            </span>
            <h1 class="text-2xl font-black text-gray-900 font-playfair mt-3">KTA Terverifikasi Asli</h1>
            <p class="text-xs text-gray-500 mt-1">Kartu Tanda Anggota ini sah dan terdaftar dalam pangkalan data organisasi.</p>
        </div>

        <div class="p-6 rounded-2xl bg-gray-50 border border-gray-200/80 text-left space-y-3">
            <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                <img src="{{ $member->foto_url }}" alt="{{ $member->nama_lengkap }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-700 shadow">
                <div>
                    <h2 class="font-bold text-gray-900 text-base leading-tight">{{ $member->nama_lengkap }}</h2>
                    <p class="text-xs text-emerald-700 font-semibold mt-0.5">{{ $member->banom ? $member->banom->nama : 'Warga / Pengurus NU' }}</p>
                    <p class="text-[11px] font-mono text-gray-400 mt-0.5">NIS: {{ $member->nis }}</p>
                </div>
            </div>

            <div class="space-y-2 text-xs text-gray-600 pt-1">
                <div class="flex justify-between">
                    <span class="text-gray-400">Jabatan:</span>
                    <span class="font-semibold text-gray-800">{{ $member->jabatan ?? 'Anggota' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Desa / Wilayah:</span>
                    <span class="font-semibold text-gray-800">{{ $member->desa_kelurahan ?? 'Ranting' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Status Keanggotaan:</span>
                    <span class="font-bold text-emerald-600 capitalize"><i class="fas fa-circle text-[8px] mr-1"></i>{{ $member->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Tanggal Terdaftar:</span>
                    <span class="font-semibold text-gray-800">{{ $member->tanggal_bergabung ? $member->tanggal_bergabung->format('d M Y') : $member->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="text-xs text-gray-400">
            <p>Diverifikasi pada: <span class="font-mono font-semibold text-gray-600">{{ now()->format('d M Y H:i') }} WIB</span></p>
        </div>

        <div class="flex items-center justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-full text-xs font-bold transition">
                <i class="fas fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</div>
@endsection
