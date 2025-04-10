<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Carbon\Carbon;

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
    
        // Remove duplicate orderBy and handle 'no' column properly
        if ($sortField === 'no') {
            $query->orderBy('id', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }
    
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
        $reportType = $request->input('reportType', 'pemasukan');
        $exportType = $request->input('type', 'pdf');
        $preview = $request->input('preview', false);
        
        if ($reportType === 'pengeluaran') {
            $query = DB::table('pengeluaran')
                ->select(
                    'id', 
                    'tanggal_transaksi', 
                    'nama_barang', 
                    'jumlah',
                    'harga_satuan',
                    'total_harga', 
                    'keterangan'
                )
                ->whereNull('deleted_at')
                ->orderBy('tanggal_transaksi', 'asc');
            $dateField = 'tanggal_transaksi';
        } else {
            $query = DB::table('pemasukan')
                ->select(
                    'id',
                    'tgl_transaksi',
                    'jenis_order',
                    'id_order',
                    'jumlah',
                    'termin',
                    'keterangan'
                )
                ->whereNull('deleted_at')
                ->orderBy('tgl_transaksi', 'asc');
            $dateField = 'tgl_transaksi';
        }
    
        if ($request->filled(['tgl_awal', 'tgl_akhir'])) {
            $startDate = Carbon::parse($request->tgl_awal)->startOfDay();
            $endDate = Carbon::parse($request->tgl_akhir)->endOfDay();
            $query->whereBetween($dateField, [$startDate, $endDate]);
        }
    
        $data = $query->get();

        if ($exportType === 'pdf') {
            $pdf = PDF::loadView('exports.laporan-pdf', [
                'data' => $data,
                'reportType' => $reportType,
                'tgl_awal' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir
            ]);
            $pdf->setPaper('A4', 'landscape');
            
            if ($preview) {
                return $pdf->stream("laporan-{$reportType}.pdf");
            }
            return $pdf->download("laporan-{$reportType}.pdf");
        }
        
        // Modify data structure for Excel export
        if ($reportType === 'pemasukan') {
            $data = collect($data)->values()->map(function ($item, $index) {
                return (object) [
                    'no' => $index + 1,
                    'id' => $item->id,
                    'tgl_transaksi' => $item->tgl_transaksi,
                    'jenis_order' => $item->jenis_order,
                    'id_order' => $item->id_order,
                    'jumlah' => $item->jumlah,
                    'termin' => $item->termin,
                    'keterangan' => $item->keterangan
                ];
            });
        }
        
        return Excel::download(new LaporanExport($data, $reportType), "laporan-{$reportType}.xlsx");
    }
   
}
