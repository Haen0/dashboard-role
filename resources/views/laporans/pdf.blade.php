<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Konsultasi</h2>
    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th>Jumlah Kasus</th>
                <th>Jumlah Konsultasi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $laporan)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($laporan->tanggal_dari)->format('d-m-Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($laporan->tanggal_ke)->format('d-m-Y') }}
                    </td>
                    <td>{{ $laporan->jumlah_kasus }}</td>
                    <td>{{ $laporan->jumlah_konsultasi }}</td>
                    <td>{{ $laporan->catatan_manajer ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
