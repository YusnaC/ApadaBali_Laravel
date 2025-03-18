<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ $jenis }}</title>
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
                <th>ID Proyek</th>
                <th>Kategori</th>
                <th>Tgl Proyek</th>
                <th>Nama Proyek</th>
                <th>Lokasi</th>
                <th>Luas</th>
                <th>Jumlah Lantai</th>
                <th>Tgl Deadline</th>
                <th>ID Drafter</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id_proyek }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->tgl_proyek }}</td>
                    <td>{{ $item->nama_proyek }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->luas }}</td>
                    <td>{{ $item->jumlah_lantai }}</td>
                    <td>{{ $item->tgl_deadline }}</td>
                    <td>{{ $item->id_drafter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>