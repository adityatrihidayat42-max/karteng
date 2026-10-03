@extends('layouts.admin')

@section('page-title', 'Detail Transaksi Donasi')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.donations.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
            &larr; Kembali ke Daftar Donasi
        </a>
    </div>

    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs text-gray-400 font-mono">KODE TRANSAKSI</span>
                <h2 class="text-2xl font-black text-gray-900 font-mono">#{{ $donation->transaction_code }}</h2>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $donation->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : ($donation->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                {{ $donation->status_label }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-gray-700">
            <div class="space-y-3">
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Nama Donatur:</span>
                    <span class="font-bold text-gray-900">{{ $donation->donor_name }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">WhatsApp / HP:</span>
                    <span>{{ $donation->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Email:</span>
                    <span>{{ $donation->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Jenis Donasi:</span>
                    <span class="font-semibold text-emerald-700">{{ $donation->donation_type_label }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Nominal:</span>
                    <span class="font-mono font-black text-sm text-emerald-700">{{ $donation->amount_formatted }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Bank Pengirim:</span>
                    <span>{{ $donation->bank_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Tanggal Transfer:</span>
                    <span>{{ $donation->transfer_date ? $donation->transfer_date->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Dikonfirmasi Oleh:</span>
                    <span>{{ $donation->confirmedBy->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        @if($donation->notes)
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 text-xs">
                <span class="font-bold text-gray-600 block mb-1">Pesan / Doa Donatur:</span>
                <p class="text-gray-700 italic">"{{ $donation->notes }}"</p>
            </div>
        @endif

        <!-- Bukti Transfer Image Preview -->
        <div class="space-y-2">
            <span class="text-xs font-bold text-gray-700 block">Foto Bukti Transfer:</span>
            @if($donation->proof_image)
                <div class="rounded-xl overflow-hidden border border-gray-200 max-w-sm">
                    <img src="{{ asset('storage/' . $donation->proof_image) }}" alt="Bukti Transfer" class="w-full h-auto">
                </div>
            @else
                <p class="text-xs text-gray-400 italic">Donatur belum mengunggah bukti transfer.</p>
            @endif
        </div>

        @if($donation->status === 'pending')
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <form action="{{ route('admin.donations.reject', $donation->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow">
                        Tolak Donasi
                    </button>
                </form>
                <form action="{{ route('admin.donations.confirm', $donation->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
