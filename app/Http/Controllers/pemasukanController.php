<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class pemasukanController extends Controller
{
    public function pemasukan(Request $request)
    {
        // Ambil data dari API atau database, sesuaikan dengan kebutuhan
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
        
       // Mapping data agar sesuai dengan tabel yang diinginkan
        $mappedProjects = collect($projects)->map(function ($project, $pemasukan) {
            // Tentukan jenis order berdasarkan $pemasukan (even: 'Proyek Arsitektur', odd: 'Furniture')
            $jenisOrder = $pemasukan % 2 === 0 ? 'Proyek Arsitektur' : 'Furniture';
            
            // Tentukan prefix 'id_order' berdasarkan jenis order
            $idOrderPrefix = ($jenisOrder === 'Proyek Arsitektur') ? 'ASB' : 'AFB'; // Prefix 'ASB' untuk 'Proyek Arsitektur', 'AFB' untuk 'Furniture'
            
            return [
                'no' => $pemasukan + 1,  // Nomor urut
                'jenis_order' => $jenisOrder,  // Jenis order ('Proyek Arsitektur' atau 'Furniture')
                'id_order' => $idOrderPrefix . str_pad($pemasukan + 1, 4, '0', STR_PAD_LEFT),  // ID Order dengan prefix 'ASB' atau 'AFB'
                'tgl_transaksi' => now()->subDays($pemasukan)->format('d/m/Y'),  // Tanggal transaksi (dihitung mundur dari hari ini)
                'jumlah' => 100000,  // Jumlah acak (misalnya 1 juta)
                'termin' => rand(1, 3),  // Termin acak antara 1-3
                'keterangan' => 'Keterangan ' . ($pemasukan + 1),  // Keterangan order
            ];
        });


        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['jenis_order']), strtolower($search)) ||
                       str_contains(strtolower($project['id_order']), strtolower($search));
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

        return view('tables.pemasukanKeuangan', [
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
