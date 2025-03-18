<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FurnitureController extends Controller
{
    public function index(Request $request)
    {
        $query = Furniture::query();

        // Search functionality
        $search = $request->query('search');
        if ($search) {
            $query->where('nama_furniture', 'LIKE', "%{$search}%")
                  ->orWhere('jumlah_unit', 'LIKE', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id_furniture');
        $sortDirection = $request->query('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $furnitures = $query->paginate($perPage);

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
    $lastFurniture = Furniture::orderByRaw("CAST(SUBSTRING(id_furniture, 4) AS UNSIGNED) DESC")->first();

    if (!$lastFurniture) {
        $newId = 'AFB001';
    } else {
        $lastNumber = intval(substr($lastFurniture->id_furniture, 3));
        $newId = 'AFB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }
    // dd($newId);
    // Kirimkan juga furniture = null agar form tetap bisa digunakan
    return view('furniture', compact('newId'))->with('furniture', null);
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_furniture' => 'required|string|unique:furnitures,id_furniture',
            'nama_furniture' => 'required|string|max:255',
            'jumlah_unit' => 'required|integer|min:1',
            'harga_unit' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'tgl_selesai' => 'required|date',
        ]);

        $furniture = Furniture::create([
            'id_furniture' => $validated['id_furniture'],
            'tgl_pembuatan' => now(),
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
        $validated = $request->validate([
            'nama_furniture' => 'required|string|max:255',
            'jumlah_unit' => 'required|integer|min:1',
            'harga_unit' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'tgl_selesai' => 'required|date',
        ]);

        $furniture->update($validated);

        return redirect()->route('furniture.index')
            ->with('success', 'Furniture updated successfully.');
    }

    public function destroy(Furniture $furniture)
    {
        $furniture->delete();

        return redirect()->route('furniture.index')
            ->with('success', 'Furniture deleted successfully.');
    }
}