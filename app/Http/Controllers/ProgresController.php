<?php

namespace App\Http\Controllers;

use App\Models\Progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProgresController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('entries', 10);
        
        // Get latest progress entries using subquery
        $latestIds = DB::table('progres as p1')
            ->select('p1.id')
            ->whereNotExists(function ($query) {
                $query->from('progres as p2')
                    ->whereRaw('p1.id_proyek = p2.id_proyek')
                    ->whereRaw('p2.tgl_progres > p1.tgl_progres');
            });

        $query = Progres::whereIn('id', $latestIds);
    
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('id_proyek', 'LIKE', "%{$search}%")
                  ->orWhere('status_progres', 'LIKE', "%{$search}%");
        }
    
        // Sorting
        $sortField = $request->get('sort', 'id_proyek');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
    
        $projects = $query->paginate($perPage);
        $projects->appends($request->all());
    
        return view('progresproyek', [
            'projects' => $projects,
            'perPage' => $perPage,
            'search' => $request->search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection
        ]);
    }

    public function create()
    {
        $projects = Project::all();
        $project = null; // Initialize project as null for the create form
        return view('createProgres', compact('projects', 'project'));
    }

    // public function create($id_proyek)
    // {
    //     $project = Project::where('id_proyek', $id_proyek)->firstOrFail();
    //     return view('createProgres', compact('project'));
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proyek' => 'required|exists:projects,id_proyek',
            'tgl_progres' => 'required|date',
            'status_progres' => 'required|in:Proses,Selesai',
            'progres' => 'required|integer|min:0|max:100',
            'dokumen' => 'required|file|mimes:zip|max:5120', // 5MB max, ZIP only
            'keterangan' => 'nullable|string|max:255'
        ]);
    
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen', $filename, 'public');
            $validated['dokumen'] = $path;
        }
    
        Progres::create($validated);
    
        return redirect()->route('progres.show', $request->id_proyek)
            ->with('success', 'Progress berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_proyek' => 'required|exists:proyek,id_proyek',
            'tgl_progres' => 'required|date',
            'status_progres' => 'required|string',
            'progres' => 'required|integer|min:0|max:100',
            'dokumen' => 'nullable|file|mimes:zip,pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
            'keterangan' => 'nullable|string'
        ]);

        $progres = Progres::findOrFail($id);

        if ($request->hasFile('dokumen')) {
            // Delete old file if exists
            if ($progres->dokumen && Storage::disk('public')->exists($progres->dokumen)) {
                Storage::disk('public')->delete($progres->dokumen);
            }

            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen', $filename, 'public');
            $validated['dokumen'] = $path;
        }

        $progres->update($validated);

        return redirect()->route('tables.progresproyek')
            ->with('success', 'Progress berhasil diperbarui');
    }

    public function show($id_proyek)
    {
        // Get the main progress record with project relationship
        $progres = Progres::where('id_proyek', $id_proyek)
            ->with('proyek')
            ->firstOrFail();
    
        // Get all progress files for this project
        $progres_files = Progres::where('id_proyek', $id_proyek)
            ->whereNotNull('dokumen')
            ->get();
    
        return view('dataprogres', compact('progres', 'progres_files'));
    }
    
    public function download($id_proyek)
    {
        $progres = Progres::where('id_proyek', $id_proyek)
            ->whereNotNull('dokumen')
            ->firstOrFail();
        
        if (!$progres->dokumen || !Storage::disk('public')->exists($progres->dokumen)) {
            return back()->with('error', 'File tidak ditemukan');
        }
    
        return Storage::disk('public')->download($progres->dokumen);
    }
    public function edit($id)
    {
        $progres = Progres::findOrFail($id);
    $projects = Project::select('id_proyek', 'nama_proyek')->get();
    return view('detailProyek', compact('progres', 'projects'));
    }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'id_proyek' => 'required|exists:proyek,id_proyek',
    //         'tgl_progres' => 'required|date',
    //         'status_progres' => 'required|string',
    //         'progres' => 'required|integer|min:0|max:100',
    //         'dokumen' => 'nullable|string',
    //         'keterangan' => 'nullable|string'
    //     ]);

    //     $progres = Progres::findOrFail($id);
    //     $progres->update($validated);

    //     return redirect()->route('tables.progresproyek')
    //         ->with('success', 'Progress berhasil diperbarui');
    // }

    public function destroy($id)
    {
        $progres = Progres::findOrFail($id);
        $progres->delete();

        return redirect()->route('tables.progresproyek')
            ->with('success', 'Progress berhasil dihapus');
    }
}