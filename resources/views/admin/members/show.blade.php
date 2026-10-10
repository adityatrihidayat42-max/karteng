@extends('layouts.admin')

@section('page-title', 'Detail Data Anggota')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
            &larr; Kembali ke Daftar Anggota
        </a>
        <div class="flex items-center gap-2">
            @if($member->status === 'aktif' && $member->nis)
                <a href="{{ route('admin.kta.show-by-nis', $member->nis) }}" class="px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold shadow flex items-center gap-1.5">
                    <i class="fas fa-id-card"></i>
                    <span>Cetak KTA (NIS: {{ $member->nis }})</span>
                </a>
            @endif
            <a href="{{ route('admin.members.edit', $member->id) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold shadow flex items-center gap-1.5">
                <i class="fas fa-pen"></i>
                <span>Edit</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-gray-100">
            <img src="{{ $member->foto_url }}" alt="{{ $member->nama_lengkap }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-emerald-700 shadow">
            <div class="text-center sm:text-left space-y-1">
                <h2 class="text-2xl font-black text-gray-900">{{ $member->nama_lengkap }}</h2>
                <div class="font-mono text-xs font-bold text-emerald-700">NIS: {{ $member->nis ?? 'Belum terbit' }}</div>
                <div class="text-xs text-gray-500">
                    {{ $member->banom ? $member->banom->nama : 'Pengurus Ranting NU' }} &bull; Jabatan: {{ $member->jabatan ?? '-' }}
                </div>
                <div class="pt-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $member->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $member->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-gray-700">
            <div class="space-y-3">
                <div class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-2">Identitas Kependudukan</div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">NIK:</span>
                    <span class="font-mono font-bold">{{ $member->nik ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Tempat, Tgl Lahir:</span>
                    <span>{{ $member->tempat_lahir ?? '-' }}, {{ $member->tanggal_lahir ? $member->tanggal_lahir->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Jenis Kelamin:</span>
                    <span>{{ $member->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Nomor WhatsApp:</span>
                    <span class="font-bold text-emerald-700">{{ $member->nomor_hp ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Email:</span>
                    <span>{{ $member->email ?? '-' }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-2">Alamat & Keorganisasian</div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Alamat Lengkap:</span>
                    <span class="text-right">{{ $member->alamat_lengkap ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Badan Otonom:</span>
                    <span class="font-semibold">{{ $member->banom ? $member->banom->nama : 'PRNU' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Tampil Publik:</span>
                    <span>{{ $member->tampil_publik ? 'Ya (Aktif)' : 'Tidak' }}</span>
                </div>
                <div class="flex justify-between gap-4 py-1 border-b border-gray-50">
                    <span class="text-gray-400">Tgl Bergabung:</span>
                    <span>{{ $member->tanggal_bergabung ? $member->tanggal_bergabung->format('d M Y') : '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
