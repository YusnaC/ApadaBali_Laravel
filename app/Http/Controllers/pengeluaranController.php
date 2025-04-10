<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pemasukan;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Calculate totals for cards
        $totalPemasukan = Pemasukan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('total_harga');
        $sisaKas = (int)($totalPemasukan - $totalPengeluaran);

        $query = Pengeluaran::query();

        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $searchTerms = explode(' ', $search);
                foreach ($searchTerms as $term) {
                    $q->orWhere('nama_barang', 'like', "%{$term}%")
                      ->orWhere('keterangan', 'like', "%{$term}%")
                      ->orWhere(DB::raw("DATE_FORMAT(tanggal_transaksi, '%d')"), 'like', "%{$term}%")
                      ->orWhere(DB::raw("CAST(total_harga AS CHAR)"), 'like', "%{$term}%")
                      ->orWhere(DB::raw("CAST(harga_satuan AS CHAR)"), 'like', "%{$term}%")
                      ->orWhere(DB::raw("CAST(jumlah AS CHAR)"), 'like', "%{$term}%");
                }
            });
        }

        // Sorting
        $sortField = $request->query('sort', 'id');
        $sortDirection = $request->query('direction', 'desc');
        
        // Special handling for 'no' sorting
        if ($sortField === 'no') {
            $query->orderBy('id', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

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
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
            'total' => $pengeluarans->total(),
            'currentPage' => $pengeluarans->currentPage(),
            'sisaKas' => $sisaKas,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }

    public function create()
    {
        return view('pengeluaran');
    }

    public function store(Request $request)
    {
        $messages = [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi',
            'tanggal_transaksi.date' => 'Format tanggal transaksi tidak valid',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'nama_barang.string' => 'Nama barang harus berupa teks',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat',
            'jumlah.min' => 'Jumlah minimal 1',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka',
            'harga_satuan.min' => 'Harga satuan tidak boleh kurang dari 0',
        ];

        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ], $messages);

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
        $messages = [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi',
            'tanggal_transaksi.date' => 'Format tanggal transaksi tidak valid',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'nama_barang.string' => 'Nama barang harus berupa teks',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat',
            'jumlah.min' => 'Jumlah minimal 1',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka',
            'harga_satuan.min' => 'Harga satuan tidak boleh kurang dari 0',
        ];
        $pengeluaran = Pengeluaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ], $messages);

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