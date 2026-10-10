@php
    $navLogo = data_get($profile ?? null, 'logo');
@endphp
<header id="main-nav" class="nu-nav">
    <div class="nu-nav-inner">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="nu-brand" aria-label="{{ config('app.name', 'NU Ranting') }}">
            <span class="nu-brand-logo">
                @if($navLogo)
                    <img src="{{ asset('storage/' . $navLogo) }}" alt="Logo NU">
                @else
                    <i class="fas fa-star-and-crescent"></i>
                @endif
            </span>
            <span class="nu-brand-text">Sistem Informasi<br>Nahdlatul Ulama</span>
        </a>

        <!-- Desktop links -->
        <nav class="nu-links" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
            <a href="{{ route('banom.index') }}" class="{{ request()->routeIs('banom.*') ? 'active' : '' }}">Banom</a>
            <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">Anggota</a>
            <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">Berita</a>
            <a href="{{ route('agenda.index') }}" class="{{ request()->routeIs('agenda.*') ? 'active' : '' }}">Agenda</a>
            <a href="{{ route('galeri.index') }}" class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">Galeri</a>
            <a href="{{ route('donasi.index') }}" class="two-line {{ request()->routeIs('donasi.*') ? 'active' : '' }}">Infaq /<br>Donasi</a>
        </nav>

        <!-- Actions -->
        <div class="nu-actions">
            <a href="{{ route('daftar-anggota') }}" class="nu-btn-join">
                <i class="fas fa-users"></i>
                <span>Daftar<br>Anggota</span>
            </a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="nu-login">
                    <i class="fas fa-gauge"></i>
                    <span>Dashboard<br>Admin</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="nu-login">
                    <i class="fas fa-user"></i>
                    <span>Login<br>Pengurus</span>
                </a>
            @endauth
        </div>

        <!-- Burger -->
        <button type="button" id="mobile-menu-btn" class="nu-burger" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="nu-mobile">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-house"></i> Beranda</a>
        <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}"><i class="fas fa-landmark"></i> Profil Organisasi</a>
        <a href="{{ route('banom.index') }}" class="{{ request()->routeIs('banom.*') ? 'active' : '' }}"><i class="fas fa-sitemap"></i> Badan Otonom (Banom)</a>
        <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Direktori Anggota</a>
        <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita.*') ? 'active' : '' }}"><i class="fas fa-newspaper"></i> Warta &amp; Berita</a>
        <a href="{{ route('agenda.index') }}" class="{{ request()->routeIs('agenda.*') ? 'active' : '' }}"><i class="fas fa-calendar-days"></i> Agenda Kegiatan</a>
        <a href="{{ route('galeri.index') }}" class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}"><i class="fas fa-images"></i> Galeri Dokumentasi</a>
        <a href="{{ route('donasi.index') }}" class="{{ request()->routeIs('donasi.*') ? 'active' : '' }}"><i class="fas fa-hand-holding-heart"></i> Infaq &amp; Donasi</a>

        <div class="nu-mobile-cta">
            <a href="{{ route('daftar-anggota') }}" class="primary"><i class="fas fa-id-card"></i> Daftar Anggota Baru</a>
            @auth
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Masuk Panel Admin</a>
            @else
                <a href="{{ route('login') }}"><i class="fas fa-user"></i> Login Pengurus</a>
            @endauth
        </div>
    </div>
</header>
<div id="nu-progress" class="nu-progress" aria-hidden="true"></div>
<div class="nu-nav-spacer"></div>
