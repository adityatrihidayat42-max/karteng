@extends('layouts.app')

@section('content')
@php
    // Warna kategori TIDAK ditaruh di atribut style="" lagi,
    // karena VSCode selalu memvalidasi isi style="" sebagai CSS murni
    // dan token {{ }} apapun isinya akan selalu dianggap error oleh validator itu.
    // Solusinya: simpan di data-attribute (tidak divalidasi sebagai CSS),
    // lalu warnanya diterapkan lewat JS kecil di akhir file.
    $categoryColor = $post->category->color ?? '#00704A';
@endphp
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12 px-4">
    <div class="max-w-4xl mx-auto space-y-3">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200 hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Warta Berita</span>
        </a>
        @if($post->category)
            <div>
                <span id="cat-badge-{{ $post->id }}" class="px-3 py-1 rounded-full text-xs font-bold text-white shadow inline-block" data-color="{{ $categoryColor }}">
                    {{ $post->category->name }}
                </span>
            </div>
        @endif
        <h1 class="text-2xl sm:text-4xl font-extrabold font-playfair text-white leading-tight">
            {{ $post->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-xs text-emerald-200 pt-2">
            <span><i class="fas fa-user-edit mr-1"></i> {{ $post->author->name ?? 'Redaksi' }}</span>
            <span>&bull;</span>
            <span><i class="fas fa-calendar-alt mr-1"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            <span>&bull;</span>
            <span><i class="fas fa-eye mr-1"></i> {{ $post->views }} kali dibaca</span>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 space-y-12">
    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="rounded-3xl overflow-hidden shadow-xl max-h-[480px]">
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Content -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
        <div class="prose prose-emerald max-w-none text-gray-700 leading-relaxed space-y-4 text-base">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div class="pt-8 mt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4 text-xs text-gray-500">
            <div>
                Kategori: <strong class="text-emerald-700">{{ $post->category->name ?? 'Umum' }}</strong>
            </div>
            <div class="flex items-center gap-2">
                <span>Bagikan warta:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank"
                   class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 transition">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                   class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition">
                    <i class="fab fa-facebook-f text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
        <div class="space-y-6">
            <h3 class="text-xl font-bold text-gray-900 font-playfair">Warta Terkait Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover p-4 space-y-2">
                        <span class="text-[10px] text-gray-400 block">{{ $related->published_at ? $related->published_at->format('d M Y') : '' }}</span>
                        <h4 class="font-bold text-gray-800 text-sm leading-snug">
                            <a href="{{ route('berita.show', $related->slug) }}" class="hover:text-emerald-700">
                                {{ $related->title }}
                            </a>
                        </h4>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    // Menerapkan warna badge kategori dari data-color ke style backgroundColor.
    document.querySelectorAll('[data-color]').forEach(function (el) {
        el.style.backgroundColor = el.dataset.color;
    });
</script>
@endsection