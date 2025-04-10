<?php

namespace App\Http\Controllers;

use App\Models\Drafter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DrafterController extends Controller
{
    public function index(Request $request)
    {
        $query = Drafter::query();

        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where('nama_drafter', 'like', "%{$search}%")
                  ->orWhere('id_drafter', 'like', "%{$search}%")
                  ->orWhere('alamat_drafter', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id_drafter');
        $sortDirection = $request->query('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $drafters = $query->paginate($perPage);
        
        return view('tables.drafter', [
            'projects' => $drafters,
            'total' => $drafters->total(),
            'perPage' => $perPage,
            'currentPage' => $drafters->currentPage(),
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
{
    // Ambil data drafter terakhir berdasarkan angka dari id_drafter (contoh: D0005)
    $lastDrafter = Drafter::withTrashed()
        ->orderByRaw("CAST(SUBSTRING(id_drafter, 2) AS UNSIGNED) DESC")
        ->first();

    // Jika belum ada data drafter, mulai dari D0001
    if (!$lastDrafter) {
        $newId = 'D0001';
    } else {
        // Ambil angka dari id_drafter terakhir dan increment
        $lastNumber = (int) substr($lastDrafter->id_drafter, 1);
        $newId = 'D' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    // Untuk create, kita kirimkan newId ke view
    $drafter = null;
    return view('dataDrafter', compact('newId', 'drafter'));
}


    public function store(Request $request)
    {
        $messages = [
            'nama_drafter.required' => 'Nama drafter wajib diisi',
            'nama_drafter.string' => 'Nama drafter harus berupa teks',
            'nama_drafter.max' => 'Nama drafter maksimal 255 karakter',
            'alamat_drafter.required' => 'Alamat drafter wajib diisi',
            'alamat_drafter.string' => 'Alamat drafter harus berupa teks',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'no_whatsapp.string' => 'Nomor WhatsApp harus berupa teks',
            'no_whatsapp.max' => 'Nomor WhatsApp maksimal 15 karakter',
            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username harus berupa teks',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 8 karakter',
            'email' => 'Email wajib diisi',

        ];

        $validator = Validator::make($request->all(), [
            'nama_drafter' => 'required|string|max:255',
            'alamat_drafter' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'no_whatsapp' => 'required|string|max:15',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create drafter record
            $drafter = Drafter::create([
                'id_drafter' => $request->id_drafter,
                'nama_drafter' => $request->nama_drafter,
                'alamat_drafter' => $request->alamat_drafter,
                'no_whatsapp' => $request->no_whatsapp,
            ]);

            // Create user account
            User::create([
                'username' => $request->username,
                'name' => $request->nama_drafter,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'drafter'
            ]);

            DB::commit();

            return redirect()->route('tables.drafter')
                ->with('success', 'Data drafter dan akun berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $drafter = Drafter::where('id_drafter', $id)->firstOrFail();
        return view('drafter', compact('drafter'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'nama_drafter.required' => 'Nama drafter wajib diisi',
            'nama_drafter.string' => 'Nama drafter harus berupa teks',
            'nama_drafter.max' => 'Nama drafter maksimal 255 karakter',
            'alamat_drafter.required' => 'Alamat drafter wajib diisi',
            'alamat_drafter.string' => 'Alamat drafter harus berupa teks',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'no_whatsapp.string' => 'Nomor WhatsApp harus berupa teks',
            'no_whatsapp.max' => 'Nomor WhatsApp maksimal 15 karakter',
            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username harus berupa teks',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 8 karakter',
            'email' => 'Email wajib diisi',

        ];

        $drafter = Drafter::where('id_drafter', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'nama_drafter' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat_drafter' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $drafter->update($request->all());

        return redirect()->route('tables.drafter')
            ->with('success', 'Data drafter berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Find drafter
            $drafter = Drafter::where('id_drafter', $id)->firstOrFail();
            
            // Find and delete associated user account by name
            User::where('name', $drafter->nama_drafter)->delete();
            
            // Delete drafter record
            $drafter->delete();

            DB::commit();
            return redirect()->route('tables.drafter')
                ->with('success', 'Data drafter dan akun berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}