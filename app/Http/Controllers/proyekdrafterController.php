<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class proyekdrafterController extends Controller
{
    public function proyekdrafter(Request $request)
    {
        // Get projects from database and filter by logged-in drafter
        $query = \App\Models\Project::query();
        $loggedInDrafterId = auth()->user()->id -1 ;
        // dd($loggedInDrafterId);
        $query->where('id_drafter', $loggedInDrafterId);

        // Filter based on search
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_proyek', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'id_proyek');
        $sortDirection = $request->query('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $projects = $query->paginate($perPage);
        // dd($projects);
        return view('tables.proyekdrafter', [
            'projects' => $projects,
            'total' => $projects->total(),
            'perPage' => $perPage,
            'currentPage' => $projects->currentPage(),
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }
    

}

