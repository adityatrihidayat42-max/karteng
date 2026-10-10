@extends('layouts.admin')

@section('page-title', 'Manajemen Infaq & Donasi')

@section('content')
<div class="space-y-5">
    <!-- Stat Highlights -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400">Total Terhimpun</span>
            <div class="text-lg font-bold text-emerald-800 font-mono mt-1">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400">Bulan Ini</span>
            <div class="text-lg font-bold text-emerald-600 font-mono mt-1">Rp {{ number_format($stats['amount_this_month'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400">Menunggu Konfirmasi</span>
            <div class="text-lg font-bold text-amber-600 mt-1">{{ $stats['total_pending'] }} Transaksi</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <span class="text-xs text-gray-400">Terkonfirmasi</span>
            <div class="text-lg font-bold text-gray-800 mt-1">{{ $stats['total_confirmed'] }} Transaksi</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama donatur atau kode transaksi..."
                       class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>
            <div class="sm:w-48">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-xl text-xs font-semibold">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5">Kode Transaksi</th>
                    <th class="px-4 py-3.5">Donatur</th>
                    <th class="px-4 py-3.5">Jenis Donasi</th>
                    <th class="px-4 py-3.5">Nominal</th>
                    <th class="px-4 py-3.5">Bukti</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($donations as $don)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-5 py-3 font-mono font-bold text-emerald-800">
                            #{{ $don->transaction_code }}
                            <div class="text-[10px] text-gray-400 font-sans font-normal">{{ $don->created_at->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-gray-900">{{ $don->donor_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $don->phone ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700">
                                {{ $don->donation_type_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono font-bold text-sm text-emerald-700">
                            {{ $don->amount_formatted }}
                        </td>
                        <td class="px-4 py-3">
                            @if($don->proof_image)
                                <a href="{{ asset('storage/' . $don->proof_image) }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center gap-1 font-semibold">
                                    <i class="fas fa-image"></i>
                                    <span>Lihat Bukti</span>
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 italic">Belum unggah</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $don->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : ($don->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ $don->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.donations.show', $don->id) }}" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                @if($don->status === 'pending')
                                    <form action="{{ route('admin.donations.confirm', $don->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="Konfirmasi Donasi" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center justify-center">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.donations.reject', $don->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="Tolak Donasi" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-400">Belum ada transaksi donasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection
