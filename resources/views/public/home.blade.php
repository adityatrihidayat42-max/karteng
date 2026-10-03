@extends('layouts.app')

@section('content')
<!-- ========================================================================= -->
<!-- 1. HERO SECTION (Full Animations, Islamic Green + Gold, Responsive) -->
<!-- ========================================================================= -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden gradient-animate text-white py-20 px-4">
    <!-- Floating Decorative Elements -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl float-animation"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-400/20 rounded-full blur-3xl float-animation" style="animation-delay: 1.5s;"></div>

    <!-- Islamic Star Pattern Geometry Overlay -->
    <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-6xl mx-auto text-center relative z-10 space-y-8">
        <!-- Badge Tagline -->
        <div data-aos="fade-down" data-aos-duration="1000" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-amber-300 text-xs sm:text-sm font-semibold tracking-wider uppercase shadow-inner">
            <i class="fas fa-certificate text-amber-400"></i>
            <span>{{ $profile->tingkat ?? 'Pengurus Ranting' }} Nahdlatul Ulama</span>
            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
            <span>{{ $profile->wilayah ?? 'Kecamatan / Desa' }}</span>
        </div>

        <!-- Emblem Logo -->
        <div data-aos="zoom-in" data-aos-duration="1200" class="flex justify-center">
            <div class="relative group">
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full bg-white p-3 shadow-2xl shadow-black/40 border-4 border-amber-400 flex items-center justify-center pulse-green transition-transform duration-500 group-hover:scale-105">
                    @if($profile->logo)
                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo NU" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full rounded-full bg-emerald-800 flex flex-col items-center justify-center text-amber-300">
                            <i class="fas fa-star-and-crescent text-4xl sm:text-5xl"></i>
                            <span class="text-[10px] sm:text-xs font-black tracking-widest text-white mt-1">NAHDLATUL ULAMA</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Headline -->
        <div data-aos="fade-up" data-aos-duration="1200" class="space-y-4 max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-white leading-tight font-playfair">
                {{ $profile->nama_organisasi ?? 'Pengurus Ranting Nahdlatul Ulama' }}
            </h1>
            <p class="text-base sm:text-xl text-emerald-100/90 font-medium max-w-2xl mx-auto leading-relaxed">
                "{{ $profile->tagline ?? 'Menegakkan Ajaran Islam Ahlussunnah Wal Jamaah, Mengabdi untuk Kemaslahatan Ummat dan Bangsa' }}"
            </p>
        </div>

        <!-- CTA Buttons -->
        <div data-aos="fade-up" data-aos-delay="200" class="flex flex-wrap items-center justify-center gap-4 pt-4">
            <a href="{{ route('daftar-anggota') }}" class="px-8 py-4 rounded-full bg-amber-400 hover:bg-amber-300 text-emerald-950 font-extrabold text-sm sm:text-base shadow-xl shadow-amber-500/20 hover:shadow-amber-500/40 transform hover:-translate-y-1 transition duration-300 flex items-center gap-3">
                <i class="fas fa-id-card text-emerald-900"></i>
                <span>Daftar Anggota Online</span>
            </a>
            <a href="{{ route('donasi.index') }}" class="px-8 py-4 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border-2 border-white/30 text-white font-bold text-sm sm:text-base hover:border-white transition duration-300 flex items-center gap-3">
                <i class="fas fa-hand-holding-heart text-amber-400"></i>
                <span>Infaq & Donasi</span>
            </a>
            <a href="{{ route('berita.index') }}" class="px-6 py-4 rounded-full text-emerald-100 hover:text-white font-semibold text-sm sm:text-base transition flex items-center gap-2">
                <span>Warta Berita</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 2. STATISTIC COUNTERS -->
<!-- ========================================================================= -->
<section class="relative -mt-10 z-20 max-w-6xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 text-center card-hover">
            <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-3">
                <i class="fas fa-users"></i>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ number_format($stats['total_members']) }}</div>
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mt-1">Anggota Aktif</div>
        </div>

        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 text-center card-hover">
            <div class="w-12 h-12 mx-auto rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['total_banoms'] }}</div>
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mt-1">Badan Otonom</div>
        </div>

        <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 text-center card-hover">
            <div class="w-12 h-12 mx-auto rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-3">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['total_agendas'] }}</div>
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mt-1">Agenda Kegiatan</div>
        </div>

        <div data-aos="fade-up" data-aos-delay="400" class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 text-center card-hover">
            <div class="w-12 h-12 mx-auto rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-3">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['total_posts'] }}</div>
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mt-1">Warta & Berita</div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 3. PROFIL SINGKAT ORGANISASI -->
<!-- ========================================================================= -->
<section class="py-20 bg-gray-50 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div data-aos="fade-right" class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider">
                    <i class="fas fa-mosque"></i> Tentang Kami
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 font-playfair leading-tight">
                    Khidmah Jam'iyyah Nahdlatul Ulama
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    {{ Str::limit($profile->tentang ?? 'Pengurus Ranting Nahdlatul Ulama adalah struktur organisasi NU di tingkat desa/kelurahan yang bersentuhan langsung dengan denyut nadi jamaah nahdliyin. Kami berkhidmat untuk mewujudkan kemaslahatan umat dalam bingkai Islam rahmatan lil alamin.', 300) }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-xl bg-white border border-gray-200/80 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm font-bold mb-2">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm">Visi</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-3">
                            {{ $profile->visi ?? 'Terwujudnya jamaah nahdliyin yang mandiri, berilmu, dan berakhlakul karimah.' }}
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-gray-200/80 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm font-bold mb-2">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm">Misi</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-3">
                            {{ $profile->misi ?? 'Menguatkan dakwah aswaja, pemberdayaan ekonomi umat, dan kaderisasi berkelanjutan.' }}
                        </p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('profil') }}" class="inline-flex items-center gap-2 text-emerald-700 font-bold hover:text-emerald-800 text-sm group">
                        <span>Baca Profil Lengkap & Sejarah</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div data-aos="fade-left" class="lg:col-span-6 relative">
                <div class="relative mx-auto max-w-md">
                    <div class="absolute -top-4 -left-4 w-full h-full bg-emerald-700 rounded-3xl -rotate-2 opacity-10"></div>
                    <div class="relative bg-white p-8 rounded-3xl shadow-2xl border border-gray-100 space-y-6">
                        <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-700 flex items-center justify-center text-amber-300 text-2xl">
                                <i class="fas fa-star-and-crescent"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-gray-800 text-lg leading-tight">{{ $profile->nama_organisasi ?? 'PRNU' }}</h3>
                                <p class="text-xs text-emerald-600 font-semibold">{{ $profile->wilayah ?? 'Ranting NU' }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-emerald-600 mt-1"></i>
                                <span>{{ $profile->alamat_lengkap ?? 'Sekretariat Ranting Nahdlatul Ulama' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone text-emerald-600"></i>
                                <span>{{ $profile->telepon ?? '+62 812-3456-7890' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-envelope text-emerald-600"></i>
                                <span>{{ $profile->email ?? 'ranting@nu.or.id' }}</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                            <div>
                                <div class="text-xs text-emerald-800 font-semibold">Butuh Bantuan / Informasi?</div>
                                <div class="text-sm font-bold text-emerald-950">Hubungi Layanan Pengurus</div>
                            </div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp ?? '6281234567890') }}" target="_blank"
                               class="w-10 h-10 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shadow transition">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 4. DIREKTORI BADAN OTONOM (BANOM) -->
<!-- ========================================================================= -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-14" data-aos="fade-up">
            <span class="text-emerald-700 font-extrabold text-xs tracking-wider uppercase bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Pilar Pergerakan
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 font-playfair">
                Badan Otonom (BANOM)
            </h2>
            <p class="text-gray-500 text-sm">
                Sayap pergerakan Nahdlatul Ulama yang mewadahi berbagai elemen generasi, pemuda, santri, dan perempuan.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($banoms as $banom)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-lg shadow-gray-200/50 card-hover flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold">
                                @if($banom->logo)
                                    <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->nama }}" class="w-10 h-10 object-contain">
                                @else
                                    <i class="fas fa-users-cog"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-extrabold text-gray-900 text-base leading-tight">{{ $banom->nama }}</h3>
                                <span class="inline-block text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded mt-0.5">
                                    {{ $banom->singkatan ?? 'BANOM' }}
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                            {{ $banom->deskripsi ?? 'Wadah pengkaderan dan pergerakan di lingkungan Nahdlatul Ulama.' }}
                        </p>
                        @if($banom->ketua)
                            <div class="text-xs text-gray-600 flex items-center gap-2 pt-2 border-t border-gray-50">
                                <i class="fas fa-user-tie text-emerald-600"></i>
                                <span>Ketua: <strong>{{ $banom->ketua }}</strong></span>
                            </div>
                        @endif
                    </div>
                    <div class="pt-5 mt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Status: <span class="text-emerald-600 font-semibold">Aktif</span></span>
                        <a href="{{ route('banom.show', $banom->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 group">
                            <span>Detail Banom</span>
                            <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    <i class="fas fa-info-circle text-2xl mb-2"></i>
                    <p>Data Badan Otonom belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 5. WARTA BERITA TERBARU -->
<!-- ========================================================================= -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4" data-aos="fade-up">
            <div>
                <span class="text-emerald-700 font-extrabold text-xs tracking-wider uppercase bg-emerald-100 px-3 py-1 rounded-full">
                    Kabar & Opini
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 font-playfair mt-2">
                    Warta Nahdliyyin
                </h2>
            </div>
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-900">
                <span>Lihat Semua Berita</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($latestPosts as $post)
                <article data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="bg-white rounded-3xl overflow-hidden shadow-lg shadow-gray-200/50 border border-gray-100 card-hover flex flex-col justify-between">
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
                                <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white shadow" style="background-color: {{ $post->category->color ?? '#00704A' }};">
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
                                    <i class="fas fa-clock"></i>
                                    {{ $post->reading_time ?? 2 }} mnt baca
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
                <div class="col-span-3 text-center py-12 text-gray-400">
                    <i class="fas fa-newspaper text-3xl mb-2"></i>
                    <p>Belum ada warta berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 6. AGENDA & KEGIATAN -->
<!-- ========================================================================= -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4" data-aos="fade-up">
            <div>
                <span class="text-emerald-700 font-extrabold text-xs tracking-wider uppercase bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Kalender Jam'iyyah
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 font-playfair mt-2">
                    Agenda & Kegiatan
                </h2>
            </div>
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-900">
                <span>Lihat Semua Agenda</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($upcomingAgendas as $agenda)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="bg-gray-50 rounded-2xl p-6 border border-gray-200/80 shadow-sm card-hover flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-emerald-700 text-white flex flex-col items-center justify-center text-center font-bold">
                                <span class="text-sm leading-none">{{ $agenda->start_at->format('d') }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-emerald-200">{{ $agenda->start_at->format('M') }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                    {{ $agenda->organizer ?? 'PRNU' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-clock text-[10px]"></i> {{ $agenda->start_at->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>

                        <h3 class="font-bold text-gray-900 text-base leading-snug">
                            <a href="{{ route('agenda.show', $agenda->slug) }}" class="hover:text-emerald-700 transition">
                                {{ $agenda->title }}
                            </a>
                        </h3>

                        <div class="space-y-1.5 text-xs text-gray-500">
                            @if($agenda->location)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-emerald-600 w-4 text-center"></i>
                                    <span>{{ $agenda->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-200/60 flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-400">
                            Status: <span class="text-emerald-600">{{ ucfirst($agenda->status) }}</span>
                        </span>
                        <a href="{{ route('agenda.show', $agenda->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    <i class="fas fa-calendar-times text-2xl mb-2"></i>
                    <p>Belum ada agenda terdekat yang dijadwalkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 7. DOKUMENTASI & GALERI KEGIATAN -->
<!-- ========================================================================= -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4" data-aos="fade-up">
            <div>
                <span class="text-emerald-700 font-extrabold text-xs tracking-wider uppercase bg-emerald-100 px-3 py-1 rounded-full">
                    Dokumentasi
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 font-playfair mt-2">
                    Galeri Jam'iyyah
                </h2>
            </div>
            <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-900">
                <span>Lihat Semua Album</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @forelse($galleries as $gallery)
                <a href="{{ route('galeri.show', $gallery->slug) }}" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}" class="group relative rounded-2xl overflow-hidden aspect-video shadow-md bg-emerald-900 card-hover block">
                    @if($gallery->cover_image)
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/40 text-3xl">
                            <i class="fas fa-images"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-4 flex flex-col justify-end">
                        <span class="text-xs text-amber-300 font-semibold mb-1 flex items-center gap-1.5">
                            <i class="fas fa-images text-[10px]"></i>
                            {{ $gallery->images->count() }} Foto
                        </span>
                        <h3 class="text-white font-bold text-sm leading-snug line-clamp-1 group-hover:text-amber-200 transition">
                            {{ $gallery->title }}
                        </h3>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    <i class="fas fa-camera text-2xl mb-2"></i>
                    <p>Belum ada album dokumentasi yang diunggah.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 8. BANNER CTA INFAQ & DONASI -->
<!-- ========================================================================= -->
<section class="py-16 bg-gradient-to-r from-emerald-900 via-emerald-800 to-emerald-950 text-white relative overflow-hidden">
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl"></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center space-y-6" data-aos="zoom-in">
        <div class="w-16 h-16 rounded-full bg-white/10 border-2 border-amber-400 mx-auto flex items-center justify-center text-amber-300 text-2xl">
            <i class="fas fa-hand-holding-heart"></i>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black font-playfair">
            Salurkan Infaq & Shodaqoh Terbaik Anda
        </h2>
        <p class="text-emerald-100 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
            Dukung gerak dakwah, kemaslahatan santri, pemeliharaan sarana ibadah, dan kemandirian umat melalui infaq jariyah di tingkat ranting.
        </p>
        <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('donasi.index') }}" class="px-8 py-4 rounded-full bg-amber-400 hover:bg-amber-300 text-emerald-950 font-extrabold text-sm shadow-xl shadow-amber-500/20 hover:scale-105 transition duration-300 flex items-center gap-2">
                <i class="fas fa-donate"></i>
                <span>Tunaikan Infaq Sekarang</span>
            </a>
            <a href="{{ route('daftar-anggota') }}" class="px-8 py-4 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-sm transition">
                <span>Daftar Jadi Bagian Nahdliyin</span>
            </a>
        </div>
    </div>
</section>
@endsection
