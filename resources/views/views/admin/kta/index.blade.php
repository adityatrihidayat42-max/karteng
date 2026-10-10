@extends('layouts.admin')

@section('page-title', 'Cetak Kartu Tanda Anggota (KTA)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Cetak KTA Berbasis NIS</h2>
            <p class="text-xs text-gray-500">Penerbitan dan pencetakan Kartu Tanda Anggota resmi Nahdlatul Ulama menggunakan Nomor Induk Santri (NIS).</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold">
            <i class="fas fa-lock text-emerald-600"></i>
            <span>Khusus Akses Admin / Pengurus</span>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
        <i class="fas fa-shield-halved text-amber-600 text-lg mt-0.5"></i>
        <div class="text-xs text-amber-900 space-y-1">
            <span class="font-bold">Akses Terbatas:</span>
            <p class="text-amber-800">
                Pencetakan dan pengunduhan berkas KTA hanya dapat dilakukan oleh Admin / Pengurus Jam'iyyah melalui halaman ini.
                Masyarakat umum tidak memiliki akses untuk melihat atau mengunduh KTA.
            </p>
        </div>
    </div>

    <!-- Form Input NIS untuk Cetak KTA -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
        <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                <i class="fas fa-id-card"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Buat &amp; Cetak KTA Berdasarkan NIS</h3>
                <p class="text-[11px] text-gray-400">Masukkan Nomor Induk Santri (NIS) anggota untuk menampilkan dan mencetak KTA</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.kta.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-barcode text-sm"></i>
                </span>
                <input type="text" name="nis" value="{{ $searchNis }}" required
                       placeholder="Masukkan NIS (contoh: NIS-2024-00001)"
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-mono font-bold focus:bg-white focus:border-emerald-600 outline-none">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i class="fas fa-search"></i>
                <span>Tampilkan KTA</span>
            </button>
            @if($searchNis)
                <a href="{{ route('admin.kta.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>

        @if($error)
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span>{{ $error }}</span>
            </div>
        @endif
    </div>

    <!-- Preview KTA Card jika NIS Ditemukan -->
    @if($selectedMember)
        <div class="bg-white rounded-2xl p-6 border-2 border-emerald-600/30 shadow-md space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">KTA Siap Dicetak</span>
                        <h3 class="text-base font-bold text-gray-900">{{ $selectedMember->nama_lengkap }} ({{ $selectedMember->nis }})</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.kta.download-by-nis', $selectedMember->nis) }}"
                       class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-2 transition">
                        <i class="fas fa-download"></i>
                        <span>Unduh PDF KTA</span>
                    </a>
                    <a href="{{ route('admin.kta.show-by-nis', $selectedMember->nis) }}"
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-2 transition">
                        <i class="fas fa-eye"></i>
                        <span>Lihat Detail</span>
                    </a>
                </div>
            </div>

            <!-- Card Mockup Preview (CR80 Standard Ratio approx 85.6mm x 54mm) -->
            <div class="flex justify-center py-4">
                <div class="w-full max-w-[500px] aspect-[85.6/54] rounded-2xl shadow-2xl overflow-hidden relative border-2 border-amber-400 text-white p-5 flex flex-col justify-between"
                     style="background: linear-gradient(135deg, #003d2b 0%, #005538 45%, #00704A 100%);">
                    <!-- Watermark -->
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
                                {{ $selectedMember->nis }}
                            </span>
                        </div>
                    </div>

                    <!-- Body Details -->
                    <div class="relative z-10 flex items-center gap-4 my-auto">
                        <div class="w-20 h-24 rounded-xl overflow-hidden border-2 border-amber-400 shadow-md bg-white flex-shrink-0">
                            <img src="{{ $selectedMember->foto_url }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-1 text-left flex-1 min-w-0">
                            <div class="text-sm font-black tracking-tight text-white truncate">{{ $selectedMember->nama_lengkap }}</div>
                            <div class="text-[10px] text-emerald-200 font-semibold">{{ $selectedMember->banom ? $selectedMember->banom->nama : 'Warga NU' }} &bull; {{ $selectedMember->jabatan ?? 'Anggota' }}</div>
                            <div class="text-[9px] text-gray-300">{{ $selectedMember->desa_kelurahan ?? 'Ranting' }}, {{ $selectedMember->kecamatan ?? '' }}</div>
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
        </div>
    @endif

    <!-- Daftar Anggota Aktif Siap Cetak -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden space-y-3">
        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Daftar Anggota Ber-NIS (Siap Cetak)</h3>
                <p class="text-[11px] text-gray-400">Pilih anggota untuk mencetak KTA secara langsung</p>
            </div>
            <form method="GET" action="{{ route('admin.kta.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIS..."
                       class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none focus:bg-white focus:border-emerald-600">
                <button type="submit" class="px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Anggota</th>
                        <th class="px-4 py-3">Nomor Induk Santri (NIS)</th>
                        <th class="px-4 py-3">Banom / Jabatan</th>
                        <th class="px-4 py-3">Wilayah</th>
                        <th class="px-4 py-3 text-right">Aksi Cetak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($members as $m)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $m->foto_url }}" alt="{{ $m->nama_lengkap }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                    <span class="font-bold text-gray-900">{{ $m->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono font-bold text-emerald-700">
                                {{ $m->nis }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-800">{{ $m->banom ? $m->banom->singkatan : 'PRNU' }}</span>
                                <span class="text-gray-400 text-[11px]">&bull; {{ $m->jabatan ?? 'Anggota' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-[11px]">
                                {{ $m->desa_kelurahan ?? 'Gumelar' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.kta.index', ['nis' => $m->nis]) }}"
                                       title="Tampilkan Preview KTA"
                                       class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                                        <i class="fas fa-id-card"></i>
                                        <span>Pilih</span>
                                    </a>
                                    <a href="{{ route('admin.kta.download-by-nis', $m->nis) }}"
                                       title="Download PDF Langsung"
                                       class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                                        <i class="fas fa-download"></i>
                                        <span>PDF</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400">
                                Tidak ada data anggota aktif yang memiliki NIS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-100">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection
