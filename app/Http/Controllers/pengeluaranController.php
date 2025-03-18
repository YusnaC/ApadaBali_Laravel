<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
        }

        // Sorting
        $sortField = $request->query('sort', 'id');
        $sortDirection = $request->query('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->query('entries', 10);
        $pengeluarans = $query->paginate($perPage);
        
        // Calculate totals
        $total = $pengeluarans->total();
        $currentPage = $pengeluarans->currentPage();
        
        // Calculate summary
        $totalPengeluaran = Pengeluaran::sum('total_harga');

        return view('tables.pengeluaranKeuangan', [
            'projects' => $pengeluarans,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }

    public function create()
    {
        return view('pengeluaran');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pengeluaran::create($request->all());

        return redirect()->route('tables.pengeluaranKeuangan')
            ->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengeluaran->update($request->all());

        return redirect()->route('tables.pengeluaranKeuangan')
            ->with('success', 'Data pengeluaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('tables.pengeluaranKeuangan')
            ->with('success', 'Data pengeluaran berhasil dihapus');
    }
}