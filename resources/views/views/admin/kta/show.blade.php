@extends('layouts.admin')

@section('page-title', 'Kartu Tanda Anggota (KTA)')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kta.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700 flex items-center gap-1">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Cetak KTA</span>
            </a>
            <span class="text-gray-300">&bull;</span>
            <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600">
                Daftar Anggota
            </a>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="fas fa-print"></i>
                <span>Cetak Langsung</span>
            </button>
            <a href="{{ route('admin.kta.download-by-nis', $member->nis) }}" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-2">
                <i class="fas fa-download"></i>
                <span>Unduh PDF KTA</span>
            </a>
        </div>
    </div>

    <!-- KTA Card Mockup Preview (CR80 Standard Ratio approx 85.6mm x 54mm = 1.58 ratio) -->
    <div class="flex justify-center py-6">
        <div class="w-full max-w-[500px] aspect-[85.6/54] rounded-2xl shadow-2xl overflow-hidden relative border-2 border-amber-400 text-white p-5 flex flex-col justify-between"
             style="background: linear-gradient(135deg, #003d2b 0%, #005538 45%, #00704A 100%);">

            <!-- Watermark / Ornament -->
            <div class="absolute inset-0 opacity-10 flex items-center justify-center pointer-events-none">
                <i class="fas fa-star-and-crescent text-[180px]"></i>
            </div>

            <!-- Top Header -->
            <div class="relative z-10 flex items-center justify-between border-b border-amber-400/40 pb-2.5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center shadow">
                        <i class="fas fa-star-and-crescent text-emerald-800 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xs font-black tracking-wider text-amber-300 uppercase leading-none">NAHDLATUL ULAMA</div>
                        <div class="text-[10px] font-bold text-white mt-0.5 leading-none">{{ $profile->nama_organisasi ?? 'PENGURUS RANTING' }}</div>
                        <div class="text-[8px] text-emerald-200 tracking-wider uppercase mt-0.5">KARTU TANDA ANGGOTA (KTA)</div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-mono font-bold bg-amber-400 text-emerald-950 px-2 py-0.5 rounded shadow">
                        {{ $member->nis }}
                    </span>
                </div>
            </div>

            <!-- Body Details -->
            <div class="relative z-10 flex items-center gap-4 my-auto">
                <div class="w-20 h-24 rounded-xl overflow-hidden border-2 border-amber-400 shadow-md bg-white flex-shrink-0">
                    <img src="{{ $member->foto_url }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="space-y-1 text-left flex-1 min-w-0">
                    <div class="text-sm font-black tracking-tight text-white truncate">{{ $member->nama_lengkap }}</div>
                    <div class="text-[10px] text-emerald-200 font-semibold">{{ $member->banom ? $member->banom->nama : 'Warga NU' }} &bull; {{ $member->jabatan ?? 'Anggota' }}</div>
                    <div class="text-[9px] text-gray-300">{{ $member->desa_kelurahan ?? 'Ranting' }}, {{ $member->kecamatan ?? '' }}</div>
                    <div class="text-[8px] text-emerald-300 font-mono pt-1">
                        Masa Berlaku: <strong class="text-amber-300 font-sans">2024 - 2029</strong>
                    </div>
                </div>

                <!-- QR Code Preview -->
                @if($qrCode)
                    <div class="w-16 h-16 bg-white rounded-lg p-1 shadow flex items-center justify-center flex-shrink-0">
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" class="w-full h-full">
                    </div>
                @endif
            </div>

            <!-- Bottom Footer Bar -->
            <div class="relative z-10 border-t border-white/20 pt-2 flex items-center justify-between text-[8px] text-emerald-200">
                <span>Merawat Jagat, Membangun Peradaban</span>
                <span class="font-mono text-[7px] opacity-75">Scan QR untuk Verifikasi</span>
            </div>
        </div>
    </div>

    <!-- Instructions / Card Info -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-xs text-gray-600 space-y-2">
        <h4 class="font-bold text-gray-800 text-sm">Informasi Cetak KTA</h4>
        <ul class="list-disc list-inside space-y-1 text-gray-500">
            <li>KTA ini dirancang sesuai standar ukuran ID Card fisik (CR80: 85.6 mm &times; 54 mm).</li>
            <li>QR Code yang tertera dapat dipindai (scan) untuk membuka halaman verifikasi keaslian anggota secara realtime.</li>
            <li>Klik tombol <strong>"Unduh PDF KTA"</strong> di atas untuk mengunduh berkas PDF siap cetak.</li>
        </ul>
    </div>
</div>
@endsection
