@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4">
    <div class="max-w-5xl mx-auto space-y-4">
        <a href="{{ route('banom.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200 hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar Banom</span>
        </a>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-2">
            <div class="w-20 h-20 rounded-3xl bg-white p-3 shadow-xl flex items-center justify-center flex-shrink-0">
                @if($banom->logo)
                    <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->nama }}" class="w-full h-full object-contain">
                @else
                    <i class="fas fa-users-cog text-emerald-700 text-3xl"></i>
                @endif
            </div>
            <div>
                <span class="text-xs font-bold text-amber-300 uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full">
                    {{ $banom->singkatan }}
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold font-playfair text-white mt-1">{{ $banom->nama }}</h1>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1">Pimpinan Ranting / Anak Cabang</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-12 space-y-12">
    <!-- Deskripsi & Kontak -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Tentang {{ $banom->singkatan ?? $banom->nama }}</h3>
            <div class="text-gray-600 text-sm leading-relaxed space-y-3">
                {!! nl2br(e($banom->deskripsi ?? 'Wadah badan otonom Nahdlatul Ulama yang berkhidmat di tingkat ranting/anak cabang.')) !!}
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Informasi Kepengurusan</h3>
            <div class="space-y-3 text-xs text-gray-600">
                <div>
                    <span class="text-gray-400 block">Ketua / Komandan:</span>
                    <span class="font-bold text-gray-800 text-sm">{{ $banom->ketua ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block">Kontak Sekretariat:</span>
                    <span class="font-semibold text-gray-800">{{ $banom->kontak ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block">Alamat / Posko:</span>
                    <span class="text-gray-800">{{ $banom->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kader Terdaftar -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900 font-playfair">
                Kader & Anggota {{ $banom->singkatan }}
            </h2>
            <a href="{{ route('daftar-anggota') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                + Gabung {{ $banom->singkatan }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($members as $member)
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center card-hover">
                    <img src="{{ $member->foto_url }}" alt="{{ $member->nama_lengkap }}" class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-emerald-700 mb-3 shadow">
                    <h4 class="font-bold text-gray-800 text-sm leading-tight">{{ $member->nama_lengkap }}</h4>
                    <span class="text-xs text-emerald-700 font-medium block mt-1">{{ $member->jabatan ?? 'Anggota' }}</span>
                </div>
            @empty
                <div class="col-span-4 bg-white rounded-2xl p-8 text-center border border-gray-100 text-gray-400 text-xs">
                    Belum ada kader terdaftar yang ditampilkan untuk banom ini.
                </div>
            @endforelse
        </div>

        <div>
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection
