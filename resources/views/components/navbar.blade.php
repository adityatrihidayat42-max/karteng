<header id="main-nav" class="fixed top-0 left-0 right-0 z-40 transition-all duration-300 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-full bg-emerald-700 flex items-center justify-center shadow-md shadow-emerald-700/20 group-hover:scale-105 transition-transform duration-300 border-2 border-amber-400">
                    <i class="fas fa-star-and-crescent text-amber-300 text-xl"></i>
                </div>
                <div>
                    <span class="block text-lg font-extrabold text-emerald-900 tracking-tight leading-none group-hover:text-emerald-700 transition">
                        {{ config('app.name', 'NU Ranting') }}
                    </span>
                    <span class="text-xs font-medium text-emerald-600 tracking-wider uppercase">
                        Sistem Informasi Nahdlatul Ulama
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden xl:flex items-center gap-1 font-medium text-sm text-gray-700">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('home') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('profil') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('profil') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Profil
                </a>
                <a href="{{ route('banom.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('banom.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Banom
                </a>
                <a href="{{ route('anggota.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('anggota.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Anggota
                </a>
                <a href="{{ route('berita.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('berita.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Berita
                </a>
                <a href="{{ route('agenda.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('agenda.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Agenda
                </a>
                <a href="{{ route('galeri.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('galeri.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Galeri
                </a>
                <a href="{{ route('donasi.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 transition {{ request()->routeIs('donasi.*') ? 'text-emerald-700 font-bold bg-emerald-50' : '' }}">
                    Infaq / Donasi
                </a>
            </nav>

            <!-- Actions Desktop -->
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('daftar-anggota') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-full shadow-sm hover:shadow-md transition-all">
                    <i class="fas fa-id-card"></i>
                    <span>Daftar Anggota</span>
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-emerald-800 bg-amber-300 hover:bg-amber-400 rounded-full shadow-sm transition-all">
                        <i class="fas fa-gauge"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:text-emerald-700 transition">
                        <i class="fas fa-lock text-xs"></i>
                        <span>Login Pengurus</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center xl:hidden">
                <button type="button" id="mobile-menu-btn" class="p-2.5 rounded-xl text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 focus:outline-none transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden xl:hidden bg-white border-b border-gray-100 shadow-xl px-4 pt-2 pb-6 space-y-1 animate-fade-in">
        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-home w-6 text-emerald-600"></i> Beranda
        </a>
        <a href="{{ route('profil') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('profil') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-landmark w-6 text-emerald-600"></i> Profil Organisasi
        </a>
        <a href="{{ route('banom.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('banom.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-sitemap w-6 text-emerald-600"></i> Badan Otonom (Banom)
        </a>
        <a href="{{ route('anggota.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('anggota.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-users w-6 text-emerald-600"></i> Direktori Anggota
        </a>
        <a href="{{ route('berita.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('berita.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-newspaper w-6 text-emerald-600"></i> Warta & Berita
        </a>
        <a href="{{ route('agenda.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('agenda.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-calendar-alt w-6 text-emerald-600"></i> Agenda Kegiatan
        </a>
        <a href="{{ route('galeri.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('galeri.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-images w-6 text-emerald-600"></i> Galeri Dokumentasi
        </a>
        <a href="{{ route('donasi.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('donasi.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : '' }}">
            <i class="fas fa-hand-holding-heart w-6 text-emerald-600"></i> Infaq &amp; Donasi
        </a>

        <div class="pt-4 border-t border-gray-100 flex flex-col gap-2">
            <a href="{{ route('daftar-anggota') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-white bg-emerald-700 hover:bg-emerald-800 font-semibold text-sm shadow">
                <i class="fas fa-id-card"></i> Daftar Anggota Baru
            </a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-emerald-950 bg-amber-300 hover:bg-amber-400 font-semibold text-sm">
                    <i class="fas fa-gauge"></i> Masuk Panel Admin
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-gray-700 hover:bg-gray-100 font-semibold text-sm border border-gray-200">
                    <i class="fas fa-lock"></i> Login Pengurus
                </a>
            @endauth
        </div>
    </div>
</header>
<div class="h-20"></div>
