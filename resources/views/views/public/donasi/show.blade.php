@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12 px-4 text-center">
    <div class="max-w-2xl mx-auto space-y-2">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Instruksi Pembayaran Donasi
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold font-playfair">Kode Transaksi: {{ $donation->transaction_code }}</h1>
    </div>
</div>

<div class="max-w-2xl mx-auto px-4 sm:px-6 -mt-6 pb-16">
    <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 space-y-6" data-aos="fade-up">

        <!-- Status Badge -->
        <div class="p-4 rounded-2xl flex items-center justify-between {{ $donation->status === 'confirmed' ? 'bg-emerald-50 text-emerald-900 border border-emerald-200' : ($donation->status === 'rejected' ? 'bg-red-50 text-red-900 border border-red-200' : 'bg-amber-50 text-amber-900 border border-amber-200') }}">
            <div class="flex items-center gap-3">
                <i class="fas {{ $donation->status === 'confirmed' ? 'fa-check-circle text-emerald-600' : ($donation->status === 'rejected' ? 'fa-times-circle text-red-600' : 'fa-hourglass-half text-amber-600') }} text-xl"></i>
                <div>
                    <div class="text-xs uppercase font-bold tracking-wider">Status Transaksi:</div>
                    <div class="font-extrabold text-sm">{{ $donation->status_label }}</div>
                </div>
            </div>
            <span class="font-mono text-xs font-semibold">{{ $donation->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <!-- Rincian Donasi -->
        <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Donatur:</span>
                <span class="font-bold text-gray-800">{{ $donation->donor_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Donasi:</span>
                <span class="font-semibold text-emerald-700">{{ $donation->donation_type_label }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Metode Pembayaran:</span>
                <span class="font-semibold text-gray-700">
                    @if($donation->payment_method === 'qris')
                        <i class="fas fa-qrcode text-emerald-600 mr-1"></i> QRIS
                    @else
                        <i class="fas fa-university text-emerald-600 mr-1"></i> Transfer Bank
                    @endif
                </span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                <span class="text-gray-600 font-bold">Nominal:</span>
                <span class="font-mono text-xl font-extrabold text-emerald-700">{{ $donation->amount_formatted }}</span>
            </div>
        </div>

        <!-- Info Pembayaran: QRIS atau Transfer Bank -->
        @if($donation->payment_method === 'qris')
            <!-- QRIS Section -->
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-100 space-y-4">
                <div class="font-bold text-sm text-emerald-900 flex items-center gap-2">
                    <i class="fas fa-qrcode text-emerald-700"></i>
                    Pembayaran via QRIS
                </div>
                @if($profile->qris_image_url)
                    <div class="flex flex-col items-center space-y-3">
                        <div class="bg-white p-3 rounded-2xl shadow-md inline-block">
                            <img src="{{ $profile->qris_image_url }}" alt="QRIS" class="w-44 h-44 object-contain rounded-lg">
                        </div>
                        <p class="text-xs text-emerald-800 text-center">
                            Scan QR code di atas menggunakan aplikasi e-wallet (GoPay, OVO, DANA, ShopeePay) atau mobile banking Anda.
                            Masukkan nominal <strong>{{ $donation->amount_formatted }}</strong> dengan tepat.
                        </p>
                    </div>
                @else
                    <p class="text-xs text-emerald-800">QRIS belum tersedia. Silakan hubungi pengurus untuk informasi pembayaran.</p>
                @endif
            </div>
        @else
            <!-- Transfer Bank Section -->
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-100 space-y-2 text-xs text-emerald-900">
                <div class="font-bold text-sm flex items-center gap-2">
                    <i class="fas fa-university text-emerald-700"></i>
                    Tujuan Transfer Bank
                </div>
                <div>Bank: <strong>{{ $profile->rekening_bank ?? 'Bank Syariah Indonesia' }}</strong></div>
                <div>Nomor Rekening: <strong class="font-mono text-sm select-all">{{ $profile->nomor_rekening ?? '7123-4567-8901' }}</strong></div>
                <div>Atas Nama: <strong>{{ $profile->nama_rekening ?? 'Pengurus Ranting Nahdlatul Ulama' }}</strong></div>
                <div class="pt-2 border-t border-emerald-100">
                    Nominal transfer: <strong class="text-emerald-800">{{ $donation->amount_formatted }}</strong>
                </div>
            </div>
        @endif

        <!-- Form Upload Bukti -->
        @if($donation->status !== 'confirmed')
            <div class="space-y-4 pt-2">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <i class="fas fa-upload text-emerald-700"></i>
                    <span>Unggah Bukti Pembayaran</span>
                </h3>

                <form action="{{ route('donasi.upload-bukti', $donation->transaction_code) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Tanggal Transfer / Bayar <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none">
                    </div>

                    @if($donation->payment_method !== 'qris')
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Bank Pengirim (Opsional)
                        </label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $donation->bank_name) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-emerald-600 outline-none"
                               placeholder="Contoh: BCA / Mandiri / BRI / BSI">
                    </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Screenshot / Foto Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="proof_image" accept="image/*" required
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-700">
                        <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG. Maks 3MB.</p>
                    </div>

                    @if($donation->proof_image)
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 flex items-center gap-3">
                            <i class="fas fa-check text-emerald-600 text-sm"></i>
                            <span class="text-xs text-gray-600">Bukti sudah pernah diunggah. Unggah ulang untuk memperbarui.</span>
                        </div>
                    @endif

                    <button type="submit"
                            class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-md transition-all text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Kirim Bukti Pembayaran</span>
                    </button>
                </form>
            </div>
        @else
            <div class="p-6 rounded-2xl bg-emerald-50 text-center space-y-2">
                <i class="fas fa-award text-3xl text-emerald-600"></i>
                <h3 class="font-bold text-emerald-950 text-base">Jazakumullah Khairan Katsiran</h3>
                <p class="text-xs text-emerald-800">
                    Donasi Anda telah dikonfirmasi oleh bendahara / pengurus ranting. Semoga menjadi amal jariyah yang barokah.
                </p>
            </div>
        @endif

        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-emerald-700 font-medium">
                &larr; Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection
