<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Progres;
use App\Models\Drafter;
use App\Events\ProjectCreated; // Add this import
use App\Jobs\SendProjectNotification; // Add this import

class proyekController extends Controller
{
    public function proyek(Request $request)
{
    // 🔹 Inisialisasi Query dengan Relasi Drafter
    $query = Project::with('drafter');

    // 🔍 Filter berdasarkan pencarian
    $search = $request->query('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_proyek', 'like', "%$search%")
              ->orWhere('kategori', 'like', "%$search%");
        });
    }

    // 🔄 Sorting dengan Validasi
    $allowedSortFields = ['id_proyek', 'nama_proyek', 'kategori', 'created_at'];
    $sortField = $request->query('sort', 'id_proyek');
    if (!in_array($sortField, $allowedSortFields)) {
        $sortField = 'id_proyek';
    }

    $sortDirection = $request->query('direction', 'asc');
    $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'asc';

    $query->orderBy($sortField, $sortDirection);

    // 📌 Paginasi dengan Validasi
    $perPage = filter_var($request->query('entries', 10), FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) ?: 10;
    $projects = $query->paginate($perPage);

    // 🔄 Return ke View
    return view('tables.proyek', [
        'projects' => $projects,
        'total' => $projects->total(),
        'perPage' => $perPage,
        'currentPage' => $projects->currentPage(),
        'search' => $search,
        'sortField' => $sortField,
        'sortDirection' => $sortDirection,
    ]);
}


    public function create()
    {
        $kategori = $request->kategori ?? 1; // Default ke kategori 1 (Proyek Arsitektur)

        // Tentukan prefix berdasarkan kategori
        $prefix = ($kategori == 2) ? 'AJB' : 'ASB';

        // Cari ID terakhir berdasarkan kategori
        $lastProject = Project::where('id_proyek', 'LIKE', "{$prefix}%")
            ->orderByRaw("CAST(SUBSTRING(id_proyek, 4) AS UNSIGNED) DESC")
            ->first();

        // Tentukan ID baru berdasarkan kategori
        if (!$lastProject) {
            $newId = $prefix . '001';
        } else {
            $lastNumber = intval(substr($lastProject->id_proyek, 3));
            $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        // Ambil daftar drafters
        $drafters = Drafter::all();

        return view('proyek', compact('newId', 'drafters', 'kategori'));
    }

    public function store(Request $request)
    {
        try {
            $project = Project::create([
                'id_proyek' => $request->id_proyek,
                'kategori' => $request->kategori,
                'tgl_proyek' => $request->tgl_proyek,
                'nama_proyek' => $request->nama_proyek,
                'lokasi' => $request->lokasi,
                'luas' => $request->luas,
                'jumlah_lantai' => $request->jumlah_lantai,
                'tgl_deadline' => $request->tgl_deadline,
                'id_drafter' => $request->kategori == 2 ? '0' : $request->id_drafter,
            ]);

            // Dispatch notification with project data
            SendProjectNotification::dispatch($project)->afterResponse();

            return redirect()->route('tables.proyek')
                           ->with('success', 'Proyek berhasil dibuat.');

        } catch (\Exception $e) {
            \Log::error('Project creation error: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Gagal membuat proyek: ' . $e->getMessage());
        }
    }

    public function destroy($id_proyek)
    {
        // Cari proyek berdasarkan ID
        $proyek = Project::where('id_proyek', $id_proyek)->first();
    
        if (!$proyek) {
            return redirect()->back()->with('error', 'Proyek tidak ditemukan!');
        }
    
        // Hapus proyek
        $proyek->delete();
    
        return redirect()->route('tables.proyek')->with('success', 'Proyek berhasil dihapus!');
    }

    public function edit($id)
    {
        $proyek = Project::findOrFail($id);
        $drafters = Drafter::all();
        return view('proyek', compact('proyek', 'drafters'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'tgl_proyek' => 'required|date',
            'nama_proyek' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'luas' => 'required|numeric',
            'jumlah_lantai' => 'required|integer',
            'tgl_deadline' => 'required|date',
            'id_drafter' => 'required|integer',
        ]);

        $proyek = Project::findOrFail($id);
        $proyek->update($request->all());

        return redirect()->route('tables.proyek')->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function progress(Request $request){
        $project = Project::findOneOrFail($projectId);
        return $project->progress_percentage;
    }

    public function progressProyek(Request $request)
    {
        try {
            $query = Progres::select('progres.*')
                ->join(DB::raw('(SELECT id_proyek, MAX(tgl_progres) as max_tgl FROM progres GROUP BY id_proyek) as latest'), function ($join) {
                    $join->on('progres.id_proyek', '=', 'latest.id_proyek')
                         ->on('progres.tgl_progres', '=', 'latest.max_tgl');
                });
    
            // Search functionality
            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where('progres.id_proyek', 'LIKE', "%{$search}%");
            }
    
            // Sorting
            $sortField = $request->get('sort', 'id_proyek');
            $sortDirection = $request->get('direction', 'asc');
            $query->orderBy($sortField, $sortDirection);
    
            // Pagination
            $perPage = $request->get('entries', 10);
            $projects = $query->paginate($perPage);
    
            if ($request->ajax()) {
                return view('progressproyek', compact('projects'))->render();
            }
    
            return view('progressproyek', [
                'projects' => $projects,
                'total' => $projects->total(),
                'perPage' => $perPage,
                'currentPage' => $projects->currentPage(),
                'search' => $request->search,
                'sortField' => $sortField,
                'sortDirection' => $sortDirection
            ]);
        } catch (\Exception $e) {
            \Log::error('Progress search error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Search failed'], 500);
            }
            return back()->with('error', 'An error occurred while searching.');
        }
    }
    
    public function show($id)
    {
        $project = DB::table('progres')
            ->where('id_proyek', $id)
            ->first();
    
        if (!$project) {
            return redirect()->route('proyek.progress')
                ->with('error', 'Project not found');
        }
    
        return view('detailproyek', compact('project'));
    }

    public function getLatestProjectId(Request $request)
{
    $prefix = $request->query('prefix', 'ASB'); // Default ASB jika tidak ada parameter

    // Cari ID proyek terakhir yang memiliki prefix sesuai kategori
    $lastProject = Project::where('id_proyek', 'LIKE', "{$prefix}%")
        ->orderByRaw("CAST(SUBSTRING(id_proyek, 4) AS UNSIGNED) DESC")
        ->first();

    // Tentukan ID proyek baru
    if (!$lastProject) {
        $newId = $prefix . '001';
    } else {
        $lastNumber = intval(substr($lastProject->id_proyek, 3));
        $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    return response()->json([
        'success' => true,
        'new_id' => $newId
    ]);
}
}

