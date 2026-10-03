<footer class="bg-emerald-950 text-gray-300 relative overflow-hidden pt-16 pb-12 border-t-4 border-amber-400">
    <!-- Subtle Background Glows -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-700/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Col 1: Identity -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-emerald-800 border-2 border-amber-400 flex items-center justify-center">
                        <i class="fas fa-star-and-crescent text-amber-300 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-extrabold text-lg leading-tight">{{ config('app.name', 'NU Ranting') }}</h3>
                        <p class="text-xs text-amber-400 font-semibold tracking-wider uppercase">Nahdlatul Ulama</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Menegakkan ajaran Islam Ahlussunnah wal Jama'ah an-Nahdliyyah, merawat jagat, membangun peradaban di tingkat ranting dan masyarakat.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-700 text-amber-300 flex items-center justify-center transition hover:scale-110 shadow-sm">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-700 text-amber-300 flex items-center justify-center transition hover:scale-110 shadow-sm">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-700 text-amber-300 flex items-center justify-center transition hover:scale-110 shadow-sm">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-700 text-amber-300 flex items-center justify-center transition hover:scale-110 shadow-sm">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h4 class="text-white font-bold text-base mb-4 relative inline-block pb-2">
                    Tautan Cepat
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-amber-400"></span>
                </h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Beranda</a></li>
                    <li><a href="{{ route('profil') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Profil & Sejarah</a></li>
                    <li><a href="{{ route('banom.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Badan Otonom</a></li>
                    <li><a href="{{ route('anggota.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Direktori Anggota</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Warta Berita</a></li>
                    <li><a href="{{ route('agenda.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Agenda Kegiatan</a></li>
                </ul>
            </div>

            <!-- Col 3: Layanan Digital -->
            <div>
                <h4 class="text-white font-bold text-base mb-4 relative inline-block pb-2">
                    Layanan Umat
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-amber-400"></span>
                </h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('daftar-anggota') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Pendaftaran Anggota (KTA)</a></li>
                    <li><a href="{{ route('donasi.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Infaq & Sedekah Online</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Dokumentasi Kegiatan</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-amber-300 transition flex items-center gap-2"><i class="fas fa-angle-right text-emerald-500 text-xs"></i> Portal Pengurus</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact & Secretariat -->
            <div>
                <h4 class="text-white font-bold text-base mb-4 relative inline-block pb-2">
                    Sekretariat
                    <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-amber-400"></span>
                </h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-amber-400 mt-1"></i>
                        <span>Kantor Sekretariat Ranting Nahdlatul Ulama, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-amber-400"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-amber-400"></i>
                        <span>sekretariat@nu.or.id</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-clock text-amber-400"></i>
                        <span>Senin - Sabtu: 08.00 - 16.00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-emerald-900/60 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'NU Ranting') }}. Hak Cipta Dilindungi.</p>
            <p class="mt-2 sm:mt-0 flex items-center gap-1 text-gray-400">
                <span>Dikelola dengan khidmah untuk umat</span>
                <i class="fas fa-heart text-red-500 text-[10px]"></i>
            </p>
        </div>
    </div>
</footer>
