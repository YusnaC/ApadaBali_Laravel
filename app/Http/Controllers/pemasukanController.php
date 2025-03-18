<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use Illuminate\Support\Facades\Validator;

class pemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::query();  // Remove the eager loading for now
    
        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_order', 'like', "%{$search}%")
                  ->orWhere('pemasukan.id_order', 'like', "%{$search}%");  // Specify the table name
            });
        }
    
        $sortField = $request->query('sort', 'id');
        $sortDirection = $request->query('direction', 'asc');
    
        // Handle sorting with table prefix
        if ($sortField === 'no') {
            $query->orderBy('pemasukan.id', $sortDirection);
        } else {
            $query->orderBy('pemasukan.' . $sortField, $sortDirection);
        }

        // Rest of the code remains the same
        $perPage = $request->query('entries', 10);
        $pemasukan = $query->paginate($perPage);
        
        // Calculate totals
        $total = $pemasukan->total();
        $currentPage = $pemasukan->currentPage();
    
        return view('tables.pemasukanKeuangan', [
            'pemasukan' => $pemasukan,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
            'total' => $total,
            'currentPage' => $currentPage
        ]);
    }

    public function create()
    {
        return view('pemasukan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture',
            'id_order' => 'required|unique:pemasukan',
            'tgl_transaksi' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'termin' => 'required|integer|min:1|max:3',
            'keterangan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pemasukan::create($request->all());

        return redirect()->route('tables.pemasukanKeuangan')
            ->with('success', 'Data pemasukan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        return view('pemasukan', compact('pemasukan'));
    }

    public function update(Request $request, $id)
    {
        $pemasukan = Pemasukan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture',
            'id_order' => 'required|unique:pemasukan,id_order,'.$id,
            'tgl_transaksi' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'termin' => 'required|integer|min:1|max:3',
            'keterangan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pemasukan->update($request->all());

        return redirect()->route('tables.pemasukanKeuangan')
            ->with('success', 'Data pemasukan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $pemasukan->delete();

        return redirect()->route('tables.pemasukanKeuangan')
            ->with('success', 'Data pemasukan berhasil dihapus');
    }

    public function show($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        return view('pemasukan', compact('pemasukan'));
    }
}