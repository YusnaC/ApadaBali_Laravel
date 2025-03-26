<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class laporanpemasukanController extends Controller
{
    public function laporanpemasukan(Request $request)
    {
        $reportType = $request->input('reportType', 'pemasukan');
        
        if ($reportType === 'pemasukan') {
            $query = Pemasukan::query();
            $dateField = 'tgl_transaksi';
        } else {
            $query = Pengeluaran::query();
            $dateField = 'tanggal_transaksi';
        }
    
        // Filter by date range if provided
        if ($request->filled(['tgl_awal', 'tgl_akhir'])) {
            $query->whereBetween($dateField, [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }
    
        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search, $reportType) {
                if ($reportType === 'pemasukan') {
                    $q->where('jenis_order', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%");
                } else {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%");
                }
            });
        }
    
        // Sorting
        $sortField = $request->query('sort', $dateField);
        $sortDirection = $request->query('direction', 'desc');
        
        // Adjust sort field for pengeluaran
        if ($reportType === 'pengeluaran') {
            $sortField = $this->mapSortField($sortField);
        }
        
        $query->orderBy($sortField, $sortDirection);
    
        // Pagination
        $perPage = $request->query('entries', 10);
        $items = $query->paginate($perPage);
    
        // Transform the data
        $projects = collect($items->items())->map(function ($item) use ($reportType) {
            if ($reportType === 'pemasukan') {
                return (object) [
                    'id' => $item->id,
                    'jenis_order' => $item->jenis_order,
                    'id_order' => $item->id_order,
                    'nama_barang' => null,
                    'tanggal_transaksi' => $item->tgl_transaksi ? $item->tgl_transaksi->format('d/m/y') : '',
                    'jumlah' => $item->jumlah,
                    'termin' => $item->termin,
                    'keterangan' => $item->keterangan,
                    'harga_satuan' => number_format(0, 0, ',', '.'),
                    'total_harga' => number_format(0, 0, ',', '.'),
                ];
            } else {
                return (object) [
                    'id' => $item->id,
                    'jenis_order' => null,
                    'id_order' => null,
                    'tanggal_transaksi' => $item->tanggal_transaksi ? $item->tanggal_transaksi->format('d/m/y') : '',
                    'nama_barang' => $item->nama_barang,
                    'jumlah' => $item->jumlah,
                    'termin' => null,
                    'harga_satuan' => number_format($item->harga_satuan, 0, ',', '.'),
                    'total_harga' => number_format($item->total_harga, 0, ',', '.'),
                    'keterangan' => $item->keterangan,
                ];
            }
        });
        // dd($projects);
        return view('tables.laporanPemasukan', [
            'projects' => $projects,
            'total' => $items->total(),
            'perPage' => $perPage,
            'currentPage' => $items->currentPage(),
            'search' => $search ?? '',
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'reportType' => $reportType
        ]);
    }

private function mapSortField($field)
{
    $fieldMap = [
        'tgl_transaksi' => 'tanggal_transaksi',
        'jenis_order' => 'nama_barang',
    ];

    return $fieldMap[$field] ?? $field;
}

    // Method to handle export
    public function exportPDF(Request $request)
    {
        $jenis = $request->input('jenis');
        
        if ($jenis == '2') {
            $query = DB::table('pengeluarans')
            ->select('id', 'tanggal_transaksi AS tgl_transaksi', 'nama_barang AS jenis_order', DB::raw("NULL AS id_order"), 'jumlah', DB::raw("NULL AS termin"), 'keterangan'); 
        } else {
            $query = DB::table('pemasukan');
        }

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_transaksi', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $data = $query->get();
        
        $pdf = PDF::loadView('exports.laporan-pdf', [
            'data' => $data,
            'jenis' => $jenis == '2' ? 'Pengeluaran' : 'Pemasukan',
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);

        return $pdf->download('laporan-keuangan.pdf');
    }
}