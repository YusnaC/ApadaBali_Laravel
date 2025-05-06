<?php

namespace App\Http\Controllers;

use App\Models\Progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Proyek;
use Illuminate\Support\Facades\DB;

class progresproyekController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in user's ID and join with necessary tables
        // dd(Auth::id());
        // Get drafter ID based on logged-in user's name
        $loggedInUserName = Auth::user()->name;
        $drafter = DB::table('drafter')
            ->where('nama_drafter', $loggedInUserName)
            ->first();
            
        $query = Progres::query()
            ->join('proyek', 'progres.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.id_drafter', $drafter ? $drafter->id_drafter : '0');
            // ->join('drafters', 'projects.id_drafter', '=', 'drafters.id')
            // ->where('drafters.id', Auth::id()-1);
        // Search functionality
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('progres.id_proyek', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('tgl_progres', 'like', "%{$search}%")
                  ->orWhere('progres', 'like', "%{$search}%")
                  ->orWhere('dokumen', 'like', "%{$search}%");
            });
        }
    
        // Sorting
        $sortField = $request->query('sort', 'id_proyek');
        $sortDirection = $request->query('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
    
        // Pagination
        $perPage = $request->query('entries', 10);
        $projects = $query->select('progres.*')->paginate($perPage);
    
        return view('tables.progresproyek', [
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
        $projects = Proyek::all();
        $project = null; // Initialize project as null for the create form
        return view('createProgres', compact('projects', 'project'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proyek' => 'required|string',
            'tgl_proyek' => 'required|date',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,zip|max:30720',
        ]);

        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('dokumen-progres', 'public');
            $validated['dokumen'] = $path;
        }

        $validated['id_drafter'] = Auth::id();
        
        ProgresProyek::create($validated);

        return redirect()->route('tables.progresproyek')
                        ->with('success', 'Progress proyek berhasil ditambahkan');
    }

    public function edit($id)
    {
        $progres = Progres::findOrFail($id);
        $projects = Proyek::all();
        
        // if (Auth::user()->role !== 'admin' && $progres->id_drafter !== Auth::id()) {
        //     abort(403);
        // }

        return view('createProgres', compact('projects', 'progres'));
    }

    public function update(Request $request, $id)
    {
        $progres = Progres::findOrFail($id);
        // dd($id);
        // if (Auth::user()->role !== 'admin' && $progres->id_drafter !== Auth::id()) {
        //     abort(404);
        // }

        $validated = $request->validate([
            'tgl_proyek' => 'required|date',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        if ($request->hasFile('dokumen')) {
            // Delete old file if exists
            if ($progres->dokumen) {
                Storage::disk('public')->delete($progres->dokumen);
            }
            $path = $request->file('dokumen')->store('dokumen-progres', 'public');
            $validated['dokumen'] = $path;
        }

        $progres->update($validated);

        return redirect()->route('tables.progresproyek')
                        ->with('success', 'Progress proyek berhasil diperbarui');
    }

    public function destroy($id)
    {
        $progres = Progres::findOrFail($id);
        
        if (Auth::user()->role !== 'admin' && $progres->id_drafter !== Auth::id()) {
            abort(403);
        }

        if ($progres->dokumen) {
            Storage::disk('public')->delete($progres->dokumen);
        }

        $progres->delete();

        return redirect()->route('tables.progresproyek')
                        ->with('success', 'Progress proyek berhasil dihapus');
    }
}

