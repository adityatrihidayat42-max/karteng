<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Donasi - {{ config('app.name') }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #027f52 0%, #016b45 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .header .logo { width: 80px; height: 80px; border-radius: 50%; background: #fcd12b; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; font-weight: bold; color: #027f52; margin-bottom: 15px; }
        .content { background: white; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .transaction-box { background: #f0fdf4; border: 2px solid #027f52; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center; }
        .transaction-code { font-size: 24px; font-weight: bold; color: #027f52; font-family: monospace; letter-spacing: 1px; }
        .amount { font-size: 28px; font-weight: bold; color: #fcd12b; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); }
        .details { background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e9ecef; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #6c757d; font-weight: 500; }
        .detail-value { color: #333; font-weight: 600; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 14px; }
        .btn { display: inline-block; background: #027f52; color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: 600; margin-top: 20px; }
        .btn:hover { background: #016b45; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NU</div>
            <h1 style="margin: 0; font-size: 24px;">{{ $profile->nama_organisasi ?? 'NU Ranting' }}</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">{{ $profile->tagline ?? 'Menegakkan Ajaran Islam Ahlussunnah Wal Jamaah' }}</p>
        </div>

        <div class="content">
            <h2 style="color: #027f52; margin-top: 0;">Alhamdulillah, Donasi Anda Telah Dikonfirmasi</h2>

            <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

            <p>Yth. <strong>{{ $donation->donor_name }}</strong>,</p>

            <p>Terima kasih atas kebaikan hati Anda berdonasi melalui <strong>{{ $profile->nama_organisasi ?? 'NU Ranting' }}</strong>. Kami dengan senang hati menginformasikan bahwa donasi Anda telah <strong style="color: #027f52;">dikonfirmasi dan diterima</strong>.</p>

            <div class="transaction-box">
                <div class="transaction-code">{{ $donation->transaction_code }}</div>
                <div style="margin-top: 10px; color: #6c757d; font-size: 14px;">Kode Transaksi</div>
            </div>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Jenis Donasi</span>
                    <span class="detail-value">{{ $donation->donation_type_label }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nominal</span>
                    <span class="detail-value amount">{{ $donation->amount_formatted }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Metode Pembayaran</span>
                    <span class="detail-value">{{ $donation->payment_method ?? 'Transfer Bank' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Transfer</span>
                    <span class="detail-value">{{ $donation->transfer_date?->translatedFormat('d F Y') ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Konfirmasi</span>
                    <span class="detail-value">{{ $donation->confirmed_at?->translatedFormat('d F Y H:i') ?? now()->translatedFormat('d F Y H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Dikonfirmasi Oleh</span>
                    <span class="detail-value">{{ $donation->confirmedBy?->name ?? 'Pengurus' }}</span>
                </div>
            </div>

            <p>Donasi Anda akan disalurkan untuk:</p>
            <ul style="padding-left: 20px;">
                <li>Operasional dakwah dan pengajian rutin</li>
                <li>Pemeliharaan masjid/mushola dan sarana ibadah</li>
                <li>Bantuan sosial dan kemanusiaan</li>
                <li>Pendidikan dan kaderisasi santri/anggota</li>
            </ul>

            <p style="text-align: center;">
                <a href="{{ route('donasi.show', $donation->transaction_code) }}" class="btn">Lihat Detail Donasi</a>
            </p>

            <hr style="margin: 30px 0; border-color: #e9ecef;">

            <p style="font-size: 14px; color: #6c757d;">
                "Sebaik-baik manusia adalah orang yang paling bermanfaat bagi manusia."<br>
                <em>(HR. Ahmad)</em>
            </p>

            <p>Semoga Allah SWT membalas kebaikan Anda dengan kebaikan yang lebih banyak, dilipatgandakan pahalanya, dan dijadikan amal jariyah yang mengalir terus. Aamiin Ya Robbal 'Alamin.</p>

            <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh,</p>

            <p><strong>Pengurus {{ $profile->nama_organisasi ?? 'NU Ranting' }}</strong></p>
        </div>

        <div class="footer">
            <p>{{ $profile->nama_organisasi ?? 'NU Ranting' }}<br>
            {{ $profile->alamat_lengkap ?? 'Alamat Ranting' }}<br>
            Telp: {{ $profile->telepon ?? '-' }} | Email: {{ $profile->email ?? '-' }}<br>
            Website: {{ $profile->website ?? url('/') }}</p>

            <p style="margin-top: 15px; font-size: 12px;">
                Email ini dikirim otomatis, mohon tidak dibalas.<br>
                Jika Anda memiliki pertanyaan, silakan hubungi pengurus melalui kontak di atas.
            </p>
        </div>
    </div>
</body>
</html>