<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4285f4; color: white; }
        .header { margin-bottom: 30px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan {{ $jenis }}</h2>
        @if($tgl_awal && $tgl_akhir)
            <p>Periode: {{ $tgl_awal }} - {{ $tgl_akhir }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Order</th>
                <th>ID Order</th>
                <th>Tgl Transaksi</th>
                <th>Jumlah</th>
                <th>Termin</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->jenis_order }}</td>
                    <td>{{ $item->id_order }}</td>
                    <td>{{ $item->tgl_transaksi ?? $item->tanggal_transaksi }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->termin }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>