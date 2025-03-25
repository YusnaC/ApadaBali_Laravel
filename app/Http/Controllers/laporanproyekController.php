<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Furniture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class laporanproyekController extends Controller
{
    public function laporanproyek(Request $request)
    {
        $jenis = $request->query('jenis', '1');
        
        if ($jenis == '1') {
            $query = Project::query();
            $dateField = 'tgl_proyek';
        } else {
            $query = Furniture::query();
            $dateField = 'tgl_pembuatan';  // Changed from tgl_furniture to tgl_pembuatan
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
            $query->where(function($q) use ($search, $jenis) {
                if ($jenis == '1') {
                    $q->where('nama_proyek', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
                } else {
                    $q->where('nama_furniture', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");  // Changed jenis_furniture to lokasi
                }
            });
        }

        // Update the date field in the transformation
        // Sorting
        $sortField = $request->query('sort', $jenis == '1' ? 'id_proyek' : 'id_furniture');
        $sortDirection = $request->query('direction', 'asc');
        
        // Adjust sort field for furniture
        if ($jenis == '2') {
            $sortField = str_replace('_proyek', '_furniture', $sortField);
            $sortField = str_replace('tgl_laporanproyek', 'tgl_pembuatan', $sortField);
            $sortField = str_replace('nama_laporanproyek', 'nama_furniture', $sortField);
        }
        
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $items = $query->paginate($perPage);

        // Transform the data
        $projects = $items->through(function ($item) use ($jenis) {
            if ($jenis == '1') {
                return [
                    'id_proyek' => $item->id_proyek,
                    'kategori' => 'Proyek Arsitektur',
                    'tgl_proyek' => $item->tgl_proyek ? date('d/m/Y', strtotime($item->tgl_proyek)) : '',
                    'nama_proyek' => $item->nama_proyek,
                    'lokasi' => $item->lokasi,
                    'luas' => $item->luas,
                    'jumlah_lantai' => $item->jumlah_lantai,
                    'tgl_deadline' => $item->tgl_deadline ? date('d/m/Y', strtotime($item->tgl_deadline)) : '',
                    'id_drafter' => $item->id_drafter,
                ];
            } else {
                return [
                    'id_proyek' => $item->id_furniture,
                    'kategori' => 'Furniture',
                    'tgl_proyek' => $item->tgl_pembuatan ? date('d/m/Y', strtotime($item->tgl_pembuatan)) : '',
                    'nama_proyek' => $item->nama_furniture,
                    'lokasi' => $item->lokasi,
                    'luas' => $item->luas ?? '-',
                    'jumlah' => $item->jumlah_unit,
                    'harga' => $item->harga_unit,
                    'jumlah_lantai' => $item->jumlah_lantai ?? '-',
                    'tgl_deadline' => $item->tgl_selesai ? date('d/m/Y', strtotime($item->tgl_selesai)) : '',
                    'id_drafter' => $item->id_drafter ?? '-',
                ];
            }
        });
        // dd($projects);
        return view('tables.laporanproyek', [
            'projects' => $projects,
            'total' => $items->total(),
            'perPage' => $perPage,
            'currentPage' => $items->currentPage(),
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'selectedJenis' => $jenis
        ]);
    }

    public function exportPDF(Request $request)
    {
        $jenis = $request->input('jenis', '1');
        
        if ($jenis == '2') {
            $query = DB::table('furnitures');
        } else {
            $query = DB::table('projects');
        }

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_proyek', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $data = $query->get();
        
        $pdf = PDF::loadView('exports.lapocts-proyek-pdf', [
            'data' => $data,
            'jenis' => $jenis == '2' ? 'Furniture' : 'Proyek',
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);

        return $pdf->download('laporan-proyek.pdf');
    }
}
