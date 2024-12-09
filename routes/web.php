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


Route::get('/', function () {
    return view('dashboard');
});
Route::get('/Tambah-Data-Proyek', function () {
    return view('proyek');
});
Route::get('/Ubah-Data-Proyek', function () {
    return view('editProyek');
});
Route::get('/Tambah-Data-Furniture', function () {
    return view('furniture');
});
Route::get('/Ubah-Data-Furniture', function () {
    return view('editFurniture');
});
Route::get('/Tambah-Data-Pemasukan', function () {
    return view('pemasukan');
});
Route::get('/Ubah-Data-Pemasukan', function () {
    return view('editPemasukan');
});
Route::get('/Tambah-Data-Pengeluaran', function () {
    return view('pengeluaran');
});
Route::get('/Ubah-Data-Pengeluaran', function () {
    return view('editPengeluaran');
});
Route::get('/Tambah-Data-Drafter', function () {
    return view('dataDrafter');
});
Route::get('/Tambah-Data-Klien', function () {
    return view('dataKlien');
});
Route::get('/Ubah-Data-Klien', function () {
    return view('editKlien');
});
Route::get('/Profile', function () {
    return view('editProfile');
});
Route::get('/Detail-Progres-Proyek', function () {
    return view('detailProgres');
});

Route::get('/Pencatatan-Proyek', [App\Http\Controllers\ProjectController::class, 'index'])->name('tables.index');

//untuk logout, untuk login cara sama cuman berbeda behavior
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');








