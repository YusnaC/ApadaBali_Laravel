<?php

use Illuminate\Support\Facades\Route;

//import controller
use App\Http\Controllers\ProjectController;
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

// ROUTE ADMIN
Route::get('/dashboard-admin', function () { //tampilan dashboard admin
    return view('dashboard');
});

Route::get('/Pencatatan-Proyek', [App\Http\Controllers\projectController::class, 'proyek'])->name('tables.proyek'); //Data pencatatan proyek
Route::get('/Pencatatan-Furniture', [App\Http\Controllers\furnitureController::class, 'furniture'])->name('tables.furniture'); //Data pencatatan furniture
Route::get('/Data-Pemasukan-Keuangan', [App\Http\Controllers\pemasukanController::class, 'pemasukan'])->name('tables.pemasukanKeuangan'); //Data pencatatan pemasukan keuangan
Route::get('/Data-Pengeluaran-Keuangan', [App\Http\Controllers\pengeluaranController::class, 'pengeluaran'])->name('tables.pengeluaranKeuangan'); //Data pencatatan pengeluaran keuangan
Route::get('/Data-Drafter', [App\Http\Controllers\drafterController::class, 'drafter'])->name('tables.drafter'); //Data drafter
Route::get('/Data-Klien', [App\Http\Controllers\klienController::class, 'klien'])->name('tables.klien'); //Data klien
Route::get('/Laporan-Pemasukan-Keuangan', [App\Http\Controllers\laporanpemasukanController::class, 'laporanpemasukan'])->name('tables.laporanPemasukan'); //Data laporan pemasukan keuangan
Route::get('/Laporan-Pengeluaran-Keuangan', [App\Http\Controllers\laporanpengeluaranController::class, 'laporanpengeluaran'])->name('tables.laporanPengeluaran'); //Data laporan pengeluaran keuangan
Route::get('/Laporan-Proyek', [App\Http\Controllers\laporanproyekController::class, 'laporanproyek'])->name('tables.laporanproyek'); //Data laporan proyek
Route::get('/Laporan-Furniture', [App\Http\Controllers\laporanfurnitureController::class, 'laporanfurniture'])->name('tables.laporanfurniture'); //Data laporan furniture

// bagian tambah - edit
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
Route::get('/Admin-Profile', function () { //form edit profile admin
    return view('editProfile');
});

// ROUTE DRAFTER
Route::get('/dashboard-drafter', function () { //tampilan dashboard drafter
    return view('dashboarddrafter');
});
// Route::get('/Detail-Progres-Proyek', function () {
//     return view('detailProgres');
// });
Route::get('/Daftar-Proyek', [App\Http\Controllers\proyekdrafterController::class, 'proyekdrafter'])->name('tables.proyekdrafter'); //Daftar Proyek
Route::get('/Progres-Proyek', [App\Http\Controllers\progresproyekController::class, 'progresproyek'])->name('tables.progresproyek'); //Daftar Proyek
Route::get('/Drafter-Profile', function () { //form edit profile drafter
    return view('editprofiledrafter');
});
Route::get('/Tambah-Data-Progres', function () { //form tambah / edit progres
    return view('dataprogres');
});

// ROUTE LOGIN & SIGNUP

//untuk logout, untuk login cara sama cuman berbeda behavior
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/Sign In', function () {
    return view('signin');
});







