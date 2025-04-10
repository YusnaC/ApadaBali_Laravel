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
        // Get drafter ID based on logged-in user's name
        $loggedInUserName = Auth::user()->name;
        $drafter = DB::table('drafter')
            ->where('nama_drafter', $loggedInUserName)
            ->first();
        
        $drafterId = $drafter ? $drafter->id_drafter : '0';
        
        // Get count of completed projects from progres table
        $completedProjects = DB::table('projects')
            ->join('progres', 'projects.id_proyek', '=', 'progres.id_proyek')
            ->where('projects.id_drafter', $drafterId)
            ->where('progres.status_progres', 'Selesai')
            ->whereNull('progres.deleted_at')
            ->distinct('projects.id_proyek')
            ->count();
            
        // Get count of ongoing projects from progres table
        $ongoingProjects = DB::table('projects')
            ->select('projects.id_proyek')
            ->join('progres', 'projects.id_proyek', '=', 'progres.id_proyek')
            ->where('projects.id_drafter', $drafterId)
            ->whereNull('progres.deleted_at')
            ->where(function($query) {
                $query->where('progres.status_progres', 'Proses')
                      ->orWhere('progres.progres', '<', 100);
            })
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                      ->from('progres as p2')
                      ->whereRaw('progres.id_proyek = p2.id_proyek')
                      ->where('p2.status_progres', 'Selesai');
            })
            ->groupBy('projects.id_proyek')
            ->get()
            ->count();
            // ->distinct('projects.id_proyek')
            // ->count();
        // dd($completedProjects);
        return view('dashboarddrafter', [
            'completedProjects' => $completedProjects,
            'ongoingProjects' => $ongoingProjects
        ]);
    }
}