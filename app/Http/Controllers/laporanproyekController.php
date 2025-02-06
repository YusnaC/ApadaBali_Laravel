<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class laporanproyekController extends Controller
{
    public function laporanproyek(Request $request)
    {
        // Ambil data dari API Dummy
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
    
        // Mapping data dummy agar sesuai dengan kebutuhan
        $mappedProjects = collect($projects)->map(function ($project, $laporanproyek) {
            return [
                'id_proyek' => 'ASB' . str_pad($laporanproyek + 1, 4, '0', STR_PAD_LEFT),
                'kategori' => $laporanproyek % 2 === 0 ? 'Proyek Arsitektur' : 'Furniture',
                'tgl_proyek' => now()->subDays($laporanproyek)->format('d/m/Y'),
                'nama_proyek' => 'Proyek ' . ($laporanproyek + 1),
                'lokasi' => 'Jl. Tukad Pakerisan',
                'luas' => 500,
                'jumlah_lantai' => 3,
                'tgl_deadline' => now()->addDays(30)->format('d/m/Y'),
                'id_drafter' => 'D000' . ($laporanproyek + 1),
            ];
        });
    
        // Filter berdasarkan pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['nama_proyek']), strtolower($search)) ||
                    str_contains(strtolower($project['kategori']), strtolower($search));
            });
        }
    
        // Sorting
        $sortField = $request->query('sort', 'id_proyek'); // Default sort by 'id_laporanproyek'
        $sortDirection = $request->query('direction', 'asc'); // Default direction 'asc'
    
        $mappedProjects = $mappedProjects->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc');
    
        // Pagination
        $perPage = $request->query('entries', 10); // Ambil nilai 'entries' dari query string
        $currentPage = $request->query('page', 1);
        $pagedProjects = $mappedProjects->slice(($currentPage - 1) * $perPage, $perPage);
        $total = $mappedProjects->count();

        // Manually create a paginator object
        $projectsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedProjects, 
            $total, 
            $perPage, 
            $currentPage, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('tables.laporanproyek', [
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

