<?php

namespace App\Http\Controllers;

use App\Models\Progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Proyek;
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
    
        // Enhanced Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search by ID Proyek or text fields
                $q->where('id_proyek', 'LIKE', "%{$search}%")
                  ->orWhere('keterangan', 'LIKE', "%{$search}%")
                  ->orWhere('dokumen', 'LIKE', "%{$search}%");

                // Search by date - handle multiple date formats
                try {
                    $searchDate = \Carbon\Carbon::parse($search)->format('Y-m-d');
                    $q->orWhere('tgl_progres', $searchDate);
                } catch (\Exception $e) {
                    // Invalid date format, skip date search
                }

                // Search by progress - handle percentage symbol
                $progressSearch = str_replace('%', '', $search);
                if (is_numeric($progressSearch)) {
                    $q->orWhere('progres', 'LIKE', "%{$progressSearch}%");
                }
            });
        }
    
        // Sorting
        $sortField = $request->get('sort', 'id_proyek');
        $sortDirection = $request->get('direction', 'desc');
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
        // $user_id = auth()->id();
        // $projects = Project::join('drafters', 'projects.id_drafter', '=', 'drafters.id_drafter')
        //     ->where('drafters.id_user', $user_id -1)
        //     ->select('projects.*')
        //     ->get();
        
        // $project = null;
        // dd($projects);
        // return view('createProgres', compact('projects', 'project'));
    }

    // public function create($id_proyek)
    // {
    //     $project = Project::where('id_proyek', $id_proyek)->firstOrFail();
    //     return view('createProgres', compact('project'));
    // }

    public function store(Request $request)
    {
        $messages = [
            'id_proyek.required' => 'ID Proyek wajib diisi',
            'tgl_progres.required' => 'Tanggal Progres wajib diisi',
            'progres.required' => 'Progres wajib diisi',
            'progres.integer' => 'Progres harus berupa angka',
            'progres.min' => 'Progres minimal 0%',
            'progres.max' => 'Progres maksimal 100%',
            'dokumen.required' => 'Dokumen wajib diupload',
            'dokumen.file' => 'File tidak valid',
            'dokumen.mimes' => 'Format file harus ZIP, RAR, atau PDF',
            'dokumen.max' => 'Ukuran file maksimal 5MB'
        ];

        $validated = $request->validate([
            'id_proyek' => 'required|exists:proyek,id_proyek',
            'tgl_progres' => 'required|date',
            'progres' => 'required|integer|min:0|max:100',
            'dokumen' => 'required|file|mimes:zip,rar,pdf|max:5120',
            'keterangan' => 'nullable|string|max:255'
        ], $messages);
    
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen', $filename, 'public');
            $validated['dokumen'] = $path;
        }
    
        // Set status based on progress value
        $validated['status_progres'] = $validated['progres'] >= 100 ? 'Selesai' : 'Proses';
    
        $progress = Progres::create($validated);
    
        try {
            // Direct notification sending instead of using queue
            $factory = (new \Kreait\Firebase\Factory)
                ->withServiceAccount(storage_path('app/firebase/apadabali-7d57a-firebase-adminsdk-fbsvc-9efa655d53.json'));
            
            $messaging = $factory->createMessaging();
            
            $notification = \Kreait\Firebase\Messaging\Notification::create()
                ->withTitle('Progress Update')
                ->withBody('Progress proyek ' . $request->id_proyek . ' telah diperbarui menjadi ' . $progress->progres . '%');

            $message = \Kreait\Firebase\Messaging\CloudMessage::new()
                ->withNotification($notification)
                ->withData([
                    'project_id' => $progress->id_proyek,
                    'progress' => $progress->progres,
                    'type' => 'progress_update'
                ]);

            // Get all device tokens for admin users
            $tokens = \DB::table('device_tokens')
                ->join('users', 'device_tokens.user_id', '=', 'users.id')
                ->where('users.role', 'admin')
                ->whereNotNull('device_tokens.fcm_token')
                ->pluck('device_tokens.fcm_token')
                ->unique()
                ->values()
                ->toArray();

            if (!empty($tokens)) {
                try {
                    // Split tokens into chunks of 500 (Firebase limit)
                    $tokenChunks = array_chunk($tokens, 500);
                    
                    foreach ($tokenChunks as $tokenGroup) {
                        $response = $messaging->sendMulticast($message, $tokenGroup);
                        
                        if ($response->successes()->count() > 0) {
                            \Log::info('Progress FCM notification sent successfully to ' . $response->successes()->count() . ' devices');
                        }
                        
                        if ($response->failures()->count() > 0) {
                            foreach ($response->failures()->getItems() as $failure) {
                                \Log::error('Progress FCM notification failed: ' . $failure->error()->getMessage());
                                
                                // Remove invalid tokens
                                if (in_array($failure->error()->getMessage(), ['registration-token-not-registered', 'invalid-registration-token'])) {
                                    \DB::table('device_tokens')
                                        ->where('fcm_token', $failure->token())
                                        ->delete();
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send progress FCM notification: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            \Log::error('Progress Firebase notification failed: ' . $e->getMessage());
        }

        return redirect()->route('tables.progresproyek', $request->id_proyek)
            ->with('success', 'Progress berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            $messages = [
                'tgl_progres.required' => 'Tanggal Progres wajib diisi',
                'progres.required' => 'Progres wajib diisi',
                'progres.integer' => 'Progres harus berupa angka',
                'progres.min' => 'Progres minimal 0%',
                'progres.max' => 'Progres maksimal 100%',
                'dokumen.file' => 'File tidak valid',
                'dokumen.mimes' => 'Format file harus ZIP, RAR, atau PDF',
                'dokumen.max' => 'Ukuran file maksimal 5MB'
            ];

            $rules = [
                'tgl_progres' => 'required|date',
                'progres' => 'required|integer|min:0|max:100',
                'keterangan' => 'nullable|string|max:255'
            ];

            if ($request->hasFile('dokumen')) {
                $rules['dokumen'] = 'file|mimes:zip,rar,pdf|max:5120';
            }

            $this->validate($request, $rules, $messages);

            $progres = Progres::findOrFail($id);
            $data = $request->only(['tgl_progres', 'progres', 'keterangan']);

            // Set status based on progress value
            $data['status_progres'] = $request->progres >= 100 ? 'Selesai' : 'Proses';

            if ($request->hasFile('dokumen')) {
                if ($progres->dokumen && Storage::disk('public')->exists($progres->dokumen)) {
                    Storage::disk('public')->delete($progres->dokumen);
                }
                $file = $request->file('dokumen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['dokumen'] = $file->storeAs('dokumen', $filename, 'public');
            }

            $progres->update($data);

            return redirect()->route('tables.progresproyek')
                ->with('success', 'Progress berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Progress update error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate progress: ' . $e->getMessage());
        }
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
    $projects = Proyek::select('id_proyek', 'nama_proyek')->get();
    return view('detailProyek', compact('progres', 'projects'));
    }

    public function destroy($id)
    {
        $progres = Progres::findOrFail($id);
        $progres->delete();

        return redirect()->route('tables.progresproyek')
            ->with('success', 'Progress berhasil dihapus');
    }
}