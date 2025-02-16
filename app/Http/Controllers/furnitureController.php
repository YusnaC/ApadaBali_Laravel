<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class furnitureController extends Controller
{
    public function furniture(Request $request)
    {
        // Ambil data dari API Dummy
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
    
        // Mapping data dummy agar sesuai dengan kebutuhan
        $mappedProjects = collect($projects)->map(function ($project, $furniture) {
            return [
                'id_furniture' => 'AFB' . str_pad($furniture + 1, 4, '0', STR_PAD_LEFT),
                'tgl_pembuatan' => now()->subDays($furniture)->format('d/m/Y'),          
                'nama_furniture' => 'Furniture ' . ($furniture + 1),
                'jumlah_unit' => 3,
                'harga_unit' => 1000000,
                'lokasi' => 'Jl. Tukad Pakerisan',
                'tgl_selesai' => now()->addDays(30)->format('d/m/Y'),
            ];
        });
    
        // Filter berdasarkan pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['nama_furniture']), strtolower($search)) ||
                    str_contains(strtolower($project['jumlah_unit']), strtolower($search));
            });
        }
    
        // Sorting
        $sortField = $request->query('sort', 'id_furniture'); // Default sort by 'id_proyek'
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

        return view('tables.furniture', [
            'projects' => $projectsPaginator,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function create()
    {
        return view('furniture');
    }
    

    public function store($request){
        
    }

}

