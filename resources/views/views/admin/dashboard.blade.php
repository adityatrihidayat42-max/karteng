@extends('layouts.admin')

@section('page-title', 'Dashboard Statistik')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Anggota -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm card-stat flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Anggota</span>
                <span class="text-2xl font-black text-gray-800 mt-1 block">{{ number_format($stats['total_members']) }}</span>
                <span class="text-xs text-emerald-600 font-semibold">{{ $stats['aktif_members'] }} aktif</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- Pendaftar Baru -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm card-stat flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Menunggu Verifikasi</span>
                <span class="text-2xl font-black text-amber-600 mt-1 block">{{ number_format($stats['menunggu_members']) }}</span>
                <a href="{{ route('admin.members.index', ['status' => 'menunggu_verifikasi']) }}" class="text-xs text-amber-600 font-bold hover:underline">Lihat pendaftar &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>

        <!-- Donasi Pending -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm card-stat flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Donasi Menunggu</span>
                <span class="text-2xl font-black text-blue-600 mt-1 block">{{ number_format($stats['pending_donations']) }}</span>
                <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}" class="text-xs text-blue-600 font-bold hover:underline">Konfirmasi &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-hand-holding-dollar"></i>
            </div>
        </div>

        <!-- Total Infaq Bulan Ini -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm card-stat flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Infaq Bulan Ini</span>
                <span class="text-lg font-black text-emerald-800 mt-1 block font-mono">Rp {{ number_format($stats['total_donations_month'], 0, ',', '.') }}</span>
                <span class="text-[11px] text-gray-400">Total: Rp {{ number_format($stats['total_donations_all'], 0, ',', '.') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Additional Small Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 border border-gray-100 text-center">
            <span class="text-xs text-gray-400">Badan Otonom</span>
            <div class="text-xl font-bold text-gray-800 mt-0.5">{{ $stats['total_banoms'] }}</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 text-center">
            <span class="text-xs text-gray-400">Total Warta Berita</span>
            <div class="text-xl font-bold text-gray-800 mt-0.5">{{ $stats['total_posts'] }}</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 text-center">
            <span class="text-xs text-gray-400">Agenda Mendatang</span>
            <div class="text-xl font-bold text-gray-800 mt-0.5">{{ $stats['upcoming_agendas'] }}</div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 text-center">
            <span class="text-xs text-gray-400">Anggota Aktif</span>
            <div class="text-xl font-bold text-emerald-700 mt-0.5">{{ $stats['aktif_members'] }}</div>
        </div>
    </div>

    <!-- Recent Tables (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pendaftar / Anggota Terbaru -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <i class="fas fa-user-plus text-emerald-600"></i>
                    <span>Pendaftar & Anggota Terbaru</span>
                </h3>
                <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($recentMembers as $m)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex items-center gap-3">
                            <img src="{{ $m->foto_url }}" alt="{{ $m->nama_lengkap }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-xs text-gray-800">{{ $m->nama_lengkap }}</h4>
                                <span class="text-[10px] text-gray-500 font-mono">{{ $m->nis ?? 'Belum ada NIS' }} &bull; {{ $m->banom ? $m->banom->singkatan : 'PRNU' }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $m->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $m->status_label }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada data pendaftar.</p>
                @endforelse
            </div>
        </div>

        <!-- Transaksi Donasi Terbaru -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <i class="fas fa-hand-holding-dollar text-emerald-600"></i>
                    <span>Transaksi Donasi Terbaru</span>
                </h3>
                <a href="{{ route('admin.donations.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($recentDonations as $don)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                        <div>
                            <h4 class="font-bold text-xs text-gray-800">{{ $don->donor_name }}</h4>
                            <span class="text-[10px] text-gray-400 font-mono">#{{ $don->transaction_code }} &bull; {{ $don->donation_type_label }}</span>
                        </div>
                        <div class="text-right">
                            <div class="font-mono text-xs font-bold text-emerald-700">{{ $don->amount_formatted }}</div>
                            <span class="text-[10px] font-semibold {{ $don->status === 'confirmed' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $don->status_label }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada transaksi donasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
