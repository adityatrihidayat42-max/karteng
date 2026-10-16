@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Layanan ZISWAF
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Infaq, Shodaqoh &amp; Donasi</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Salurkan infaq terbaik Anda untuk mendukung kemaslahatan santri, kegiatan jam'iyyah, dan kemandirian umat.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-12">
    <!-- Rekening & QRIS Card + Tata Cara -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Rekening / QRIS dengan Tab -->
        <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col" data-aos="fade-up">
            <!-- Tab Switcher -->
            <div class="flex rounded-xl overflow-hidden border border-white/20 mb-5 relative z-10">
                <button id="tab-transfer" onclick="switchTab('transfer')"
                    class="flex-1 py-2 text-xs font-bold transition-all bg-white text-emerald-900">
                    <i class="fas fa-university mr-1"></i> Transfer Bank
                </button>
                <button id="tab-qris" onclick="switchTab('qris')"
                    class="flex-1 py-2 text-xs font-bold transition-all text-emerald-200 hover:text-white">
                    <i class="fas fa-qrcode mr-1"></i> QRIS
                </button>
            </div>

            <!-- Transfer Bank Panel -->
            <div id="panel-transfer" class="space-y-4 relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-xs uppercase font-bold tracking-wider text-amber-300">Rekening Resmi</span>
                    <i class="fas fa-university text-xl text-emerald-300"></i>
                </div>
                <div>
                    <span class="text-xs text-emerald-200 block">Bank Tujuan:</span>
                    <h3 class="text-xl font-bold text-white">{{ $profile->rekening_bank ?? 'Bank Syariah Indonesia (BSI)' }}</h3>
                </div>
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 space-y-1">
                    <span class="text-[11px] text-emerald-200 block">Nomor Rekening:</span>
                    <div class="font-mono text-xl sm:text-2xl font-bold tracking-wider text-amber-300 select-all">
                        {{ $profile->nomor_rekening ?? '7123-4567-8901' }}
                    </div>
                    <span class="text-xs text-emerald-100 block">a.n. {{ $profile->nama_rekening ?? 'Pengurus Ranting Nahdlatul Ulama Karangtengah' }}</span>
                </div>
                <p class="text-[11px] text-emerald-300/80">
                    Pastikan transfer ditujukan ke rekening resmi atas nama jam'iyyah.
                </p>
            </div>

            <!-- QRIS Panel -->
            <div id="panel-qris" class="hidden space-y-4 relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-xs uppercase font-bold tracking-wider text-amber-300">Bayar via QRIS</span>
                    <i class="fas fa-qrcode text-xl text-emerald-300"></i>
                </div>
                @if($profile->qris_image_url)
                    <div class="flex flex-col items-center space-y-3">
                        <div class="bg-white p-3 rounded-2xl shadow-lg">
                            <img src="{{ $profile->qris_image_url }}" alt="QRIS {{ $profile->nama_organisasi }}"
                                 class="w-full max-w-[160px] mx-auto rounded-lg">
                        </div>
                        <p class="text-[11px] text-emerald-200 text-center">
                            Scan QR code ini menggunakan aplikasi e-wallet, mobile banking, atau kamera HP Anda.
                        </p>
                        <div class="w-full px-3 py-2 rounded-xl bg-white/10 border border-white/10 text-center">
                            <span class="text-[11px] text-emerald-200">Didukung: GoPay, OVO, DANA, ShopeePay, LinkAja, &amp; semua m-Banking</span>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 space-y-2 text-center">
                        <i class="fas fa-qrcode text-4xl text-emerald-400/50"></i>
                        <p class="text-xs text-emerald-300">QRIS belum tersedia. Silakan gunakan transfer bank.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tata Cara Berinfaq -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
            <div>
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <i class="fas fa-list-ol text-emerald-700"></i>
                    <span>Alur Infaq &amp; Konfirmasi</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs text-gray-600">
                    <div class="p-4 rounded-2xl bg-gray-50 space-y-2 border border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">1</div>
                        <h4 class="font-bold text-gray-800">Isi Form Donasi</h4>
                        <p class="text-gray-500">Tentukan nama, nominal, dan jenis donasi pada formulir di bawah ini.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 space-y-2 border border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">2</div>
                        <h4 class="font-bold text-gray-800">Transfer / Scan QRIS</h4>
                        <p class="text-gray-500">Kirim dana via transfer bank ke nomor rekening resmi, atau scan QRIS PRNU.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 space-y-2 border border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">3</div>
                        <h4 class="font-bold text-gray-800">Unggah Bukti</h4>
                        <p class="text-gray-500">Unggah struk / tangkapan layar. Admin akan memverifikasi dalam 1×24 jam.</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                <span class="text-gray-500">Total Infaq Terhimpun:</span>
                <span class="font-extrabold text-emerald-700 text-base font-mono">Rp {{ number_format($totalConfirmed, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Form Donasi & Daftar Donatur Terakhir -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Pengajuan Donasi -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-8 shadow-xl border border-gray-100" data-aos="fade-up">
            <h3 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-emerald-700"></i>
                <span>Formulir Pengajuan Donasi / Infaq</span>
            </h3>

            <form action="{{ route('donasi.store') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="payment_method" id="form_payment_method" value="transfer">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        Nama Lengkap Donatur / Hamba Allah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="donor_name" value="{{ old('donor_name') }}" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none"
                           placeholder="Contoh: H. M. Sholihin atau Hamba Allah">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        Jenis Donasi <span class="text-red-500">*</span>
                    </label>
                    <select name="donation_type" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                        <option value="infaq" {{ old('donation_type') == 'infaq' ? 'selected' : '' }}>Infaq</option>
                        <option value="sedekah" {{ old('donation_type') == 'sedekah' ? 'selected' : '' }}>Sedekah</option>
                        <option value="donasi_kegiatan" {{ old('donation_type') == 'donasi_kegiatan' ? 'selected' : '' }}>Donasi Kegiatan</option>
                        <option value="donasi_umum" {{ old('donation_type') == 'donasi_umum' ? 'selected' : '' }}>Donasi Umum</option>
                        <option value="lainnya" {{ old('donation_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                        Metode Pembayaran
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" id="btn-transfer"
                            onclick="selectPaymentMethod('transfer')"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-emerald-600 bg-emerald-50 text-emerald-800 font-bold text-xs transition-all">
                            <i class="fas fa-university"></i> Transfer Bank
                        </button>
                        <button type="button" id="btn-qris"
                            onclick="selectPaymentMethod('qris')"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-500 font-bold text-xs transition-all hover:border-emerald-400">
                            <i class="fas fa-qrcode"></i> QRIS
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        Nominal Donasi / Infaq (Rupiah) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-bold text-gray-400 text-sm">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount') }}" min="1" step="any" required
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-mono font-bold focus:bg-white focus:border-emerald-600 outline-none"
                               placeholder="Bebas seikhlasnya (tanpa batasan minimal)">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Nominal bebas dan seikhlasnya tanpa batasan minimal.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                        Doa / Hajat / Catatan Donatur
                    </label>
                    <textarea name="notes" rows="2"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none"
                              placeholder="Tuliskan niat doa, hajat barokah, atau pesan Anda...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold rounded-xl shadow-lg shadow-emerald-700/30 hover:scale-[1.01] transition-all text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>Lanjutkan &amp; Dapatkan Kode Transaksi</span>
                </button>
            </form>
        </div>

        <!-- Recent Donors Feed -->
        <div class="lg:col-span-5 space-y-6" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center justify-between">
                    <span>Donatur Terkonfirmasi</span>
                    <span class="text-xs text-emerald-700 font-semibold">{{ $donorsCount }} Transaksi</span>
                </h3>

                <div class="space-y-3">
                    @forelse($recentDonations as $d)
                        <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <div class="font-bold text-xs text-gray-800">{{ $d->donor_name }}</div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $d->donation_type_label }} &bull; {{ $d->confirmed_at ? $d->confirmed_at->diffForHumans() : '' }}
                                </div>
                            </div>
                            <div class="font-mono text-xs font-bold text-emerald-700">
                                {{ $d->amount_formatted }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            Belum ada riwayat donasi terkonfirmasi.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    const transferBtn = document.getElementById('tab-transfer');
    const qrisBtn = document.getElementById('tab-qris');
    const transferPanel = document.getElementById('panel-transfer');
    const qrisPanel = document.getElementById('panel-qris');

    if (tab === 'transfer') {
        transferBtn.classList.add('bg-white', 'text-emerald-900');
        transferBtn.classList.remove('text-emerald-200');
        qrisBtn.classList.remove('bg-white', 'text-emerald-900');
        qrisBtn.classList.add('text-emerald-200');
        transferPanel.classList.remove('hidden');
        qrisPanel.classList.add('hidden');
    } else {
        qrisBtn.classList.add('bg-white', 'text-emerald-900');
        qrisBtn.classList.remove('text-emerald-200');
        transferBtn.classList.remove('bg-white', 'text-emerald-900');
        transferBtn.classList.add('text-emerald-200');
        qrisPanel.classList.remove('hidden');
        transferPanel.classList.add('hidden');
    }
}

function selectPaymentMethod(method) {
    document.getElementById('form_payment_method').value = method;
    const btnTransfer = document.getElementById('btn-transfer');
    const btnQris = document.getElementById('btn-qris');
    if (method === 'transfer') {
        btnTransfer.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-800');
        btnTransfer.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-500');
        btnQris.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-800');
        btnQris.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-500');
    } else {
        btnQris.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-800');
        btnQris.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-500');
        btnTransfer.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-800');
        btnTransfer.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-500');
    }
    // Also sync the info card tabs
    switchTab(method);
}
</script>
@endsection
