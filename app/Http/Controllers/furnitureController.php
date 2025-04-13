<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FurnitureController extends Controller
{
    public function index(Request $request)
    {
        $query = Furniture::query();

        // Search functionality
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_furniture', 'LIKE', "%{$search}%")
                  ->orWhere('jumlah_unit', 'LIKE', "%{$search}%")
                  ->orWhere('harga_unit', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%")
                  ->orWhere('id_furniture', 'LIKE', "%{$search}%")
                  ->orWhereDate('tgl_pembuatan', 'LIKE', "%{$search}%")
                  ->orWhereDate('tgl_selesai', 'LIKE', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'id_furniture');
        $sortDirection = $request->query('direction', 'desc');
        
        // Handle special case for numeric columns
        if (in_array($sortField, ['jumlah_unit', 'harga_unit'])) {
            $query->orderByRaw("CAST($sortField AS DECIMAL) $sortDirection");
        } 
        // Handle date columns
        else if (in_array($sortField, ['tgl_pembuatan', 'tgl_selesai'])) {
            $query->orderBy($sortField, $sortDirection);
        }
        // Handle other columns
        else {
            $query->orderBy($sortField, $sortDirection);
        }

        // Pagination
        $perPage = $request->query('entries', 10);
        $furnitures = $query->paginate($perPage)->withQueryString();

        return view('tables.furniture', [
            'furnitures' => $furnitures,
            'total' => $furnitures->total(),
            'perPage' => $perPage,
            'currentPage' => $furnitures->currentPage(),
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create()
{
    $prefix = 'AFB';

    $lastFurniture = Furniture::withTrashed()
        ->orderByRaw("CAST(SUBSTRING(id_furniture, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
        ->first();

    if (!$lastFurniture) {
        $newId = $prefix . '0001';
    } else {
        $lastNumber = intval(substr($lastFurniture->id_furniture, strlen($prefix)));
        $newId = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    return view('furniture', compact('newId'))->with('furniture', null);
}




    public function store(Request $request)
    {
        $messages = [
            'nama_furniture.required' => 'Nama furniture wajib diisi',
            'nama_furniture.max' => 'Nama furniture maksimal 255 karakter',
            'jumlah_unit.required' => 'Jumlah unit wajib diisi',
            'jumlah_unit.integer' => 'Jumlah unit harus berupa angka',
            'jumlah_unit.min' => 'Jumlah unit minimal 1',
            'harga_unit.required' => 'Harga unit wajib diisi',
            'harga_unit.numeric' => 'Harga unit harus berupa angka',
            'harga_unit.min' => 'Harga unit tidak boleh kurang dari 0',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi',
            'tgl_selesai.date' => 'Format tanggal selesai tidak valid',
            'tgl_pembuatan.required' => 'Tanggal pembuatan wajib diisi',
            'tgl_pembuatan.date' => 'Format tanggal pembuatan tidak valid',

        ];

        $validated = $request->validate([
            'id_furniture' => 'required|string|unique:furniture,id_furniture',
            'nama_furniture' => 'required|string|max:255',
            'jumlah_unit' => 'required|integer|min:1',
            'harga_unit' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'tgl_selesai' => 'required|date',
            'tgl_pembuatan' => 'required|date',
        ], $messages);

        $furniture = Furniture::create([
            'id_furniture' => $validated['id_furniture'],
            'tgl_pembuatan' => $validated['tgl_pembuatan'],
            'nama_furniture' => $validated['nama_furniture'],
            'jumlah_unit' => $validated['jumlah_unit'],
            'harga_unit' => $validated['harga_unit'],
            'lokasi' => $validated['lokasi'],
            'tgl_selesai' => $validated['tgl_selesai'],
        ]);

        return redirect()->route('furniture.index')
            ->with('success', 'Furniture created successfully.');
    }

    public function show(Furniture $furniture)
    {
        return view('furniture.show', compact('furniture'));
    }

    public function edit(Furniture $furniture)
    {
        return view('furniture', ['furniture' => $furniture]);

    }

    public function update(Request $request, Furniture $furniture)
    {
        $messages = [
            'nama_furniture.required' => 'Nama furniture wajib diisi',
            'nama_furniture.max' => 'Nama furniture maksimal 255 karakter',
            'jumlah_unit.required' => 'Jumlah unit wajib diisi',
            'jumlah_unit.integer' => 'Jumlah unit harus berupa angka',
            'jumlah_unit.min' => 'Jumlah unit minimal 1',
            'harga_unit.required' => 'Harga unit wajib diisi',
            'harga_unit.numeric' => 'Harga unit harus berupa angka',
            'harga_unit.min' => 'Harga unit tidak boleh kurang dari 0',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi',
            'tgl_selesai.date' => 'Format tanggal selesai tidak valid',
            'tgl_pembuatan.required' => 'Tanggal pembuatan wajib diisi',
            'tgl_pembuatan.date' => 'Format tanggal pembuatan tidak valid',

        ];

        $validated = $request->validate([
            'nama_furniture' => 'required|string|max:255',
            'jumlah_unit' => 'required|integer|min:1',
            'harga_unit' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'tgl_selesai' => 'required|date',
            'tgl_pembuatan' => 'required|date',
        ], $messages);

        $furniture->update($validated);

        return redirect()->route('furniture.index')
            ->with('success', 'Furniture updated successfully.');
    }

    public function destroy(Furniture $furniture)
    {
        try {
            DB::beginTransaction();
            
            if (!$furniture) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Furniture tidak ditemukan!');
            }
            
            $furniture->delete(); // This will now soft delete due to SoftDeletes trait
            
            DB::commit();
            return redirect()->route('furniture.index')
                ->with('success', 'Furniture berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Furniture deletion error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus furniture: ' . $e->getMessage());
        }
    }
}