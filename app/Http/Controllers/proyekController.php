<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Proyek;
use Illuminate\Support\Facades\DB;
use App\Models\Progres;
use App\Models\Drafter;
use App\Events\ProjectCreated; // Add this import
use App\Jobs\SendProjectNotification; // Add this import
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
class proyekController extends Controller
{
    public function proyek(Request $request)
{
    // Initialize query with join
    $query = Proyek::query();

    // Handle search
    $search = $request->query('search');
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nama_proyek', 'like', "%{$search}%")
              ->orWhere('lokasi', 'like', "%{$search}%")
              ->orWhere('id_drafter', 'like', "%{$search}%")
              ->orWhere(function($query) use ($search) {
                  if (strtolower($search) === 'jasa') {
                      $query->where('kategori', '2');
                  } elseif (strtolower($search) === 'proyek arsitektur' || 
                           strtolower($search) === 'proyek' || 
                           strtolower($search) === 'arsitektur') {
                      $query->where('kategori', '1');
                  } else {
                      $query->where('kategori', 'like', "%{$search}%");
                  }
              })
              ->orWhere('luas', 'like', "%{$search}%")
              ->orWhere('jumlah_lantai', 'like', "%{$search}%")
              ->orWhere('tgl_proyek', 'like', "%{$search}%")
              ->orWhere('tgl_deadline', 'like', "%{$search}%")
              ->orWhereHas('drafter', function($query) use ($search) {
                  $query->where('id_drafter', 'like', "%{$search}%");
              });
        });
    }

    // Handle sorting
    $sortField = $request->query('sort', 'created_at');
    $sortDirection = $request->query('direction', 'desc');

    // Apply sorting
    if ($sortField && $sortField !== 'aksi') {  // Skip sorting for 'aksi' column
        $query->orderBy($sortField, $sortDirection);
    }

    // Pagination
    $perPage = $request->query('entries', 10);
    $projects = $query->paginate($perPage);
    // dd($projects);
    return view('tables.proyek', [
        'projects' => $projects,
        'search' => $search,
        'sortField' => $sortField,
        'sortDirection' => $sortDirection,
        'perPage' => $perPage,
        'total' => $projects->total(),
        'currentPage' => $projects->currentPage()
    ]);
}


