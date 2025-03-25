<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Calculate totals for cards
        $totalPemasukan = Pemasukan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('jumlah');
        $sisaKas = $totalPemasukan - $totalPengeluaran;

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
            'perPage' => $perPage,
            'total' => $total,
            'currentPage' => $currentPage,
            // Add the new variables
            'sisaKas' => $sisaKas,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }
}