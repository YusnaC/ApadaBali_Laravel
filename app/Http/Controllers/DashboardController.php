<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Klien;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Progres;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin(Request $request)
    {
        $filter = $request->input('filter', 'month'); // Default to monthly view
        
        // Get card data
        $totalProyek = Project::count();
        $totalPemasukan = Pemasukan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('total_harga');
        $totalPendapatan = $totalPemasukan - $totalPengeluaran;
        $totalKlien = Klien::count();
        $proyekBerjalan = Progres::where('status_progres', 'Proses')->distinct('id_proyek')->count();
    
        // Get project and revenue data based on filter
        switch($filter) {
            case 'week':
                $projectData = Project::select(
                    DB::raw('DATE(tgl_proyek) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereRaw('tgl_proyek >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
    
                $revenueData = $this->getWeeklyRevenueData();
                break;
    
            case 'year':
                $projectData = Project::select(
                    DB::raw('MONTH(tgl_proyek) as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('tgl_proyek', date('Y'))
                ->groupBy(DB::raw('MONTH(tgl_proyek)'))
                ->orderBy('month')
                ->get();
    
                $revenueData = $this->getYearlyRevenueData();
                break;
    
            default: // month
                $projectData = Project::select(
                    DB::raw('DAY(tgl_proyek) as day'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereMonth('tgl_proyek', date('m'))
                ->whereYear('tgl_proyek', date('Y'))
                ->groupBy('day')
                ->orderBy('day')
                ->get();
    
                $revenueData = $this->getMonthlyRevenueData();
        }
    
        return view('dashboard', compact(
            'totalProyek',
            'totalPendapatan',
            'totalKlien',
            'proyekBerjalan',
            'projectData',
            'revenueData',
            'filter'
        ));
    }
    
    private function getWeeklyRevenueData()
    {
        return DB::table('pemasukan')
            ->select(
                DB::raw('DATE(tgl_transaksi) as date'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereRaw('tgl_transaksi >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
            ->groupBy('date')
            ->get()
            ->map(function($item) {
                $pengeluaran = DB::table('pengeluarans')
                    ->whereDate('tanggal_transaksi', $item->date)
                    ->sum('total_harga');
                
                return [
                    'date' => $item->date,
                    'pemasukan' => (float)$item->pemasukan,
                    'pengeluaran' => (float)$pengeluaran,
                    'total' => (float)$item->pemasukan - (float)$pengeluaran
                ];
            });
    }
    
    private function getMonthlyRevenueData()
    {
        // Get all days of current month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $days = collect(range(1, $daysInMonth));
        
        // Get pemasukan data
        $pemasukan = DB::table('pemasukan')
            ->select(
                DB::raw('DAY(tgl_transaksi) as day'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereMonth('tgl_transaksi', date('m'))
            ->whereYear('tgl_transaksi', date('Y'))
            ->groupBy('day')
            ->get()
            ->keyBy('day');
    
        // Get pengeluaran data
        $pengeluaran = DB::table('pengeluarans')
            ->select(
                DB::raw('DAY(tanggal_transaksi) as day'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereMonth('tanggal_transaksi', date('m'))
            ->whereYear('tanggal_transaksi', date('Y'))
            ->groupBy('day')
            ->get()
            ->keyBy('day');
    
        return $days->map(function($day) use ($pemasukan, $pengeluaran) {
            $pemasukanAmount = isset($pemasukan[$day]) ? (float)$pemasukan[$day]->pemasukan : 0;
            $pengeluaranAmount = isset($pengeluaran[$day]) ? (float)$pengeluaran[$day]->pengeluaran : 0;
            
            return [
                'day' => (int)$day,
                'pemasukan' => $pemasukanAmount,
                'pengeluaran' => $pengeluaranAmount,
                'total' => $pemasukanAmount - $pengeluaranAmount
            ];
        })->values();
    }
    
    // private function getWeeklyRevenueData()
    // {
    //     // Get dates for last 7 days
    //     $dates = collect(range(0, 6))->map(function($day) {
    //         return date('Y-m-d', strtotime("-$day days"));
    //     })->reverse();
        
    //     // Get pemasukan data
    //     $pemasukan = DB::table('pemasukan')
    //         ->select(
    //             DB::raw('DATE(tgl_transaksi) as date'),
    //             DB::raw('SUM(jumlah) as pemasukan')
    //         )
    //         ->whereRaw('tgl_transaksi >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
    //         ->groupBy('date')
    //         ->get()
    //         ->keyBy('date');
    
    //     // Get pengeluaran data
    //     $pengeluaran = DB::table('pengeluarans')
    //         ->select(
    //             DB::raw('DATE(tanggal_transaksi) as date'),
    //             DB::raw('SUM(total_harga) as pengeluaran')
    //         )
    //         ->whereRaw('tanggal_transaksi >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
    //         ->groupBy('date')
    //         ->get()
    //         ->keyBy('date');
    
    //     return $dates->map(function($date) use ($pemasukan, $pengeluaran) {
    //         $pemasukanAmount = isset($pemasukan[$date]) ? (float)$pemasukan[$date]->pemasukan : 0;
    //         $pengeluaranAmount = isset($pengeluaran[$date]) ? (float)$pengeluaran[$date]->pengeluaran : 0;
            
    //         return [
    //             'date' => $date,
    //             'pemasukan' => $pemasukanAmount,
    //             'pengeluaran' => $pengeluaranAmount,
    //             'total' => $pemasukanAmount - $pengeluaranAmount
    //         ];
    //     })->values();
    // }
    
    private function getYearlyRevenueData()
    {
        // Get all months of the year
        $months = collect(range(1, 12));
        
        // Get pemasukan data
        $pemasukan = DB::table('pemasukan')
            ->select(
                DB::raw('MONTH(tgl_transaksi) as month'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereYear('tgl_transaksi', date('Y'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        // Get pengeluaran data
        $pengeluaran = DB::table('pengeluarans')
            ->select(
                DB::raw('MONTH(tanggal_transaksi) as month'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereYear('tanggal_transaksi', date('Y'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        // Combine data for all months
        return $months->map(function($month) use ($pemasukan, $pengeluaran) {
            $pemasukanAmount = isset($pemasukan[$month]) ? (float)$pemasukan[$month]->pemasukan : 0;
            $pengeluaranAmount = isset($pengeluaran[$month]) ? (float)$pengeluaran[$month]->pengeluaran : 0;
            
            return [
                'month' => (int)$month,
                'pemasukan' => $pemasukanAmount,
                'pengeluaran' => $pengeluaranAmount,
                'total' => $pemasukanAmount - $pengeluaranAmount
            ];
        })->values();
    }
    
    // private function getMonthlyRevenueData()
    // {
    //     // Get all days of current month
    //     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    //     $days = collect(range(1, $daysInMonth));
        
    //     // Get pemasukan data
    //     $pemasukan = DB::table('pemasukan')
    //         ->select(
    //             DB::raw('DAY(tgl_transaksi) as day'),
    //             DB::raw('SUM(jumlah) as pemasukan')
    //         )
    //         ->whereMonth('tgl_transaksi', date('m'))
    //         ->whereYear('tgl_transaksi', date('Y'))
    //         ->groupBy('day')
    //         ->get()
    //         ->keyBy('day');
    
    //     // Get pengeluaran data
    //     $pengeluaran = DB::table('pengeluarans')
    //         ->select(
    //             DB::raw('DAY(tanggal_transaksi) as day'),
    //             DB::raw('SUM(total_harga) as pengeluaran')
    //         )
    //         ->whereMonth('tanggal_transaksi', date('m'))
    //         ->whereYear('tanggal_transaksi', date('Y'))
    //         ->groupBy('day')
    //         ->get()
    //         ->keyBy('day');
    
    //     // Combine data for all days
    //     return $days->map(function($day) use ($pemasukan, $pengeluaran) {
    //         $pemasukanAmount = isset($pemasukan[$day]) ? (float)$pemasukan[$day]->pemasukan : 0;
    //         $pengeluaranAmount = isset($pengeluaran[$day]) ? (float)$pengeluaran[$day]->pengeluaran : 0;
            
    //         return [
    //             'day' => (int)$day,
    //             'pemasukan' => $pemasukanAmount,
    //             'pengeluaran' => $pengeluaranAmount,
    //             'total' => $pemasukanAmount - $pengeluaranAmount
    //         ];
    //     })->values();
    // }
    
    // private function getWeeklyRevenueData()
    // {
    //     // Get dates for last 7 days
    //     $dates = collect(range(0, 6))->map(function($day) {
    //         return date('Y-m-d', strtotime("-$day days"));
    //     })->reverse();
        
    //     // Get pemasukan data
    //     $pemasukan = DB::table('pemasukan')
    //         ->select(
    //             DB::raw('DATE(tgl_transaksi) as date'),
    //             DB::raw('SUM(jumlah) as pemasukan')
    //         )
    //         ->whereRaw('tgl_transaksi >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
    //         ->groupBy('date')
    //         ->get()
    //         ->keyBy('date');
    
    //     // Get pengeluaran data
    //     $pengeluaran = DB::table('pengeluarans')
    //         ->select(
    //             DB::raw('DATE(tanggal_transaksi) as date'),
    //             DB::raw('SUM(total_harga) as pengeluaran')
    //         )
    //         ->whereRaw('tanggal_transaksi >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
    //         ->groupBy('date')
    //         ->get()
    //         ->keyBy('date');
    
    //     // Combine data for all dates
    //     return $dates->map(function($date) use ($pemasukan, $pengeluaran) {
    //         $pemasukanAmount = isset($pemasukan[$date]) ? (float)$pemasukan[$date]->pemasukan : 0;
    //         $pengeluaranAmount = isset($pengeluaran[$date]) ? (float)$pengeluaran[$date]->pengeluaran : 0;
            
    //         return [
    //             'date' => $date,
    //             'pemasukan' => $pemasukanAmount,
    //             'pengeluaran' => $pengeluaranAmount,
    //             'total' => $pemasukanAmount - $pengeluaranAmount
    //         ];
    //     })->values();
    // }
    
    public function index()
    {
        $currentYear = date('Y');
    
        // Get monthly project data
        $projectData = DB::table('projects')
            ->selectRaw('MONTH(tgl_proyek) as month, COUNT(*) as total')
            ->whereYear('tgl_proyek', $currentYear)
            ->groupBy(DB::raw('MONTH(tgl_proyek)'))
            ->orderBy('month')
            ->get();
    
        // Get monthly revenue data
        // Get revenue data (monthly)
        $revenueData = DB::table('pemasukan')
            ->select(
                DB::raw('MONTH(tgl_transaksi) as month'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereYear('tgl_transaksi', date('Y'))
            ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
            ->get();
    
        // Get pengeluaran data
        $pengeluaranData = DB::table('pengeluarans')
            ->select(
                DB::raw('MONTH(tanggal_transaksi) as month'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereYear('tanggal_transaksi', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal_transaksi)'))
            ->get();
    
        // Combine the data
        $revenueData = $revenueData->map(function($item) use ($pengeluaranData) {
            $pengeluaran = $pengeluaranData->where('month', $item->month)->first();
            $pengeluaranAmount = $pengeluaran ? (float)$pengeluaran->pengeluaran : 0;
            return [
                'month' => (int)$item->month,
                'pemasukan' => (float)$item->pemasukan,
                'pengeluaran' => $pengeluaranAmount,
                'total' => (float)$item->pemasukan - $pengeluaranAmount
            ];
        });
    
        // Debug
        \Log::info('Revenue Data:', ['data' => $revenueData]);
    
        return view('dashboard', compact(
            'totalProyek',
            'totalPendapatan',
            'totalKlien',
            'proyekBerjalan',
            'projectData',
            'revenueData'
        ));
    }
}

