<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class progresproyekController extends Controller
{
    public function progresproyek(Request $request)
    {
        // Ambil data dari API Dummy
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
    
        // Mapping data dummy agar sesuai dengan kebutuhan
        $mappedProjects = collect($projects)->map(function ($project, $progresproyek) {
            return [
                'id_proyek' => 'ASB' . str_pad($progresproyek + 1, 4, '0', STR_PAD_LEFT),
                'tgl_proyek' => now()->subDays($progresproyek)->format('d/m/Y'),
                'progres' => '70% ',
                'keterangan' => 'Sketsa Awal Desain',
                'dokumen' => 'Dokumen_TahapAwal_Proyek.zip',
            ];
        });
    
        // Filter berdasarkan pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['nama_progresproyek']), strtolower($search)) ||
                    str_contains(strtolower($project['kategori']), strtolower($search));
            });
        }
    
        // Sorting
        $sortField = $request->query('sort', 'id_progresproyek'); // Default sort by 'id_progresproyek'
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

        return view('tables.progresproyek', [
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

