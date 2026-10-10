@extends('layouts.admin')

@section('page-title', 'Manajemen Agenda Kegiatan')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Agenda Kegiatan</h2>
            <p class="text-xs text-gray-500">Jadwal pengajian, istighotsah, rapat pengurus, dan peringatan PHBI.</p>
        </div>
        <a href="{{ route('admin.agendas.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
            <i class="fas fa-plus"></i>
            <span>Tambah Agenda</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5">Judul Agenda</th>
                    <th class="px-4 py-3.5">Waktu Pelaksanaan</th>
                    <th class="px-4 py-3.5">Lokasi</th>
                    <th class="px-4 py-3.5">Penyelenggara</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($agendas as $agenda)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-5 py-3 font-bold text-gray-900 text-sm">
                            {{ $agenda->title }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $agenda->start_at->format('d M Y, H:i') }} WIB</div>
                            @if($agenda->end_at)
                                <div class="text-[10px] text-gray-400">s/d {{ $agenda->end_at->format('d M Y, H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $agenda->location ?? '-' }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $agenda->organizer ?? 'PRNU' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $agenda->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : ($agenda->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ ucfirst($agenda->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="inline">
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
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada agenda terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $agendas->links() }}
        </div>
    </div>
</div>
@endsection
