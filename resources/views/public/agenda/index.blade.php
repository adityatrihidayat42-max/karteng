@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Kalender Kegiatan
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Agenda Jam'iyyah</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Jadwal pengajian rutin, lailatul ijtima', kaderisasi, dan musyawarah ranting Nahdlatul Ulama.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-16">
    <!-- Agenda Mendatang -->
    <div class="space-y-6">
        <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 font-playfair flex items-center gap-2">
                <i class="fas fa-calendar-check text-emerald-700"></i>
                <span>Agenda Mendatang</span>
            </h2>
            <span class="text-xs text-gray-500 font-semibold">{{ $upcoming->total() }} Kegiatan</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($upcoming as $item)
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm card-hover flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white flex flex-col items-center justify-center text-center font-bold shadow">
                                <span class="text-lg leading-none">{{ $item->start_at->format('d') }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-emerald-200 mt-0.5">{{ $item->start_at->format('M Y') }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    {{ $item->organizer ?? 'PRNU' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-clock text-[10px]"></i> {{ $item->start_at->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>

                        <h3 class="font-bold text-gray-900 text-base leading-snug">
                            <a href="{{ route('agenda.show', $item->slug) }}" class="hover:text-emerald-700 transition">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <div class="space-y-1.5 text-xs text-gray-500">
                            @if($item->location)
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-map-marker-alt text-emerald-600 mt-0.5"></i>
                                    <span>{{ $item->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                            {{ ucfirst($item->status) }}
                        </span>
                        <a href="{{ route('agenda.show', $item->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-3xl p-10 text-center border border-gray-100 text-gray-400 text-sm">
                    Tidak ada agenda mendatang dalam waktu dekat.
                </div>
            @endforelse
        </div>

        <div>
            {{ $upcoming->links() }}
        </div>
    </div>

    <!-- Agenda Terlaksana / Lampau -->
    <div class="space-y-6">
        <div class="border-b border-gray-200 pb-3">
            <h2 class="text-xl font-bold text-gray-700 font-playfair flex items-center gap-2">
                <i class="fas fa-history text-gray-400"></i>
                <span>Agenda Telah Terlaksana</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 opacity-80">
            @forelse($past as $p)
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200/80">
                    <span class="text-xs text-gray-400 block mb-1">{{ $p->start_at->format('d M Y') }}</span>
                    <h4 class="font-bold text-gray-800 text-sm leading-snug">{{ $p->title }}</h4>
                    <p class="text-xs text-gray-500 mt-1 truncate">{{ $p->location }}</p>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-gray-400 text-xs">
                    Belum ada riwayat agenda lampau.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
