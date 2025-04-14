<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($reportType) }}</title>
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
            font-weight: bold;
        }
        
        .signature-content {
            margin-bottom: 10px;
        }
        
        .company-name {
            font-size: 10pt;
            font-weight: normal;  /* Added this line */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan {{ ucfirst($reportType) }}</h1>
    </div>

    <div class="date-range">
        <!-- Periode: {{ $tgl_awal }} - {{ $tgl_akhir }} -->
    </div>

    <table>
        <thead>
            <tr>
                @if($reportType === 'pemasukan')
                    <th>No</th>
                    <th>Jenis Order</th>
                    <th>ID Order</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah</th>
                    <th>Termin</th>
                    <th>Keterangan</th>
                @else
                    <th>No</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                    <th>Keterangan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    @if($reportType === 'pemasukan')
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->jenis_order }}</td>
                        <td class="text-center">{{ $item->id_order }}</td>
                        <td class="text-center">{{ $item->tgl_transaksi }}</td>
                        <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->termin }}</td>
                        <td>{{ $item->keterangan }}</td>
                    @else
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $item->tanggal_transaksi }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div class="signature-content">
            Denpasar, {{ date('d F Y') }}
        </div>
        <div class="company-name">
            Apada
        </div>
    </div>
</body>
</html>