public function create(Request $request)
{
    $kategori = $request->kategori ?? 1;

    // Tentukan prefix berdasarkan kategori
    $prefix = ($kategori == 2) ? 'AJB' : 'ASB';

    // Get the last project ID including soft deleted records
    $lastProject = Proyek::withTrashed()
        ->where('id_proyek', 'LIKE', "{$prefix}%")
        ->orderByRaw("CAST(SUBSTRING(id_proyek, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
        ->first();

    // Generate new ID by incrementing the last number
    if (!$lastProject) {
        $newId = $prefix . '0001';
    } else {
        // Ambil angka setelah prefix
        $lastNumber = (int) substr($lastProject->id_proyek, strlen($prefix));
        $newNumber = $lastNumber + 1;
        $newId = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    $drafters = Drafter::all();

    return view('proyek', compact('newId', 'drafters', 'kategori'));
}


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_proyek' => 'required|string|unique:proyek,id_proyek',
                'nama_proyek' => 'required|string|max:255',
                'kategori' => 'required|integer',
                'tgl_proyek' => 'required|date',
                'lokasi' => 'required|string|max:255',
                'luas' => 'required|numeric|min:0',
                'jumlah_lantai' => 'required|integer|min:1',
                'tgl_deadline' => 'required|date|after:tgl_proyek',
                'id_drafter' => $request->kategori == 1 ? 'required' : 'nullable',
            ]);

            $project = Proyek::create([
                'id_proyek' => $request->id_proyek,
                'kategori' => $request->kategori,
                'tgl_proyek' => $request->tgl_proyek,
                'nama_proyek' => $request->nama_proyek,
                'lokasi' => $request->lokasi,
                'luas' => $request->luas,
                'jumlah_lantai' => $request->jumlah_lantai,
                'tgl_deadline' => $request->tgl_deadline,
                'id_drafter' => $request->kategori == 1 ? $request->id_drafter : ($request->id_drafter ?? '0'),
            ]);

            try {
                // Direct notification sending instead of using queue
                $factory = (new \Kreait\Firebase\Factory)
                    ->withServiceAccount(storage_path('app/firebase/apadabali-7d57a-firebase-adminsdk-fbsvc-9efa655d53.json'));
                
                $messaging = $factory->createMessaging();
                
                $notification = \Kreait\Firebase\Messaging\Notification::create()
                    ->withTitle('Proyek Baru')
                    ->withBody('Proyek ' . $project->nama_proyek . ' telah dibuat untuk ' . $project->id_drafter);

                $message = \Kreait\Firebase\Messaging\CloudMessage::new()
                    ->withNotification($notification)
                    ->withData([
                        'project_id' => $project->id_proyek,
                        'drafter_id' => $project->id_drafter,
                        'type' => 'new_project'
                    ]);

                // Get tokens based on user role
                if ($project->id_drafter && $project->id_drafter !== '0') {
                    // Get token for specific drafter
                    \Log::info('Looking for drafter with id_drafter: ' . $project->id_drafter);
                    
                    $drafter = \DB::table('drafter')
                        ->where('id_drafter', $project->id_drafter)
                        ->first();
                        
                    \Log::info('Found drafter: ' . json_encode($drafter));
                    
                    if ($drafter) {
                        $drafterId = $drafter->id;
                        \Log::info('Drafter ID from table: ' . $drafterId);
                        
                        $tokens = \DB::table('device_tokens')
                        ->where('user_id', $drafter->id + 1)
                        ->where('fcm_token', '!=', '')
                        ->whereNotNull('fcm_token')
                        ->whereNotNull('device_id')
                        ->where('device_type', '!=', '')
                        ->select('fcm_token', 'device_id', 'device_type')
                        ->get()
                        ->pluck('fcm_token')
                        ->unique()
                        ->values()
                        ->toArray();
                            
                        \Log::info('Drafter ID: ' . $project->id_drafter);
                        \Log::info('User ID: ' . $drafter->id + 1);
                        \Log::info('Found tokens: ' . json_encode($tokens));
                    }
                } else {
                    // Get all admin tokens if no drafter assigned
                    $tokens = \DB::table('users')
                        ->whereNotNull('fcm_token')
                        ->pluck('fcm_token')
                        ->toArray();
                }

                if (!empty($tokens)) {
                    try {
                        $response = $messaging->sendMulticast($message, $tokens);
                        
                        // Check if messages were sent successfully
                        if ($response->successes()->count() > 0) {
                            \Log::info('FCM notification sent successfully to ' . $response->successes()->count() . ' devices');
                        }
                        
                        // Check if there were any failures
                        if ($response->failures()->count() > 0) {
                            foreach ($response->failures()->getItems() as $failure) {
                                \Log::error('FCM notification failed: ' . $failure->error()->getMessage());
                            }
                        }
                    } catch (\Exception $e) {
                        \Log::error('Failed to send FCM notification: ' . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Firebase notification failed: ' . $e->getMessage());
            }

            return redirect()->route('tables.proyek')
                           ->with('success', 'Proyek berhasil dibuat.');

        } catch (\Exception $e) {
            \Log::error('Project creation error: ' . $e->getMessage());
            // dd($e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal membuat proyek: ' . $e->getMessage());
        }
    }

    public function destroy($id_proyek)
    {
        try {
            DB::beginTransaction();
            
            // Find the project
            $proyek = Proyek::where('id_proyek', $id_proyek)->first();
            
            if (!$proyek) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Proyek tidak ditemukan!');
            }
            
            // Soft delete the project and its progress
            Progres::where('id_proyek', $id_proyek)->delete();
            $proyek->delete();
            
            DB::commit();
            return redirect()->route('tables.proyek')->with('success', 'Proyek berhasil dihapus!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Project deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus proyek: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        $drafters = Drafter::all();
        $newId = null;
        // dd($drafters);
        return view('proyek', compact('proyek', 'drafters', 'newId'));
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
            'id_drafter' => 'required',
        ]);
        // dd($request->all());
        $proyek = Proyek::findOrFail($id);
        $proyek->update($request->all());

        return redirect()->route('tables.proyek')->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function progress(Request $request){
        $project = Proyek::findOneOrFail($projectId);
        return $project->progress_percentage;
    }

    public function progressProyek(Request $request)
    {
        try {
            $query = Progres::select(
                'progres.id_proyek',
                'proyek.nama_proyek',
                DB::raw('MAX(progres.tgl_progres) as tgl_progres'),
                DB::raw('MAX(progres.status_progres) as status_progres'),
                DB::raw('MAX(progres.progres) as progres')
            )
                ->join('proyek', 'proyek.id_proyek', '=', 'progres.id_proyek')
                ->whereNull('progres.deleted_at')
                ->whereNull('proyek.deleted_at')
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('progres as p2')
                        ->whereRaw('progres.id_proyek = p2.id_proyek')
                        ->whereRaw('progres.tgl_progres = p2.tgl_progres')
                        ->whereNull('p2.deleted_at');
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('progres as p3')
                        ->whereRaw('progres.id_proyek = p3.id_proyek')
                        ->whereRaw('progres.tgl_progres < p3.tgl_progres')
                        ->whereNull('p3.deleted_at');
                })
                ->groupBy('progres.id_proyek', 'proyek.nama_proyek');

            // Search functionality
            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('progres.id_proyek', 'LIKE', "%{$search}%")
                      ->orWhere('progres.status_progres', 'LIKE', "%{$search}%");
                    
                    $progressSearch = str_replace('%', '', $search);
                    if (is_numeric($progressSearch)) {
                        $q->orWhere('progres.progres', $progressSearch);
                    }
                });
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
    $lastProject = Proyek::withTrashed()
        ->where('id_proyek', 'LIKE', "{$prefix}%")
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

