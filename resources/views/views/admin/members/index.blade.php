@extends('layouts.admin')

@section('page-title', 'Manajemen Anggota')

@section('content')
<div class="space-y-5">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Anggota & Kader</h2>
            <p class="text-xs text-gray-500">Kelola pangkalan data anggota ranting dan pendaftar baru.</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow transition">
            <i class="fas fa-user-plus"></i>
            <span>Tambah Anggota</span>
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.members.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama, NIS, NIK, atau no HP..."
                       class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>

            <div>
                <select name="banom_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    <option value="">Semua Banom</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" {{ request('banom_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->singkatan ?? $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <select name="status" class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Anggota</th>
                        <th class="px-4 py-3.5">NIS / NIK</th>
                        <th class="px-4 py-3.5">Banom / Jabatan</th>
                        <th class="px-4 py-3.5">Kontak</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($members as $m)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $m->foto_url }}" alt="{{ $m->nama_lengkap }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm leading-tight">{{ $m->nama_lengkap }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $m->desa_kelurahan ?? 'Ranting' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-mono font-bold text-emerald-700 text-xs">{{ $m->nis ?? '-' }}</div>
                                <div class="font-mono text-[10px] text-gray-400">{{ $m->nik ? substr($m->nik, 0, 6) . '******' . substr($m->nik, -4) : '-' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-800">{{ $m->banom ? $m->banom->singkatan : 'PRNU' }}</span>
                                <div class="text-[11px] text-gray-500">{{ $m->jabatan ?? 'Anggota' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs text-gray-700">{{ $m->nomor_hp ?? '-' }}</div>
                                <div class="text-[10px] text-gray-400">{{ $m->email ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $m->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : ($m->status === 'menunggu_verifikasi' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $m->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($m->status === 'menunggu_verifikasi')
                                        <form action="{{ route('admin.members.approve', $m->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Setujui Pendaftaran" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center justify-center transition">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.members.reject', $m->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Tolak Pendaftaran" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center transition">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($m->status === 'aktif' && $m->nis)
                                        <a href="{{ route('admin.kta.show-by-nis', $m->nis) }}" title="Cetak KTA (NIS: {{ $m->nis }})" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center justify-center transition">
                                            <i class="fas fa-id-card text-xs"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.members.edit', $m->id) }}" title="Edit Anggota" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.members.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus data anggota ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Anggota" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center transition">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                                Tidak ada data anggota yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection
