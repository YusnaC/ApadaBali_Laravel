<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id_klien');
        $sortDirection = $request->query('direction', 'asc');
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
        $lastKlien = Klien::orderByRaw("CAST(SUBSTRING(id_klien, 4) AS UNSIGNED) DESC")->first();

        if (!$lastKlien) {
            $newId = 'D001';
        } else {
            $lastNumber = intval(substr($lastKlien->id_klien, 3));
            $newId = 'D' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        $klien = null;
        return view('dataKlien', compact('newId', 'klien'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture',
            'nama_klien' => 'required|string|max:255',
            'alamat_klien' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ]);

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
        return view('dataKlien', compact('klien'));
    }

    public function update(Request $request, $id)
    {
        $klien = Klien::where('id_klien', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture',
            'nama_klien' => 'required|string|max:255',
            'alamat_klien' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ]);

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
        $klien = Klien::where('id_klien', $id)->firstOrFail();
        $klien->delete();

        return redirect()->route('tables.klien')
            ->with('success', 'Data klien berhasil dihapus');
    }
}