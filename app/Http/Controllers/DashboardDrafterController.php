<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Progres;
use Illuminate\Support\Facades\DB;

class DashboardDrafterController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get count of completed projects from progres table
        $completedProjects = DB::table('projects')
            ->join('progres', 'projects.id_proyek', '=', 'progres.id_proyek')
            ->where('projects.id_drafter', $userId)
            ->where('progres.status_progres', 'Selesai')
            ->distinct('projects.id_proyek')
            ->count();
            
        // Get count of ongoing projects from progres table
        $ongoingProjects = DB::table('projects')
            ->join('progres', 'projects.id_proyek', '=', 'progres.id_proyek')
            ->where('projects.id_drafter', $userId)
            ->where('progres.status_progres', 'Proses')
            ->distinct('projects.id_proyek')
            ->count();

        return view('dashboarddrafter', [
            'completedProjects' => $completedProjects,
            'ongoingProjects' => $ongoingProjects
        ]);
    }
}