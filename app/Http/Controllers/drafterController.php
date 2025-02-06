<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class drafterController extends Controller
{
    public function drafter(Request $request)
    {
        // Ambil data dari API Dummy untuk proyek
        $project = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();

        // Mapping data proyek
        $mappedProjects = collect($project)->map(function ($projects, $drafter) use ($project) {
            // Pastikan kita mengambil data drafter dengan benar menggunakan modulus jika jumlah proyek lebih besar dari jumlah drafter
            $projects = $project[$drafter % count($project)];

            return [
                'id_drafter' => 'D' . str_pad($drafter + 1, 4, '0', STR_PAD_LEFT), // ID Klien
                'nama_drafter' => 'Klien ' . ($drafter + 1), // Nama Klien
                'alamat_drafter' => 'Jl. Tukad Pakerisan ' . ($drafter + 1), // Alamat Klien
                'no_whatsapp' => '081234567890', // Nomor WhatsApp
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
        $sortField = $request->query('sort', 'id_proyek');
        $sortDirection = $request->query('direction', 'asc');
        $mappedProjects = $mappedProjects->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc');

        // Pagination
        $perPage = $request->query('entries', 10);
        $currentPage = $request->query('page', 1);
        $pagedProjects = $mappedProjects->slice(($currentPage - 1) * $perPage, $perPage);
        $total = $mappedProjects->count();

        // Paginator
        $projectsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedProjects,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('tables.drafter', [
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
