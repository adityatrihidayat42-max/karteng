@extends('layouts.admin')

@section('page-title', 'Kategori Berita')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kategori Warta Berita</h2>
            <p class="text-xs text-gray-500">Kelola pengelompokan artikel dan warta jam'iyyah.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">
            &larr; Kembali ke Daftar Berita
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Form Tambah Kategori -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-3 mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Pengajian, Dakwah, Sosial"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Warna Label Hex</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="color" value="#00704A" class="w-9 h-9 rounded-xl border border-gray-200 cursor-pointer p-0.5">
                        <span class="text-xs text-gray-400">Pilih warna penanda label</span>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Tambah Kategori
                </button>
            </form>
        </div>

        <!-- Tabel Kategori -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Jumlah Berita</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat->color ?? '#00704A' }};"></span>
                                <span>{{ $cat->name }}</span>
                            </td>
                            <td class="px-4 py-3 font-mono text-gray-400">{{ $cat->slug }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-emerald-700">{{ $cat->posts_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 flex items-center justify-center">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
