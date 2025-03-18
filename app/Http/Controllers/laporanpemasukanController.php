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
    $jenis = $request->input('jenis');

    if ($jenis == '2') {
        $query = DB::table('pengeluarans')
            ->select('id', 'tanggal_transaksi AS tgl_transaksi', 'nama_barang AS jenis_order', DB::raw("NULL AS id_order"), 'jumlah', DB::raw("NULL AS termin"), 'keterangan'); 
    } else {
        $query = DB::table('pemasukan')
            ->select('id', 'tgl_transaksi', 'jenis_order', 'id_order', 'jumlah', 'termin', 'keterangan');
    }

    // Filter berdasarkan tanggal (gunakan alias `tgl_transaksi`)
    if ($request->filled(['tgl_awal', 'tgl_akhir'])) {
        $query->whereBetween('tgl_transaksi', [$request->tgl_awal, $request->tgl_akhir]);
    }

    // Inisialisasi $sortField dan $sortDirection
    $sortField = 'tgl_transaksi'; // Default kolom yang digunakan untuk sorting
    $sortDirection = $request->query('direction', 'desc');

    // Pastikan sorting menggunakan `tgl_transaksi`
    $query->orderBy($sortField, $sortDirection);

    // Pagination
    $perPage = $request->query('entries', 10);
    $projects = $query->paginate($perPage);

    return view('tables.laporanPemasukan', [
        'projects' => $projects,
        'total' => $projects->total(),
        'perPage' => $perPage,
        'currentPage' => $projects->currentPage(),
        'sortField' => $sortField,
        'sortDirection' => $sortDirection,
        'selectedJenis' => $jenis
    ]);
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