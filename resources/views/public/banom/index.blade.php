@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Sayap Pergerakan
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Direktori Badan Otonom (BANOM)</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Wadah perjuangan dan kaderisasi warga nahdliyin berbasis usia, profesi, dan kelompok kemasyarakatan.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($banoms as $banom)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-lg shadow-gray-200/50 card-hover flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-2xl text-emerald-700 font-bold p-2">
                            @if($banom->logo)
                                <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->nama }}" class="w-full h-full object-contain">
                            @else
                                <i class="fas fa-users-cog"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-extrabold text-gray-900 text-lg leading-tight">{{ $banom->nama }}</h3>
                            <span class="inline-block text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full mt-1">
                                {{ $banom->singkatan ?? 'BANOM' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                        {{ $banom->deskripsi ?? 'Wadah pengkaderan dan pergerakan di lingkungan Nahdlatul Ulama.' }}
                    </p>

                    <div class="space-y-2 pt-2 border-t border-gray-50 text-xs text-gray-600">
                        @if($banom->ketua)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-tie text-emerald-600 w-4 text-center"></i>
                                <span>Ketua: <strong>{{ $banom->ketua }}</strong></span>
                            </div>
                        @endif
                        @if($banom->kontak)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-emerald-600 w-4 text-center"></i>
                                <span>{{ $banom->kontak }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-6 mt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-400">
                        <strong>{{ $banom->members_count ?? 0 }}</strong> Kader Aktif
                    </span>
                    <a href="{{ route('banom.show', $banom->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-900 group">
                        <span>Lihat Banom</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-400">
                <i class="fas fa-sitemap text-3xl mb-2"></i>
                <p>Belum ada data banom yang terdaftar.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
