<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $pembayaran->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <h2>Invoice Pembayaran</h2>
    <p><strong>Tanggal:</strong> {{ $pembayaran->tanggal }}</p>
    <p><strong>Klien:</strong> {{ $pembayaran->konsultasi->klien->nama ?? '-' }}</p>
    <p><strong>Advokat:</strong> {{ $pembayaran->konsultasi->advokat->nama ?? '-' }}</p>

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
        <tr>
            <th>Status</th>
            <td>{{ ucfirst(str_replace('_',' ', $pembayaran->status)) }}</td>
        </tr>
    </table>
</body>
</html>
