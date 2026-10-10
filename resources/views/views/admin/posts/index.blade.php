@extends('layouts.admin')

@section('page-title', 'Manajemen Berita')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Warta & Berita</h2>
            <p class="text-xs text-gray-500">Kelola artikel, liputan kegiatan ranting, dan informasi keagamaan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold">
                <i class="fas fa-tags mr-1"></i> Kategori
            </a>
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
                <i class="fas fa-plus"></i>
                <span>Tulis Berita</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..."
                       class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>
            <div class="sm:w-48">
                <select name="category_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:w-36">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-xl text-xs font-semibold">Filter</button>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-xs">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5">Judul Berita</th>
                    <th class="px-4 py-3.5">Kategori</th>
                    <th class="px-4 py-3.5">Penulis</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5">Dibaca</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900 text-sm leading-tight line-clamp-1">{{ $post->title }}</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5">
                                        {{ $post->published_at ? $post->published_at->format('d M Y H:i') : 'Draft' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($post->category)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold text-white shadow-sm" style="background-color: {{ $post->category->color ?? '#00704A' }}">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $post->author->name ?? 'Admin' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-gray-500">{{ $post->views }}x</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('berita.show', $post->slug) }}" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="inline">
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
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada warta berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
