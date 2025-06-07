<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
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
        // Subquery untuk ambil progres terakhir per proyek
        $totalProyek = DB::table('progres')
        ->where('status_progres', 'Selesai')
        ->whereNull('deleted_at')
        ->count();

        // Total pendapatan
        $totalPemasukan = Pemasukan::whereNull('deleted_at')->sum('jumlah');
        $totalPengeluaran = Pengeluaran::whereNull('deleted_at')->sum('total_harga');
        $totalPendapatan = $totalPemasukan - $totalPengeluaran;
        // Total Klien
        $totalKlien = Klien::count();
        // Proyek Berjalan
        $proyekBerjalan = Progres::whereIn('id_progres', function($query) {
                            $query->selectRaw('MAX(id_progres)')
                                ->from('progres')
                                ->whereNull('deleted_at')
                                ->groupBy('id_proyek');
                        })
                        ->where('status_progres', 'Proses')
                        ->count();
    
        // Get project and revenue data based on filter
        switch($filter) {
            case 'week':
                // Get dates for the last 7 days
                $dates = collect(range(0, 6))
                    ->map(fn($day) => date('Y-m-d', strtotime("-$day days")))
                    ->reverse();

                $rawProjectData = Proyek::select(
                    DB::raw('DATE(tgl_proyek) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereRaw('DATE(tgl_proyek) >= ?', [date('Y-m-d', strtotime('-6 days'))])
                ->whereRaw('DATE(tgl_proyek) <= ?', [date('Y-m-d')])
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('DATE(tgl_proyek)'))
                ->orderBy('date')
                ->get()
                ->keyBy('date');

                $projectData = $dates->map(function($date) use ($rawProjectData) {
                    return [
                        'date' => $date,
                        'year' => date('Y', strtotime($date)),
                        'month' => (int)date('m', strtotime($date)),
                        'day' => (int)date('d', strtotime($date)),
                        'total' => $rawProjectData->get($date)?->total ?? 0
                    ];
                })->values()->toArray();
                
                $revenueData = $this->getWeeklyRevenueData();
                break;

            case 'year':
                // Get data for last 5 years
                $years = collect(range(date('Y')-4, date('Y')));
                
                $rawProjectData = Proyek::select(
                    DB::raw('YEAR(tgl_proyek) as year'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('tgl_proyek', '>=', date('Y')-4)
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('YEAR(tgl_proyek)'))
                ->orderBy('year')
                ->get()
                ->keyBy('year');

                $projectData = $years->map(function($year) use ($rawProjectData) {
                    return [
                        'year' => (int)$year,
                        'total' => $rawProjectData->get((string)$year)?->total ?? 0
                    ];
                })->values()->toArray();
                
                // Get yearly revenue data
                $pemasukan = DB::table('pemasukan')
                    ->whereNull('deleted_at')
                    ->select(
                        DB::raw('YEAR(tgl_transaksi) as year'),
                        DB::raw('SUM(jumlah) as pemasukan')
                    )
                    ->whereYear('tgl_transaksi', '>=', date('Y')-4)
                    ->groupBy(DB::raw('YEAR(tgl_transaksi)'))
                    ->orderBy('year')
                    ->get()
                    ->keyBy('year');

                $pengeluaran = DB::table('pengeluaran')
                    ->whereNull('deleted_at')
                    ->select(
                        DB::raw('YEAR(tanggal_transaksi) as year'),
                        DB::raw('SUM(total_harga) as pengeluaran')
                    )
                    ->whereYear('tanggal_transaksi', '>=', date('Y')-4)
                    ->groupBy(DB::raw('YEAR(tanggal_transaksi)'))
                    ->orderBy('year')
                    ->get()
                    ->keyBy('year');

                $revenueData = $years->map(function($year) use ($pemasukan, $pengeluaran) {
                    $yearStr = (string)$year;
                    $pemasukanAmount = isset($pemasukan[$yearStr]) ? (float)$pemasukan[$yearStr]->pemasukan : 0;
                    $pengeluaranAmount = isset($pengeluaran[$yearStr]) ? (float)$pengeluaran[$yearStr]->pengeluaran : 0;
                    
                    return [
                        'year' => (int)$year,
                        'pemasukan' => $pemasukanAmount,
                        'pengeluaran' => $pengeluaranAmount,
                        'total' => $pemasukanAmount - $pengeluaranAmount
                    ];
                })->values()->toArray();
                break;

            default: // month
                // Create array of all months (1-12)
                $months = collect(range(1, 12));
                $currentYear = date('Y');

                $rawProjectData = Proyek::select(
                    DB::raw('MONTH(tgl_proyek) as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('tgl_proyek', $currentYear)
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('MONTH(tgl_proyek)'))
                ->orderBy('month')
                ->get()
                ->keyBy('month');

                $projectData = $months->map(function($month) use ($rawProjectData, $currentYear) {
                    return [
                        'month' => (int)$month,
                        'year' => (int)$currentYear,
                        'total' => $rawProjectData->get($month)?->total ?? 0
                    ];
                });
                
                // Get monthly revenue data for all months
                $pemasukan = DB::table('pemasukan')
                    ->whereNull('deleted_at')
                    ->select(
                        DB::raw('MONTH(tgl_transaksi) as month'),
                        DB::raw('SUM(jumlah) as pemasukan')
                    )
                    ->whereYear('tgl_transaksi', $currentYear)
                    ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                    ->orderBy('month')
                    ->get()
                    ->keyBy('month');

                $pengeluaran = DB::table('pengeluaran')
                    ->whereNull('deleted_at')
                    ->select(
                        DB::raw('MONTH(tanggal_transaksi) as month'),
                        DB::raw('SUM(total_harga) as pengeluaran')
                    )
                    ->whereYear('tanggal_transaksi', $currentYear)
                    ->groupBy(DB::raw('MONTH(tanggal_transaksi)'))
                    ->orderBy('month')
                    ->get()
                    ->keyBy('month');

                $revenueData = $months->map(function($month) use ($pemasukan, $pengeluaran) {
                    $pemasukanAmount = isset($pemasukan[$month]) ? (float)$pemasukan[$month]->pemasukan : 0;
                    $pengeluaranAmount = isset($pengeluaran[$month]) ? (float)$pengeluaran[$month]->pengeluaran : 0;
                    
                    return [
                        'month' => (int)$month,
                        'pemasukan' => $pemasukanAmount,
                        'pengeluaran' => $pengeluaranAmount,
                        'total' => $pemasukanAmount - $pengeluaranAmount
                    ];
                })->values();
                break;
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                $days = collect(range(1, $daysInMonth));
                $currentYear = date('Y');
                $currentMonth = date('m');

                $rawProjectData = Proyek::select(
                    DB::raw('DAY(tgl_proyek) as day'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereMonth('tgl_proyek', $currentMonth)
                ->whereYear('tgl_proyek', $currentYear)
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

                $projectData = $days->map(function($day) use ($rawProjectData, $currentYear, $currentMonth) {
                    return [
                        'day' => (int)$day,
                        'month' => (int)$currentMonth,
                        'year' => (int)$currentYear,
                        'total' => $rawProjectData->get($day)?->total ?? 0
                    ];
                });
                
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
        // Get dates for the last 7 days
        $dates = collect(range(0, 6))
            ->map(fn($day) => date('Y-m-d', strtotime("-$day days")))
            ->reverse();

        $pemasukan = DB::table('pemasukan')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('DATE(tgl_transaksi) as date'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereRaw('DATE(tgl_transaksi) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)')
            ->whereRaw('DATE(tgl_transaksi) <= CURDATE()')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $pengeluaran = DB::table('pengeluaran')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('DATE(tanggal_transaksi) as date'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereRaw('DATE(tanggal_transaksi) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)')
            ->whereRaw('DATE(tanggal_transaksi) <= CURDATE()')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        return $dates->map(function($date) use ($pemasukan, $pengeluaran) {
            $pemasukanAmount = isset($pemasukan[$date]) ? (float)$pemasukan[$date]->pemasukan : 0;
            $pengeluaranAmount = isset($pengeluaran[$date]) ? (float)$pengeluaran[$date]->pengeluaran : 0;
            
            return [
                'date' => $date,
                'year' => date('Y', strtotime($date)),
                'month' => (int)date('m', strtotime($date)),
                'day' => (int)date('d', strtotime($date)),
                'pemasukan' => $pemasukanAmount,
                'pengeluaran' => $pengeluaranAmount,
                'total' => $pemasukanAmount - $pengeluaranAmount
            ];
        })->values();
    }
    
    private function getMonthlyRevenueData()
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $days = collect(range(1, $daysInMonth));
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        $pemasukan = DB::table('pemasukan')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('DAY(tgl_transaksi) as day'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereMonth('tgl_transaksi', $currentMonth)
            ->whereYear('tgl_transaksi', $currentYear)
            ->groupBy('day')
            ->get()
            ->keyBy('day');
    
        $pengeluaran = DB::table('pengeluaran')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('DAY(tanggal_transaksi) as day'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereMonth('tanggal_transaksi', $currentMonth)
            ->whereYear('tanggal_transaksi', $currentYear)
            ->groupBy('day')
            ->get()
            ->keyBy('day');
    
        return $days->map(function($day) use ($pemasukan, $pengeluaran, $currentYear, $currentMonth) {
            $pemasukanAmount = isset($pemasukan[$day]) ? (float)$pemasukan[$day]->pemasukan : 0;
            $pengeluaranAmount = isset($pengeluaran[$day]) ? (float)$pengeluaran[$day]->pengeluaran : 0;
            
            return [
                'day' => (int)$day,
                'month' => (int)$currentMonth,
                'year' => (int)$currentYear,
                'pemasukan' => $pemasukanAmount,
                'pengeluaran' => $pengeluaranAmount,
                'total' => $pemasukanAmount - $pengeluaranAmount
            ];
        })->values();
    }

    private function getYearlyRevenueData()
    {
        $months = collect(range(1, 12));
        $currentYear = date('Y');
        
        $pemasukan = DB::table('pemasukan')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('MONTH(tgl_transaksi) as month'),
                DB::raw('SUM(jumlah) as pemasukan')
            )
            ->whereYear('tgl_transaksi', $currentYear)
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        $pengeluaran = DB::table('pengeluaran')
            ->whereNull('deleted_at')
            ->select(
                DB::raw('MONTH(tanggal_transaksi) as month'),
                DB::raw('SUM(total_harga) as pengeluaran')
            )
            ->whereYear('tanggal_transaksi', $currentYear)
            ->groupBy('month')
            ->get()
            ->keyBy('month');
    
        return $months->map(function($month) use ($pemasukan, $pengeluaran, $currentYear) {
            $pemasukanAmount = isset($pemasukan[$month]) ? (float)$pemasukan[$month]->pemasukan : 0;
            $pengeluaranAmount = isset($pengeluaran[$month]) ? (float)$pengeluaran[$month]->pengeluaran : 0;
            
            return [
                'month' => (int)$month,
                'year' => (int)$currentYear,
                'pemasukan' => $pemasukanAmount,
                'pengeluaran' => $pengeluaranAmount,
                'total' => $pemasukanAmount - $pengeluaranAmount
            ];
        })->values();
    }
    
    public function index()
    {
        $currentYear = date('Y');
    
        // Get monthly project data
        $projectData = DB::table('proyek')
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
        $pengeluaranData = DB::table('pengeluaran')
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

