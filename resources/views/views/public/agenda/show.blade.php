```php
@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12 px-4">
    <div class="max-w-4xl mx-auto space-y-3">
        <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200 hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Kalender Agenda</span>
        </a>
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-emerald-950 inline-block">
            {{ $agenda->organizer ?? 'PRNU' }}
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold font-playfair text-white leading-tight">
            {{ $agenda->title }}
        </h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 space-y-8">
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-gray-100 space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-6 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-950">
            <div>
                <div class="text-xs text-emerald-700 font-semibold mb-1">Tanggal & Waktu:</div>
                <div class="font-bold text-sm">{{ $agenda->start_at->format('d M Y, H:i') }} WIB</div>
                @if($agenda->end_at)
                    <div class="text-xs text-gray-500">s/d {{ $agenda->end_at->format('d M Y, H:i') }} WIB</div>
                @endif
            </div>
            <div>
                <div class="text-xs text-emerald-700 font-semibold mb-1">Lokasi:</div>
                <div class="font-bold text-sm">{{ $agenda->location ?? 'Sekretariat PRNU' }}</div>
            </div>
            <div>
                <div class="text-xs text-emerald-700 font-semibold mb-1">Penyelenggara:</div>
                <div class="font-bold text-sm">{{ $agenda->organizer ?? 'Pengurus Ranting NU' }}</div>
            </div>
        </div>

        @if($agenda->image)
            <div class="rounded-2xl overflow-hidden shadow">
                <img src="{{ asset('storage/' . $agenda->image) }}" alt="{{ $agenda->title }}" class="w-full h-auto">
            </div>
        @endif

        <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Deskripsi / Susunan Acara</h3>
            <div class="prose prose-emerald max-w-none text-gray-700 text-sm sm:text-base leading-relaxed">
                {!! nl2br(e($agenda->description ?? 'Tidak ada rincian deskripsi tambahan.')) !!}
            </div>
        </div>
    </div>
</div>
@endsection

```