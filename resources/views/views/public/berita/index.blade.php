@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Kabar & Opini
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Warta Nahdliyyin</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Informasi terkini, liputan kegiatan ranting, tausiyah ulama, dan artikel keagamaan.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-10">
    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('berita.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul atau isi warta berita..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
            </div>

            <div class="sm:w-56">
                <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->posts_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-semibold transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Berita Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($posts as $post)
            @php
                // Warna kategori TIDAK ditaruh di atribut style="" lagi,
                // karena VSCode selalu memvalidasi isi style="" sebagai CSS murni
                // dan token {{ }} apapun isinya akan selalu dianggap error oleh validator itu.
                // Solusinya: simpan di data-attribute (tidak divalidasi sebagai CSS),
                // lalu warnanya diterapkan lewat JS kecil di akhir file.
                $categoryColor = $post->category->color ?? '#00704A';
            @endphp
            <article data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 80 }}" class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 card-hover flex flex-col justify-between">
                <div>
                    <div class="relative h-48 overflow-hidden bg-emerald-800">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/30 text-4xl">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        @endif
                        @if($post->category)
                            <span id="cat-badge-{{ $post->id }}" class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white shadow" data-color="{{ $categoryColor }}">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="p-6 space-y-3">
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                            </span>
                            <span>&bull;</span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-eye"></i> {{ $post->views }}x
                            </span>
                        </div>

                        <h3 class="font-bold text-gray-900 text-lg leading-snug hover:text-emerald-700 transition">
                            <a href="{{ route('berita.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2">
                    <a href="{{ route('berita.show', $post->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1.5">
                        <span>Baca Selengkapnya</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-3 bg-white rounded-3xl p-12 text-center border border-gray-100 text-gray-400">
                <i class="fas fa-newspaper text-4xl mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">Warta Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1">Belum ada warta berita dengan kriteria pencarian tersebut.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $posts->links() }}
    </div>
</div>

<script>
    // Menerapkan warna badge kategori dari data-color ke style backgroundColor.
    document.querySelectorAll('[data-color]').forEach(function (el) {
        el.style.backgroundColor = el.dataset.color;
    });
</script>
@endsection