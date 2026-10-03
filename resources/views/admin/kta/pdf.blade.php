<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>KTA - {{ $member->nis }}</title>
    <style>
        @page {
            margin: 0;
            size: 250pt 160pt landscape;
        }
        body {
            margin: 0;
            padding: 10pt;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #005538;
            color: #ffffff;
            font-size: 8pt;
        }
        .card {
            width: 100%;
            height: 100%;
            position: relative;
            box-sizing: border-box;
            border: 1.5pt solid #c9a227;
            background: #005538;
            padding: 6pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
        }
        .title-main {
            font-size: 8pt;
            font-weight: bold;
            color: #ffd700;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .title-sub {
            font-size: 6.5pt;
            font-weight: bold;
            color: #ffffff;
        }
        .title-kta {
            font-size: 5pt;
            color: #a3e635;
            letter-spacing: 0.5pt;
        }
        .nis-badge {
            background-color: #ffd700;
            color: #004d30;
            font-size: 6.5pt;
            font-weight: bold;
            padding: 2pt 4pt;
            border-radius: 2pt;
            text-align: right;
            font-family: monospace;
        }
        .divider {
            border-bottom: 0.8pt solid #c9a227;
            margin: 4pt 0;
        }
        .content-table td {
            vertical-align: top;
        }
        .photo-box {
            width: 38pt;
            height: 48pt;
            border: 1pt solid #ffd700;
            background-color: #ffffff;
            text-align: center;
        }
        .photo-box img {
            width: 38pt;
            height: 48pt;
            object-fit: cover;
        }
        .member-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 1pt;
        }
        .member-info {
            font-size: 6pt;
            color: #e5e7eb;
            line-height: 1.3;
        }
        .member-banom {
            color: #fde047;
            font-weight: bold;
        }
        .qr-box {
            width: 34pt;
            height: 34pt;
            background: #ffffff;
            padding: 1pt;
            text-align: center;
            border-radius: 2pt;
        }
        .qr-box img {
            width: 34pt;
            height: 34pt;
        }
        .footer-text {
            font-size: 4.5pt;
            color: #a7f3d0;
            margin-top: 3pt;
            border-top: 0.5pt solid rgba(255,255,255,0.2);
            padding-top: 2pt;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 20pt; text-align: center;">
                    <div style="font-size: 14pt; color: #ffd700; font-weight: bold;">NU</div>
                </td>
                <td>
                    <div class="title-main">NAHDLATUL ULAMA</div>
                    <div class="title-sub">{{ $profile->nama_organisasi ?? 'PENGURUS RANTING' }}</div>
                    <div class="title-kta">KARTU TANDA ANGGOTA RESMI</div>
                </td>
                <td style="text-align: right; width: 60pt;">
                    <span class="nis-badge">{{ $member->nis }}</span>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Body -->
        <table class="content-table" style="margin-top: 2pt;">
            <tr>
                <!-- Foto -->
                <td style="width: 42pt;">
                    <div class="photo-box">
                        @if($member->foto && file_exists(storage_path('app/public/' . $member->foto)))
                            <img src="{{ storage_path('app/public/' . $member->foto) }}" alt="Foto">
                        @else
                            <div style="color: #005538; font-size: 6pt; padding-top: 18pt;">FOTO</div>
                        @endif
                    </div>
                </td>

                <!-- Info -->
                <td style="padding-left: 6pt;">
                    <div class="member-name">{{ $member->nama_lengkap }}</div>
                    <div class="member-info">
                        Banom: <span class="member-banom">{{ $member->banom ? $member->banom->nama : 'Pengurus Ranting' }}</span><br>
                        Amanah: <strong>{{ $member->jabatan ?? 'Anggota' }}</strong><br>
                        Wilayah: {{ $member->desa_kelurahan ?? 'Ranting' }}, {{ $member->kecamatan ?? '' }}<br>
                        Masa Khidmah: 2024 - 2029
                    </div>
                </td>

                <!-- QR Code -->
                @if($qrCode)
                    <td style="width: 36pt; text-align: right;">
                        <div class="qr-box">
                            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR">
                        </div>
                        <div style="font-size: 4pt; color: #a7f3d0; text-align: center; margin-top: 1pt;">SCAN ASLI</div>
                    </td>
                @endif
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer-text">
            <table style="width: 100%;">
                <tr>
                    <td>Merawat Jagat, Membangun Peradaban</td>
                    <td style="text-align: right;">Pangkalan Data Jam'iyyah NU</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
