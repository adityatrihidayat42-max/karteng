@extends('layouts.admin')

@section('page-title', 'Manajemen Badan Otonom')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Direktori Badan Otonom (BANOM)</h2>
            <p class="text-xs text-gray-500">Kelola banom tingkat ranting (Ansor, Banser, Fatayat, IPNU, IPPNU, dll).</p>
        </div>
        <a href="{{ route('admin.banoms.create') }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
            <i class="fas fa-plus"></i>
            <span>Tambah Banom</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5">Logo & Nama</th>
                    <th class="px-4 py-3.5">Singkatan</th>
                    <th class="px-4 py-3.5">Ketua / Kontak</th>
                    <th class="px-4 py-3.5">Jumlah Anggota</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($banoms as $b)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-200 p-1 flex items-center justify-center">
                                    @if($b->logo)
                                        <img src="{{ asset('storage/' . $b->logo) }}" alt="{{ $b->nama }}" class="w-full h-full object-contain">
                                    @else
                                        <i class="fas fa-users-cog text-emerald-700 text-sm"></i>
                                    @endif
                                </div>
                                <div class="font-bold text-gray-900 text-sm">{{ $b->nama }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                {{ $b->singkatan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $b->ketua ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $b->kontak ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-bold text-emerald-700 font-mono">{{ $b->members_count }}</span> Kader
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $b->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $b->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.banoms.edit', $b->id) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.banoms.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus banom ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada data banom.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $banoms->links() }}
        </div>
    </div>
</div>
@endsection
