<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class pemasukanController extends Controller
{
    public function index(Request $request)
    {
        // Get total pemasukan
        $totalPemasukan = Pemasukan::sum('jumlah');
        
        // Get total pengeluaran
        $totalPengeluaran = Pengeluaran::sum('total_harga');
        
        // Get sisa kas
        $sisaKas = (int)($totalPemasukan - $totalPengeluaran);
    
        // Initialize query
        $query = Pemasukan::query();
    
        // Filter pencarian
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_order', 'like', "%{$search}%")
                  ->orWhere('id_order', 'like', "%{$search}%")
                  ->orWhere('tgl_transaksi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('jumlah', 'like', "%{$search}%")
                  ->orWhere('termin', 'like', "%{$search}%");
                  ;
            });
        }
    
        // Handle sorting
        $sortField = $request->query('sort', 'created_at');
        $sortDirection = $request->query('direction', 'desc');
    
        // Special handling for 'no' column
        if ($sortField === 'no') {
            $query->orderBy('id', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }
    
        // Pagination
        $perPage = $request->query('entries', 10);
        $pemasukan = $query->paginate($perPage);
        
        return view('tables.pemasukanKeuangan', [
            'pemasukan' => $pemasukan,
            'search' => $search,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
            'total' => $pemasukan->total(),
            'currentPage' => $pemasukan->currentPage(),
            'sisaKas' => $sisaKas,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }

    public function create()
    {
        $furnitureOrders = DB::table('furniture')
            ->select('id_furniture')
            ->whereNull('deleted_at')
            ->get();
            
        $proyekOrders = DB::table('proyek')
            ->select('id_proyek')
            ->whereNull('deleted_at')
            ->get();

        return view('pemasukan', compact('furnitureOrders', 'proyekOrders'));
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        
        // Get furniture orders
        $furnitureOrders = DB::table('furniture')
            ->select('id_furniture')
            ->get();
            
        // Get project orders
        $proyekOrders = DB::table('proyek')
            ->select('id_proyek')
            ->get();

        // Get selected order details
        // $selectedOrder = $pemasukan->jenis_order === 'Furniture' 
        //     ? DB::table('furnitures')->where('id_furniture', $pemasukan->id_order)->first()
        //     : DB::table('projects')->where('id_proyek', $pemasukan->id_order)->first();
        $selectedOrder = match ($pemasukan->jenis_order) {
            'Jasa' => DB::table('proyek')
                        ->where('id_proyek', $pemasukan->id_order)
                        ->where('kategori', 2)
                        ->first(),
        
            'Proyek Arsitektur' => DB::table('proyek')
                                     ->where('id_proyek', $pemasukan->id_order)
                                     ->where('kategori', 1)
                                     ->first(),
        
            default => DB::table('furniture')
                         ->where('id_furniture', $pemasukan->id_order)
                         ->first(),
        };
        

        return view('pemasukan', compact('pemasukan', 'furnitureOrders', 'proyekOrders', 'selectedOrder'));
    }

    public function store(Request $request)
    {
        $messages = [
            'jenis_order.required' => 'Jenis order wajib diisi',
            'jenis_order.in' => 'Jenis order harus Proyek Arsitektur, Furniture atau Jasa',
            'id_order.required' => 'ID order wajib diisi',
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi',
            'tgl_transaksi.date' => 'Format tanggal transaksi tidak valid',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0',
            'termin.required' => 'Termin wajib diisi',
            'termin.integer' => 'Termin harus berupa angka bulat',
            
        ];
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture,Jasa',
            'id_order' => [
                'required'
            ],
            'tgl_transaksi' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'termin' => [
                'required',
                'integer',
                // function ($attribute, $value, $fail) use ($request) {
                //     $exists = Pemasukan::where('id_order', $request->id_order)
                //                      ->where('termin', $value)
                //                      ->exists();
                //     if ($exists) {
                //         $fail('Termin ini sudah ada untuk ID Order yang sama.');
                //     }
                // }
            ],
            'keterangan' => 'nullable|string|max:255'
        ], $messages);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pemasukan::create($request->all());

        return redirect()->route('tables.pemasukanKeuangan')
            ->with('success', 'Data pemasukan berhasil ditambahkan');
    }

    // public function edit($id)
    // {
    //     $pemasukan = Pemasukan::findOrFail($id);
    //     return view('pemasukan', compact('pemasukan'));
    // }

    public function update(Request $request, $id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $messages = [
            'jenis_order.required' => 'Jenis order wajib diisi',
            'jenis_order.in' => 'Jenis order harus Proyek Arsitektur, Furniture atau Jasa',
            'id_order.required' => 'ID order wajib diisi',
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi',
            'tgl_transaksi.date' => 'Format tanggal transaksi tidak valid',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0',
            'termin.required' => 'Termin wajib diisi',
            'termin.integer' => 'Termin harus berupa angka bulat',
            
        ];
        $validator = Validator::make($request->all(), [
            'jenis_order' => 'required|in:Proyek Arsitektur,Furniture,Jasa',
            'id_order' => 'required',
            'tgl_transaksi' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'termin' => [
                'required',
                
            ],
            'keterangan' => 'nullable|string|max:255'
        ], $messages);

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