@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Database Nahdliyin
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Direktori Anggota</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Daftar kader dan anggota Nahdlatul Ulama yang terdaftar secara resmi di pangkalan data ranting.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-8">
    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100" data-aos="fade-up">
        <form action="{{ route('anggota.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-2 relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama lengkap atau NIS..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
            </div>

            <div>
                <select name="banom_id" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                    <option value="">Semua Banom</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->singkatan ?? $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-semibold transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'banom_id', 'jabatan']))
                    <a href="{{ route('anggota.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-semibold transition flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Members Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($members as $member)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover flex flex-col items-center text-center">
                <div class="relative mb-4">
                    <img src="{{ $member->foto_url }}" alt="{{ $member->nama_lengkap }}" class="w-24 h-24 rounded-full object-cover border-4 border-emerald-50 shadow-md">
                    @if($member->banom)
                        <span class="absolute bottom-0 right-0 bg-amber-400 text-emerald-950 text-[10px] font-bold px-2 py-0.5 rounded-full border border-white">
                            {{ $member->banom->singkatan }}
                        </span>
                    @endif
                </div>

                <h3 class="font-bold text-gray-800 text-base leading-tight mb-1">{{ $member->nama_lengkap }}</h3>
                <p class="text-xs text-gray-400 font-mono mb-2">{{ $member->nis ?? 'Anggota Terdaftar' }}</p>

                <div class="mt-auto w-full pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-gray-500 truncate max-w-[120px]">{{ $member->desa_kelurahan ?? 'Ranting NU Karangtengah' }}</span>
                    <a href="{{ route('anggota.show', $member->id) }}" class="text-emerald-700 font-bold hover:text-emerald-900">
                        Profil &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-white rounded-2xl p-12 text-center border border-gray-100 text-gray-400">
                <i class="fas fa-users-slash text-4xl mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">Tidak Ada Data Anggota</h3>
                <p class="text-xs text-gray-500 mt-1">Coba ubah kata kunci pencarian atau filter yang dipilih.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $members->links() }}
    </div>
</div>
@endsection
