<?php

namespace App\Http\Controllers;

use App\Models\Drafter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrafterController extends Controller
{
    public function index(Request $request)
    {
        $query = Drafter::query();

        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where('nama_drafter', 'like', "%{$search}%")
                  ->orWhere('id_drafter', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id_drafter');
        $sortDirection = $request->query('direction', 'asc');
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
        $lastDrafter = Drafter::orderByRaw("CAST(SUBSTRING(id_drafter, 2) AS UNSIGNED) DESC")->first();

        if (!$lastDrafter) {
            $newId = 'D0001';
        } else {
            $lastNumber = intval(substr($lastDrafter->id_drafter, 1));
            $newId = 'D' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }
        $drafter = null;
        return view('dataDrafter', compact('newId', 'drafter'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_drafter' => 'required|string|max:255',
            'alamat_drafter' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Drafter::create($request->all());

        return redirect()->route('tables.drafter')
            ->with('success', 'Data drafter berhasil ditambahkan');
    }

    public function edit($id)
    {
        $drafter = Drafter::where('id_drafter', $id)->firstOrFail();
        return view('drafter', compact('drafter'));
    }

    public function update(Request $request, $id)
    {
        $drafter = Drafter::where('id_drafter', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'nama_drafter' => 'required|string|max:255',
            'alamat_drafter' => 'required|string',
            'no_whatsapp' => 'required|string|max:15'
        ]);

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
        $drafter = Drafter::where('id_drafter', $id)->firstOrFail();
        $drafter->delete();

        return redirect()->route('tables.drafter')
            ->with('success', 'Data drafter berhasil dihapus');
    }
}