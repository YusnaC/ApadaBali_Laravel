<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ $jenis }}</title>
    <style>
       body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .date-range {
            margin-bottom: 15px;
            font-size: 9pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 9pt;
            background-color: #ffffff;
        }
        th {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            float: right;
            margin-top: 30px;
            text-align: right;
            font-size: 11pt;
        }
        
        .signature-content {
            margin-bottom: 10px;
            font-weight: bold;  /* Keep date bold */
        }
        
        .company-name {
            font-size: 10pt;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan {{ $jenis }}</h1>
        <!-- @if($tgl_awal && $tgl_akhir)
            <p>Periode: {{ $tgl_awal }} - {{ $tgl_akhir }}</p>
        @endif -->
    </div>

    <table>
        <thead>
            <tr>
                @if($jenis == 'Proyek')
                    <th>ID Proyek</th>
                    <th>Kategori</th>
                    <th>Tgl Proyek</th>
                    <th>Nama Proyek</th>
                    <th>Lokasi</th>
                    <th>Luas</th>
                    <th>Jumlah Lantai</th>
                    <th>Tgl Deadline</th>
                    <th>ID Drafter</th>
=                @else
                    <th>ID Furniture</th>
                    <th>Tgl Pembuatan</th>
                    <th>Nama Furniture</th>
                    <th>Jumlah Unit</th>
                    <th>Harga Unit</th>
                    <th>Lokasi</th>
                    <th>Tgl Selesai</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @if($jenis == 'Proyek')
                        <td>{{ $item->id_proyek }}</td>
                        <td>{{ 
                            $item->kategori == '1' ? 'Proyek Arsitektur' : 
                            ($item->kategori == '2' ? 'Jasa' : 
                            ($item->kategori == '3' ? 'Furniture' : $item->kategori)) 
                        }}</td>
                        <td>{{ $item->tgl_proyek }}</td>
                        <td>{{ $item->nama_proyek }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ (int)$item->luas }}</td>
                        <td>{{ (int)$item->jumlah_lantai }}</td>
                        <td>{{ $item->tgl_deadline }}</td>
                        <td>{{ $item->id_drafter }}</td>
                    @else
                        <td>{{ $item->id_furniture }}</td>
                        <td>{{ $item->tgl_pembuatan }}</td>
                        <td>{{ $item->nama_furniture }}</td>
                        <td>{{ $item->jumlah_unit }}</td>
                        <td>{{ $item->harga_unit }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->tgl_selesai }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div class="signature-content">
            <span class="city">Denpasar, {{ date('d F Y') }}</span>
        </div>
        <div class="company-name">
            Apada
        </div>
    </div>
</body>
</html>