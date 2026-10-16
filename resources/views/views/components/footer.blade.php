@php
    $fp = $profile ?? null;
    $footLogo = data_get($fp, 'logo');
@endphp
<footer class="nu-footer">
    <div class="nu-footer-grid">
        <!-- Identitas -->
        <div>
            <div class="nu-footer-id">
                <span class="nu-brand-logo">
                    @if($footLogo)
                        <img src="{{ asset('storage/' . $footLogo) }}" alt="Logo NU">
                    @else
                        <i class="fas fa-star-and-crescent"></i>
                    @endif
                </span>
                <strong>Sistem Informasi<br>Nahdlatul Ulama</strong>
            </div>
            <p class="lead">Menegakkan Ajaran Islam Ahlussunnah Wal Jamaah demi terwujudnya masyarakat yang adil, makmur, dan berkeadaban.</p>
            <div class="nu-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <!-- Tautan Cepat -->
        <div>
            <h4>Tautan Cepat</h4>
            <ul>
                <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                <li><a href="{{ route('profil') }}"><i class="fas fa-chevron-right"></i> Profil &amp; Sejarah</a></li>
                <li><a href="{{ route('banom.index') }}"><i class="fas fa-chevron-right"></i> Badan Otonom</a></li>
                <li><a href="{{ route('anggota.index') }}"><i class="fas fa-chevron-right"></i> Direktori Anggota</a></li>
                <li><a href="{{ route('berita.index') }}"><i class="fas fa-chevron-right"></i> Warta Berita</a></li>
                <li><a href="{{ route('agenda.index') }}"><i class="fas fa-chevron-right"></i> Agenda Kegiatan</a></li>
            </ul>
        </div>

        <!-- Layanan Umat -->
        <div>
            <h4>Layanan Umat</h4>
            <ul>
                <li><a href="{{ route('daftar-anggota') }}"><i class="fas fa-chevron-right"></i> Pendaftaran Anggota (KTA)</a></li>
                <li><a href="{{ route('donasi.index') }}"><i class="fas fa-chevron-right"></i> Infaq &amp; Sedekah Online</a></li>
                <li><a href="{{ route('galeri.index') }}"><i class="fas fa-chevron-right"></i> Dokumentasi Kegiatan</a></li>
                <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Portal Pengurus</a></li>
            </ul>
        </div>

        <!-- Sekretariat -->
        <div>
            <h4>Sekretariat</h4>
            <ul class="contact">
                <li><i class="fas fa-location-dot"></i><span>{{ data_get($fp, 'alamat_lengkap', 'Kantor Sekretariat Ranting Nahdlatul Ulama Karangtengah, Indonesia') }}</span></li>
                <li><i class="fas fa-phone"></i><span>{{ data_get($fp, 'telepon', '+62 812-3456-7890') }}</span></li>
                <li><i class="fas fa-envelope"></i><span>{{ data_get($fp, 'email', 'sekretariat@nu.or.id') }}</span></li>
                <li><i class="fas fa-clock"></i><span>Senin - Sabtu: 08.00 - 16.00 WIB</span></li>
            </ul>
        </div>
    </div>

    <div class="nu-footer-bottom">
        <span>&copy; {{ date('Y') }} Nahdlatul Ulama. All rights reserved.</span>
        <span><em>Dikelola dengan khidmah untuk umat</em> <i class="fas fa-heart"></i></span>
    </div>
</footer>
