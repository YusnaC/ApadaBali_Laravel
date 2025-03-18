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

class proyekController extends Controller
{
    // public function proyek(Request $request)
    // {
    //     // Ambil data dari API Dummy
    //     $projects = Http::get('https://6753ad4cf3754fcea7bc363c.mockapi.io/api/v1/projects')->json();
    
    //     // Mapping data dummy agar sesuai dengan kebutuhan
    //     $mappedProjects = collect($projects)->map(function ($project, $proyek) {
    //         return [
    //             'id_proyek' => 'ASB' . str_pad($proyek + 1, 4, '0', STR_PAD_LEFT),
    //             'kategori' => $proyek % 2 === 0 ? 'Proyek Arsitektur' : 'Jasa',
    //             'tgl_proyek' => now()->subDays($proyek)->format('d/m/Y'),
    //             'nama_proyek' => 'Proyek ' . ($proyek + 1),
    //             'lokasi' => 'Jl. Tukad Pakerisan',
    //             'luas' => 500,
    //             'jumlah_lantai' => 3,
    //             'tgl_deadline' => now()->addDays(30)->format('d/m/Y'),
    //             'id_drafter' => 'D000' . ($proyek + 1),
    //         ];
    //     });
    
    //     // Filter berdasarkan pencarian
    //     $search = $request->query('search');
    //     if ($search) {
    //         $mappedProjects = $mappedProjects->filter(function ($project) use ($search) {
    //             return str_contains(strtolower($project['nama_proyek']), strtolower($search)) ||
    //                 str_contains(strtolower($project['kategori']), strtolower($search));
    //         });
    //     }
    
    //     // Sorting
    //     $sortField = $request->query('sort', 'id_proyek'); // Default sort by 'id_proyek'
    //     $sortDirection = $request->query('direction', 'asc'); // Default direction 'asc'
    
    //     $mappedProjects = $mappedProjects->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc');
    
    //     // Pagination
    //     $perPage = $request->query('entries', 10); // Ambil nilai 'entries' dari query string
    //     $currentPage = $request->query('page', 1);
    //     $pagedProjects = $mappedProjects->slice(($currentPage - 1) * $perPage, $perPage);
    //     $total = $mappedProjects->count();

    //     // Manually create a paginator object
    //     $projectsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
    //         $pagedProjects, 
    //         $total, 
    //         $perPage, 
    //         $currentPage, 
    //         ['path' => $request->url(), 'query' => $request->query()]
    //     );

    //     return view('tables.proyek', [
    //         'projects' => $projectsPaginator,
    //         'total' => $total,
    //         'perPage' => $perPage,
    //         'currentPage' => $currentPage,
    //         'search' => $search,
    //         'sortField' => $sortField,
    //         'sortDirection' => $sortDirection,
    //     ]);
    // }

    public function proyek(Request $request)
{
    // Inisialisasi Query Eloquent
    $query = Project::query();

    // 🔍 Filter berdasarkan pencarian
    $search = $request->query('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_proyek', 'like', "%$search%")
              ->orWhere('kategori', 'like', "%$search%");
        });
    }

    // 🔄 Sorting
    $sortField = $request->query('sort', 'id_proyek');
    $sortDirection = $request->query('direction', 'asc');
    if (in_array($sortDirection, ['asc', 'desc'])) { 
        $query->orderBy($sortField, $sortDirection);
    }

    // 📌 Paginasi
    $perPage = $request->query('entries', 10);
    $projects = $query->paginate($perPage);

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
        $lastProject = Project::orderByRaw("CAST(SUBSTRING(id_proyek, 4) AS UNSIGNED) DESC")->first();

        if (!$lastProject) {
            $newId = 'ASB001';
        } else {
            // Ambil angka dari ID terakhir, tambahkan 1, lalu format ulang
            $lastNumber = intval(substr($lastProject->id_proyek, 3));
            $newId = 'ASB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }
        $proyek = null;
        return view('proyek', compact('newId'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input
        // $request->validate([
        //     'id_proyek' => 'required|string|unique:projects,id_proyek',
        //     'kategori' => 'required|string',
        //     'tgl_proyek' => 'required|date',
        //     'nama_proyek' => 'required|string|max:255',
        //     'lokasi' => 'required|string|max:255',
        //     'luas' => 'required|numeric|min:1',
        //     'jumlah_lantai' => 'required|integer|min:1',
        //     'tgl_deadline' => 'required|date|after_or_equal:tgl_proyek',
        //     'id_drafter' => 'required|string|max:10',
        // ]);

        $lastProject = Project::latest('id_proyek')->first();

            // Jika tidak ada data, mulai dari ASB001
            if (!$lastProject) {
                $newId = 'ASB001';
            } else {
                // Ambil angka dari ID terakhir, tambahkan 1, lalu format ulang
                $lastNumber = intval(substr($lastProject->id_proyek, 3));
                $newId = 'ASB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }
        // Simpan data ke database
        Project::create([
            'id_proyek' => $request->id_proyek,
            'kategori' => $request->kategori,
            'tgl_proyek' => $request->tgl_proyek,
            'nama_proyek' => $request->nama_proyek,
            'lokasi' => $request->lokasi,
            'luas' => $request->luas,
            'jumlah_lantai' => $request->jumlah_lantai,
            'tgl_deadline' => $request->tgl_deadline,
            'id_drafter' => $request->id_drafter,
        ]);

        // return view('proyek', compact('newId'));
        return redirect()->route('tables.proyek')->with('success', 'Proyek berhasil dibuat.');
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
        return view('proyek', compact('proyek'));
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
        $query = Progres::select('progres.*')
            ->join(DB::raw('(SELECT id_proyek, MAX(tgl_progres) as max_tgl FROM progres GROUP BY id_proyek) as latest'), function ($join) {
                $join->on('progres.id_proyek', '=', 'latest.id_proyek')
                     ->on('progres.tgl_progres', '=', 'latest.max_tgl');
            });
    
        // Search functionality
        if ($request->has('search')) {
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
    
        return view('progressproyek', [
            'projects' => $projects,
            'total' => $projects->total(),
            'perPage' => $perPage,
            'currentPage' => $projects->currentPage(),
            'search' => $request->search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection
        ]);
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
}

