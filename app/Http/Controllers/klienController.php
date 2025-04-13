<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KlienController extends Controller
{
    public function index(Request $request)
    {
        $query = Klien::query();

        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where('nama_klien', 'like', "%{$search}%")
                  ->orWhere('id_klien', 'like', "%{$search}%")
                  ->orWhere('alamat_klien', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%")
                  ->orWhere('jenis_order', 'like', "%{$search}%")
                  ->orWhere('id_order', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id_klien');
        $sortDirection = $request->query('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $kliens = $query->paginate($perPage);

        return view('tables.klien', [
            'projects' => $kliens,
            'total' => $kliens->total(),
            'perPage' => $perPage,
            'currentPage' => $kliens->currentPage(),
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
    {
        $lastKlien = Klien::withTrashed()
            ->orderByRaw("CAST(SUBSTRING(id_klien, 4) AS UNSIGNED) DESC")
            ->first();
    
        if (!$lastKlien) {
            $newId = 'K0001';
        } else {
            $lastNumber = intval(substr($lastKlien->id_klien, 1));
            $newId = 'K' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }
    
        // Add these lines to fetch options for new records
        $proyekOptions = DB::table('proyek')->select('id_proyek')->get();
        $furnitureOptions = DB::table('furniture')->select('id_furniture')->get();
    
        $klien = null;
        return view('dataKlien', compact('newId', 'klien', 'proyekOptions', 'furnitureOptions'));
    }

    public function getOrderIds(Request $request)
    {
        $jenisOrder = $request->jenis_order;
        
        if ($jenisOrder === 'Proyek Arsitektur') {
            $orders = DB::table('proyek')
                ->where('kategori', '1')
                ->select('id_proyek as id')
                ->get();
        } elseif ($jenisOrder === 'Jasa') {
            $orders = DB::table('proyek')
                ->where('kategori', '2')
                ->select('id_proyek as id')
                ->get();
        } elseif ($jenisOrder === 'Furniture') {
            $orders = DB::table('furniture')
                ->select('id_furniture as id')
                ->get();
        }
    
        \Log::info('Orders fetched:', ['orders' => $orders]); // Add logging
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $messages = [
            'id_order.required' => 'Id order wajib diisi',
            'jenis_order.required' => 'Jenis order wajib diisi',
            'jenis_order.in' => 'Jenis order harus Proyek Arsitektur, Furniture atau Jasa',
            'nama_klien.required' => 'Nama klien wajib diisi',
            'nama_klien.string' => 'Nama klien harus berupa teks',
            'nama_klien.max' => 'Nama klien maksimal 255 karakter',
            'alamat_klien.required' => 'Alamat klien wajib diisi',
            'alamat_klien.string' => 'Alamat klien harus berupa teks',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'no_whatsapp.digits_between' => 'Nomor WhatsApp harus terdiri dari 10 sampai 15 digit angka',
            'no_whatsapp.max' => 'Nomor WhatsApp maksimal 15 karakter'
        ];

        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture,Jasa',
            'nama_klien' => 'required|string|max:255',
            'alamat_klien' => 'required|string',
            'no_whatsapp' => 'required|digits_between:10,15',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Klien::create($request->all());

        return redirect()->route('tables.klien')
            ->with('success', 'Data klien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $klien = Klien::where('id_klien', $id)->firstOrFail();
        
        // Get projects and furniture for dropdowns
        $proyekOptions = DB::table('proyek')->select('id_proyek')->get();
        $furnitureOptions = DB::table('furniture')->select('id_furniture')->get();
        
        return view('dataKlien', compact('klien', 'proyekOptions', 'furnitureOptions'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'id_order.required' => 'Id order wajib diisi',
            'jenis_order.required' => 'Jenis order wajib diisi',
            'jenis_order.in' => 'Jenis order harus Proyek Arsitektur, Furniture, Jasa ',
            'nama_klien.required' => 'Nama klien wajib diisi',
            'nama_klien.string' => 'Nama klien harus berupa teks',
            'nama_klien.max' => 'Nama klien maksimal 255 karakter',
            'alamat_klien.required' => 'Alamat klien wajib diisi',
            'alamat_klien.string' => 'Alamat klien harus berupa teks',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'no_whatsapp.string' => 'Nomor WhatsApp harus berupa teks',
            'no_whatsapp.max' => 'Nomor WhatsApp maksimal 15 karakter'
        ];
        $klien = Klien::where('id_klien', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture,Jasa',
            'nama_klien' => 'required|string|max:255',
            'alamat_klien' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $klien->update($request->all());

        return redirect()->route('tables.klien')
            ->with('success', 'Data klien berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $klien = Klien::where('id_klien', $id)->firstOrFail();
            
            if (!$klien) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data klien tidak ditemukan!');
            }
            
            $klien->delete(); // This will now soft delete due to SoftDeletes trait
            
            DB::commit();
            return redirect()->route('tables.klien')
                ->with('success', 'Data klien berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Client deletion error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus data klien: ' . $e->getMessage());
        }
    }
}