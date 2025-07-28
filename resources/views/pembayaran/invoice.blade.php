<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $pembayaran->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { padding: 8px; border: 1px solid #000000; text-align: left; background-color: #dbdbdb; }
        td { padding: 8px; border: 1px solid #000000; text-align: left; }
        img { width: 25rem; }
    </style>
</head>
<body>
    <img src="{{ public_path('logo.jpg') }}" alt="Mr Oky & Partners">
    <hr>
    <h2 style="text-align: center;">Invoice Pembayaran</h2>
    <hr>

    <p style="margin-top: 30px;"><strong>Detail Invoice</strong></p>
    <p><strong>Tanggal:</strong> {{ $exported_at  }}</p>
    <p><strong>Klien:</strong> {{ $pembayaran->konsultasi->klien->nama ?? '-' }}</p>
    <p style="margin-bottom: 30px;"><strong>Advokat:</strong> {{ $pembayaran->konsultasi->advokat->nama ?? '-' }}</p>

    <h3>Rincian Konsultasi</h3>
    <hr>
    <table>
        <tr>
            <th>Jenis Kasus</th>
            <td>{{ $pembayaran->konsultasi->jenis_kasus }}</td>
        </tr>
        <tr>
            <th>Ringkasan</th>
            <td>{{ $pembayaran->konsultasi->ringkasan }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
        </tr>
    </table>
    <p style="margin-bottom: 30px;"><i>*mohon dibayarkan sebelum tanggal {{ $pembayaran->tanggal }}</i></p>

    <p style="margin-top: 30px;">Pembayaran ditransfer ke Rekening</p>
    <p>Atas Nama &nbsp;&nbsp;&nbsp;&nbsp;:<strong> MR. OKY & Partners</strong></p>
    <p>Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<strong> Bank BCA</strong></p>
    <p>No. Rekening :<strong> 876-635-765</strong></p>
    <p style="margin-bottom: 30px;">Dan Bukti Transfer Dikirim ke WA No.HP: 0812-3456-7890</p>
</body>
</html>
