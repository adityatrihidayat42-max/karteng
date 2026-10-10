@extends('layouts.admin')

@section('page-title', 'Manajemen User / Pengurus')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Akun Pengurus</h2>
            <p class="text-xs text-gray-500">Pengguna yang memiliki hak akses login ke panel sistem informasi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
            <i class="fas fa-user-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5">Nama Pengurus</th>
                    <th class="px-4 py-3.5">Email</th>
                    <th class="px-4 py-3.5">No. HP</th>
                    <th class="px-4 py-3.5">Role / Hak Akses</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-5 py-3 font-bold text-gray-900 text-sm flex items-center gap-3">
                            <img src="{{ $u->avatar_url }}" alt="" class="w-9 h-9 rounded-full">
                            <span>{{ $u->name }}</span>
                        </td>
                        <td class="px-4 py-3 font-mono text-gray-500">{{ $u->email }}</td>
                        <td class="px-4 py-3">{{ $u->phone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">
                                {{ $u->roles->first()->name ?? 'Pengurus' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $u->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($u->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
