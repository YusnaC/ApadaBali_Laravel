<?php

use Illuminate\Support\Facades\Route;

//import controller
use App\Http\Controllers\ProjectController;
use App\Http\Livewire\Login;
use App\Http\Livewire\Dashboard;  
use App\Http\Controllers\Auth\AuthenticatedSessionController;  
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\furnitureController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

// ROUTE LOGIN & SIGNUP
//untuk logout, untuk login cara sama cuman berbeda behavior
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/Sign In', function () { //sign in (login)
    return view('signin');
});

// ROUTES FOR ADMIN 
Route::get('/dashboard-admin', function () { //tampilan dashboard admin
    return view('dashboard');
});
Route::get('/Pencatatan-Proyek', [App\Http\Controllers\proyekController::class, 'proyek'])->name('tables.proyek'); //Tabel pencatatan proyek
Route::get('/Pencatatan-Furniture', [App\Http\Controllers\furnitureController::class, 'furniture'])->name('tables.furniture'); //Tabel pencatatan furniture
Route::get('/Data-Pemasukan-Keuangan', [App\Http\Controllers\pemasukanController::class, 'pemasukan'])->name('tables.pemasukanKeuangan'); //Tabel pencatatan pemasukan keuangan
Route::get('/Data-Pengeluaran-Keuangan', [App\Http\Controllers\pengeluaranController::class, 'pengeluaran'])->name('tables.pengeluaranKeuangan'); //Tabel pencatatan pengeluaran keuangan
Route::get('/Data-Drafter', [App\Http\Controllers\drafterController::class, 'drafter'])->name('tables.drafter'); //Tabel data drafter
Route::get('/Data-Klien', [App\Http\Controllers\klienController::class, 'klien'])->name('tables.klien'); //Tabel data klien
Route::get('/Laporan-Pemasukan-Keuangan', [App\Http\Controllers\laporanpemasukanController::class, 'laporanpemasukan'])->name('tables.laporanPemasukan'); //Tabel laporan pemasukan keuangan
Route::get('/Laporan-Pengeluaran-Keuangan', [App\Http\Controllers\laporanpengeluaranController::class, 'laporanpengeluaran'])->name('tables.laporanPengeluaran'); //Tabel laporan pengeluaran keuangan
Route::get('/Laporan-Proyek', [App\Http\Controllers\laporanproyekController::class, 'laporanproyek'])->name('tables.laporanproyek'); //Tabel laporan proyek
Route::get('/Laporan-Furniture', [App\Http\Controllers\laporanfurnitureController::class, 'laporanfurniture'])->name('tables.laporanfurniture'); //Tabel laporan furniture
Route::get('/Tambah-Data-Proyek', function () { //form tambah / edit data proyek
    return view('proyek');
});
Route::get('/Tambah-Data-Furniture', function () { //form tambah / edit data furniture
    return view('furniture');
});
Route::get('/Tambah-Data-Pemasukan', function () { //form tambah / edit data pemasukan keuangan
    return view('pemasukan');
});
Route::get('/Tambah-Data-Pengeluaran', function () { //form tambah / edit data pengeluaran keuangan
    return view('pengeluaran');
});
Route::get('/Tambah-Data-Drafter', function () { //form tambah / edit data drafter oleh admin
    return view('dataDrafter'); 
});
Route::get('/Tambah-Data-Klien', function () { //form tambah / edit data klien oleh admin
    return view('dataKlien');
});
Route::get('/Admin-Profile', function () { //form edit profile punya admin
    return view('editProfile');
});

// ROUTES FOR DRAFTER
Route::get('/dashboard-drafter', function () { //tampilan dashboard drafter
    return view('dashboarddrafter');
});
// Route::get('/Detail-Progres-Proyek', function () {
//     return view('detailProgres');
// });
Route::get('/Daftar-Proyek', [App\Http\Controllers\proyekdrafterController::class, 'proyekdrafter'])->name('tables.proyekdrafter'); //Tabel darftar Proyek
Route::get('/Progres-Proyek', [App\Http\Controllers\progresproyekController::class, 'progresproyek'])->name('tables.progresproyek'); //Tabel daftar progres
Route::get('/Drafter-Profile', function () { //form edit profile punya drafter
    return view('editprofiledrafter');
});
Route::get('/Tambah-Data-Progres', function () { //form tambah / edit progres
    return view('dataprogres');
});








