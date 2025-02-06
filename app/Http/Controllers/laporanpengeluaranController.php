<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class laporanpengeluaranController extends Controller
{
    public function laporanpengeluaran(Request $request)
    {
        // Ambil data dari API atau database, sesuaikan dengan kebutuhan
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
        
          // Mapping data agar sesuai dengan tabel pengeluaran yang diinginkan
          $mappedProjects = collect($projects)->map(function ($project, $laporanpengeluaran) {
            // Anggap data yang didapatkan adalah data barang dan pengeluaran terkait
            $jumlah = rand(1, 5); // Angka acak untuk jumlah
            $hargaSatuan = rand(100000, 1000000); // Angka acak untuk harga satuan

            return [
                'no' => $laporanpengeluaran + 1,
                'tanggal_transaksi' => now()->subDays($laporanpengeluaran)->format('d/m/Y'), // Tanggal transaksi
                'nama_barang' => 'Barang ' . ($laporanpengeluaran + 1), // Nama barang
                'jumlah' => $jumlah,
                'harga_satuan' => 100000, 
                'total_harga' => 100000,
                'keterangan' => 'Keterangan ' . ($laporanpengeluaran + 1),
            ];
        });


        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['nama_barang']), strtolower($search)) ||
                       str_contains(strtolower($project['keterangan']), strtolower($search));
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'no');
        $sortDirection = $request->query('direction', 'asc');
        $mappedProjects = $mappedProjects->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc');

        // Pagination
        $perPage = $request->query('entries', 10);
        $currentPage = $request->query('page', 1);
        $pagedProjects = $mappedProjects->slice(($currentPage - 1) * $perPage, $perPage);
        $total = $mappedProjects->count();

        $projectsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedProjects,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('tables.laporanpengeluaran', [
            'projects' => $projectsPaginator,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }
}

