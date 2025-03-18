<?php

namespace App\Http\Controllers;

use App\Models\Progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;

class progresproyekController extends Controller
{
    public function index(Request $request)
    {
        $query = Progres::query();
        // dd($query);
        // Search functionality
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_proyek', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'id_proyek');
        $sortDirection = $request->query('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Filter for drafter
        // if (Auth::user()->role === 'drafter') {
        //     $query->where('id_drafter', Auth::id());
        // }

        // Pagination
        $perPage = $request->query('entries', 10);
        $projects = $query->paginate($perPage);

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
        $projects = Project::all();
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
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,zip|max:2048',
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
        $projects = Project::all();
        
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
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
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

