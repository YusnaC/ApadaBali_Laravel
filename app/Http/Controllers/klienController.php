<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class klienController extends Controller
{
    public function klien(Request $request)
    {
        // Ambil data dari API Dummy
        $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();

       // Mapping data dummy agar sesuai dengan kebutuhan (menyesuaikan dengan kolom yang disebutkan)
        $mappedProjects = collect($projects)->map(function ($project, $klien) {
            // Menentukan prefix ID Order sesuai dengan jenis order
            $prefixOrder = $klien % 2 === 0 ? 'ASB' : 'AFB'; // ASB untuk Arsitektur, AFB untuk Furniture
            
            return [
                'id_klien' => 'K' . str_pad($klien + 1, 4, '0', STR_PAD_LEFT), // ID Klien
                'jenis_order' => $klien % 2 === 0 ? 'Proyek Arsitektur' : 'Furniture', // Jenis Order
                'id_order' => $prefixOrder . str_pad($klien + 1, 4, '0', STR_PAD_LEFT), // ID Order (prefix ASB/AFB)
                'nama_klien' => 'Klien ' . ($klien + 1), // Nama Klien
                'alamat_klien' => 'Jl. Tukad Pakerisan ' . ($klien + 1), // Alamat Klien
                'no_whatsapp' => '081234567890', // Nomor WhatsApp
            ];
        });

        // Filter berdasarkan pencarian
        $search = $request->query('search');
        if ($search) {
            $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
                return str_contains(strtolower($project['nama_klien']), strtolower($search)) ||
                       str_contains(strtolower($project['jenis_order']), strtolower($search)) ||
                       str_contains(strtolower($project['alamat_klien']), strtolower($search)) ||
                       str_contains(strtolower($project['no_whatsapp']), strtolower($search));
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'id_klien'); // Default sort by 'id_klien'
        $sortDirection = $request->query('direction', 'asc'); // Default direction 'asc'
    
        $mappedProjects = $mappedProjects->sortBy(function ($project) use ($sortField) {
            return $project[$sortField];
        }, SORT_REGULAR, $sortDirection === 'desc');
    
        // Pagination
        $perPage = $request->query('entries', 10); // Ambil nilai 'entries' dari query string
        $currentPage = $request->query('page', 1);
        $pagedProjects = $mappedProjects->slice(($currentPage - 1) * $perPage, $perPage);
        $total = $mappedProjects->count();

        // Manually create a paginator object
        $projectsPaginator = new LengthAwarePaginator(
            $pagedProjects, 
            $total, 
            $perPage, 
            $currentPage, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('tables.klien', [
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
