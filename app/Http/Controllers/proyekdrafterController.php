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
        // Get drafter ID based on logged-in user's name
        $loggedInUserName = auth()->user()->name;
        $drafter = \App\Models\Drafter::where('nama_drafter', $loggedInUserName)->first();
        
        // Initialize project query with drafter's ID
        $query = \App\Models\Project::query();
        if ($drafter) {
            $query->where('id_drafter', $drafter->id_drafter);
        } else {
            $query->where('id_drafter', '0'); // Return no results if drafter not found
        }
        
        // Filter based on search
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_proyek', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('luas', 'like', "%{$search}%")
                  ->orWhere('jumlah_lantai', 'like', "%{$search}%")
                  ->orWhere('tgl_proyek', 'like', "%{$search}%")
                  ->orWhere('tgl_deadline', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'created_at');
        $sortDirection = $request->query('direction', 'desc');
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

