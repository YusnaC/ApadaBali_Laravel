<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyek;
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
        $completedProjects = DB::table('proyek')
            ->join('progres', 'proyek.id_proyek', '=', 'progres.id_proyek')
            ->where('proyek.id_drafter', $drafterId)
            ->where('progres.status_progres', 'Selesai')
            ->whereNull('progres.deleted_at')
            ->distinct('proyek.id_proyek')
            ->count();
            
        // Get count of ongoing projects from progres table
        $ongoingProjects = DB::table('proyek')
            ->select('proyek.id_proyek')
            ->join('progres', 'proyek.id_proyek', '=', 'progres.id_proyek')
            ->where('proyek.id_drafter', $drafterId)
            ->whereNull('progres.deleted_at')
            ->where(function($query) {
                $query->where('progres.status_progres', 'Proses')
                      ->whereNull('progres.deleted_at')
                      ->orWhere('progres.progres', '<', 100);
            })
            ->whereNotExists(function($query) use ($drafterId) {
                $query->select(DB::raw(1))
                      ->from('progres as p2')
                      ->join('proyek as p3', 'p2.id_proyek', '=', 'p3.id_proyek')
                      ->whereRaw('proyek.id_proyek = p2.id_proyek')
                      ->where('p2.status_progres', 'Selesai')
                      ->where('p3.id_drafter', $drafterId)
                      ->whereNull('p2.deleted_at');
            })
            ->groupBy('proyek.id_proyek')
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