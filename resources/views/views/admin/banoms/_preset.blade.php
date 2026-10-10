{{-- Pilihan cepat Banom NU: pilih satu, kolom Nama / Singkatan / Deskripsi / Ketua terisi otomatis.
     Ketua = pimpinan tingkat nasional sebagai pengisi sementara; ganti dengan ketua ranting yang sebenarnya. --}}
<div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
    <div class="block text-xs font-bold text-emerald-800 mb-2">
        <i class="fas fa-wand-magic-sparkles mr-1"></i> Klik salah satu Banom (terisi otomatis)
    </div>
    <div class="flex flex-wrap gap-2" id="banom-presets">
        @foreach(['Muslimat NU', 'Fatayat NU', 'GP Ansor', 'Banser', 'IPNU', 'IPPNU'] as $i => $label)
            <button type="button" data-preset="{{ $i }}"
                    class="banom-chip px-3.5 py-1.5 rounded-full text-xs font-bold border border-emerald-300 bg-white text-emerald-800 hover:bg-emerald-700 hover:text-white hover:border-emerald-700 transition">
                {{ $label }}
            </button>
        @endforeach
    </div>
    <p class="text-[11px] text-emerald-700/80 mt-2">Nama, singkatan, deskripsi, dan nama ketua akan terisi sendiri. Nama ketua adalah pimpinan pusat sebagai pengisi sementara. Ganti dengan ketua ranting Anda sebelum menyimpan.</p>
</div>

<script>
(function () {
    var presets = [
        { nama: 'Muslimat Nahdlatul Ulama', singkatan: 'Muslimat NU', ketua: 'Hj. Arifatul Choiri Fauzi', deskripsi: 'Wadah untuk ibu-ibu / wanita NU dewasa.' },
        { nama: 'Fatayat Nahdlatul Ulama', singkatan: 'Fatayat NU', ketua: 'Dewi Winarti (Plt.)', deskripsi: 'Wadah untuk pemudi / perempuan muda NU.' },
        { nama: 'Gerakan Pemuda Ansor', singkatan: 'GP Ansor', ketua: 'H. Addin Jauharudin', deskripsi: 'Wadah untuk pemuda NU.' },
        { nama: 'Barisan Ansor Serbaguna', singkatan: 'Banser', ketua: 'Muhammad Syafiq Syauqi', deskripsi: 'Unit paramiliter/keamanan di bawah GP Ansor.' },
        { nama: 'Ikatan Pelajar Nahdlatul Ulama', singkatan: 'IPNU', ketua: 'Muhammad Agil Nuruz Zaman', deskripsi: 'Wadah untuk pelajar/remaja laki-laki NU.' },
        { nama: 'Ikatan Pelajar Putri Nahdlatul Ulama', singkatan: 'IPPNU', ketua: 'Whasfi Velasufah', deskripsi: 'Wadah untuk pelajar/remaja perempuan NU.' }
    ];
    function setVal(name, v) {
        var el = document.querySelector('[name="' + name + '"]');
        if (el) { el.value = v; el.dispatchEvent(new Event('input', { bubbles: true })); }
    }
    document.querySelectorAll('.banom-chip').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var p = presets[parseInt(btn.getAttribute('data-preset'), 10)];
            if (!p) return;
            setVal('nama', p.nama); setVal('singkatan', p.singkatan);
            setVal('deskripsi', p.deskripsi); setVal('ketua', p.ketua);
            document.querySelectorAll('.banom-chip').forEach(function (b) { b.classList.remove('bg-emerald-700', 'text-white'); });
            btn.classList.add('bg-emerald-700', 'text-white');
        });
    });
})();
</script>
