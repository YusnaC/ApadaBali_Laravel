<?php

use Illuminate\Support\Facades\Route;

//import controller
use App\Http\Controllers\proyekController;
use App\Http\Livewire\Login;
use App\Http\Livewire\Dashboard;  
use App\Http\Controllers\Auth\AuthenticatedSessionController;  
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\furnitureController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\pemasukanController;
use App\Http\Controllers\pengeluaranController;
use App\Http\Controllers\drafterController;
use App\Http\Controllers\klienController;
use App\Http\Controllers\laporanpemasukanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanProyekController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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

//login page access
Route::get('/', function () {
    return redirect()->route('login'); // Mengarahkan ke halaman login
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');  
Route::post('/login', [AuthenticatedSessionController::class, 'store']);  
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');  
//Login 
// Route::get('/projects/create', [proyekController::class, 'create'])->name('projects.store');
// Route::post('/projects', [proyekController::class, 'store'])->name('projects.store');
Route::post('/projects/store', [proyekController::class, 'store'])->name('proyek.store');

Route::get('/furniture', [FurnitureController::class, 'index'])->name('furniture.index');
Route::get('/furniture/create', [FurnitureController::class, 'create'])->name('furniture.create');
Route::post('/furniture', [FurnitureController::class, 'store'])->name('furniture.store');
Route::get('/furniture/{furniture}', [FurnitureController::class, 'show'])->name('furniture.show');
Route::get('/furniture/{furniture}/edit', [FurnitureController::class, 'edit'])->name('furniture.edit');
Route::put('/furniture/{furniture}', [FurnitureController::class, 'update'])->name('furniture.update');
Route::delete('/furniture/{furniture}', [FurnitureController::class, 'destroy'])->name('furniture.destroy');

Route::get('/proyek/progress', [proyekController::class, 'progressProyek'])->name('proyek.progress');

// Route::get('/Sign In', function () { //sign in (login)
//     return view('signin');
// });
//progresss
Route::get('/Progres-Proyek', [ProgresController::class, 'index'])->name('tables.progresproyek');
Route::get('/Tambah-Data-Progres', [ProgresController::class, 'create'])->name('progres.create');
Route::post('/progres', [ProgresController::class, 'store'])->name('progres.store');
Route::get('/detail-proyek/{id_proyek}', [ProgresController::class, 'show'])->name('progres.show');
Route::get('/progres/download/{id_proyek}', [ProgresController::class, 'download'])->name('progres.download');
// Route::get('/Tambah-Data-Progres', [ProgresController::class, 'create'])->name('progres.create');

// Keep these existing routes
Route::post('/progres', [ProgresController::class, 'store'])->name('progres.store');
Route::get('/progres/{id}', [ProgresController::class, 'show'])->name('progres.show');
Route::get('/progres/{id}/edit', [ProgresController::class, 'edit'])->name('progres.edit');
Route::put('/progres/{id}', [ProgresController::class, 'update'])->name('progres.update');
Route::delete('/progres/{id}', [ProgresController::class, 'destroy'])->name('progres.destroy');
//end progress
//this is for project  CRUD
Route::get('/Pencatatan-Proyek/{id}/edit', [proyekController::class, 'edit'])->name('proyek.edit');
Route::put('/Pencatatan-Proyek/{id}', [proyekController::class, 'update'])->name('proyek.update');
Route::delete('/Pencatatan-Proyek/{id}', [proyekController::class, 'destroy'])->name('proyek.destroy');
//end pproject CRUD

// ROUTES FOR ADMIN 
Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->middleware(['auth'])->name('dashboard.admin');  

Route::get('/Pencatatan-Proyek', [App\Http\Controllers\proyekController::class, 'proyek'])->name('tables.proyek'); //Tabel pencatatan proyek
Route::get('/Pencatatan-Furniture', [App\Http\Controllers\furnitureController::class, 'index'])->name('tables.furniture'); //Tabel pencatatan furniture
Route::get('/Data-Pengeluaran-Keuangan', [App\Http\Controllers\pengeluaranController::class, 'index'])->name('tables.pengeluaranKeuangan'); //Tabel pencatatan pengeluaran keuangan
Route::get('/Data-Pengeluaran-Keuangan', [pengeluaranController::class, 'index'])->name('tables.pengeluaranKeuangan');
Route::get('/Tambah-Data-Pengeluaran', [pengeluaranController::class, 'create'])->name('pengeluaran.create');
Route::post('/pengeluaran', [pengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/pengeluaran/{id}/edit', [pengeluaranController::class, 'edit'])->name('pengeluaran.edit');
Route::put('/pengeluaran/{id}', [pengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{id}', [pengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

// Route::get('/Data-Drafter', [App\Http\Controllers\drafterController::class, 'drafter'])->name('tables.drafter'); //Tabel data drafter
// Route::get('/Data-Klien', [App\Http\Controllers\klienController::class, 'klien'])->name('tables.klien'); //Tabel data klien
Route::get('/Laporan-Pemasukan-Keuangan', [App\Http\Controllers\laporanpemasukanController::class, 'laporanpemasukan'])->name('tables.laporanPemasukan'); //Tabel laporan pemasukan keuangan
Route::get('/Laporan-Pengeluaran-Keuangan', [App\Http\Controllers\laporanpengeluaranController::class, 'laporanpengeluaran'])->name('tables.laporanPengeluaran'); //Tabel laporan pengeluaran keuangan
Route::get('/Laporan-Proyek', [App\Http\Controllers\LaporanProyekController::class, 'laporanproyek'])->name('tables.laporanproyek'); //Tabel laporan proyek
Route::get('/Laporan-Furniture', [App\Http\Controllers\laporanfurnitureController::class, 'laporanfurniture'])->name('tables.laporanfurniture'); //Tabel laporan furniture
Route::get('/Tambah-Data-Proyek', [App\Http\Controllers\proyekController::class, 'create'])->name('proyek.create');
Route::get('/laporan-pemasukan/export', [laporanpemasukanController::class, 'export'])->name('pemasukan.export');
// Route::get('/Tambah-Data-Furniture', function () { //form tambah / edit data furniture
//     return view('furniture');
// });
Route::get('/Tambah-Data-Furniture', [App\Http\Controllers\furnitureController::class, 'create'])->name('furniture.create');

// Pemasukan Routes
Route::get('/Data-Pemasukan-Keuangan', [pemasukanController::class, 'index'])->name('tables.pemasukanKeuangan');
Route::get('/Tambah-Data-Pemasukan', [pemasukanController::class, 'create'])->name('pemasukan.create');
Route::post('/pemasukan', [pemasukanController::class, 'store'])->name('pemasukan.store');
Route::get('/pemasukan/{id}/edit', [pemasukanController::class, 'edit'])->name('pemasukan.edit');
Route::put('/pemasukan/{id}', [pemasukanController::class, 'update'])->name('pemasukan.update');
Route::delete('/pemasukan/{id}', [pemasukanController::class, 'destroy'])->name('pemasukan.destroy');
Route::get('/Tambah-Data-Pengeluaran', function () { //form tambah / edit data pengeluaran keuangan
    return view('pengeluaran');
});
Route::get('/Tambah-Data-Drafter', function () { //form tambah / edit data drafter oleh admin
    return view('dataDrafter'); 
});
Route::get('/Tambah-Data-Klien', function () { //form tambah / edit data klien oleh admin
    return view('dataKlien');
});
// Route::get('/Admin-Profile', function () { //form edit profile punya admin
//     return view('editProfile');
// });

Route::get('/Admin-Profile', [ProfileController::class, 'index'])->middleware('auth');

Route::get('/laporan-proyek/export', [App\Http\Controllers\LaporanProyekController::class, 'export'])->name('laporan.export');
// ROUTES FOR DRAFTER
Route::get('/dashboard-drafter', function () { //tampilan dashboard drafter
    return view('dashboarddrafter');
});
// Route::get('/Detail-Progres-Proyek', function () {
//     return view('detailProgres');
// });
Route::get('/Daftar-Proyek', [App\Http\Controllers\proyekdrafterController::class, 'proyekdrafter'])->name('tables.proyekdrafter'); //Tabel darftar Proyek
Route::get('/Progres-Proyek', [App\Http\Controllers\progresproyekController::class, 'progresproyek'])->name('tables.progresproyek'); //Tabel daftar progres
Route::get('/detailproyek/{id}', [proyekController::class, 'show'])->name('detailproyek'); //detail proyek
Route::get('/Drafter-Profile', function () { //form edit profile punya drafter
    return view('editprofiledrafter');
});
Route::get('/detail-proyek/{id_proyek}', [ProgresController::class, 'show'])->name('progres.show');
Route::get('/progres/download/{id_proyek}', [ProgresController::class, 'download'])->name('progres.download');
// Route::get('/Tambah-Data-Progres', function () { //form tambah / edit progres
//     return view('dataprogres');
// });

//this is for middleware
Route::group(['middleware' => ['auth', 'role:admin']], function () {  
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');  
});  
  
Route::group(['middleware' => ['auth', 'role:drafter']], function () {  
    Route::get('/drafter/dashboard', [DrafterController::class, 'index'])->name('drafter.dashboard');  
}); 

Route::get('/Data-Drafter', [DrafterController::class, 'index'])->name('tables.drafter');
Route::get('/Tambah-Data-Drafter', [DrafterController::class, 'create'])->name('drafter.create');
Route::post('/drafter', [DrafterController::class, 'store'])->name('drafter.store');
Route::get('/drafter/{id}/edit', [DrafterController::class, 'edit'])->name('drafter.edit');
Route::put('/drafter/{id}', [DrafterController::class, 'update'])->name('drafter.update');
Route::delete('/drafter/{id}', [DrafterController::class, 'destroy'])->name('drafter.destroy');

// Klien Routes
Route::get('/Data-Klien', [klienController::class, 'index'])->name('tables.klien');
Route::get('/Tambah-Data-Klien', [klienController::class, 'create'])->name('klien.create');
Route::post('/klien', [klienController::class, 'store'])->name('klien.store');
Route::get('/klien/{id}/edit', [klienController::class, 'edit'])->name('klien.edit');
Route::put('/klien/{id}', [klienController::class, 'update'])->name('klien.update');
Route::delete('/klien/{id}', [klienController::class, 'destroy'])->name('klien.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Import the controller
use App\Http\Controllers\progresproyekController;

// Progress Project Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/Progres-Proyek', [progresproyekController::class, 'index'])->name('tables.progresproyek');
    Route::get('/Tambah-Data-Progres', [progresproyekController::class, 'create'])->name('proyek.progress.create');
    Route::post('/progres-proyek', [progresproyekController::class, 'store'])->name('proyek.progress.store');
    Route::get('/progres-proyek/{id}/edit', [progresproyekController::class, 'edit'])->name('proyek.progress.edit');
    Route::put('/progres-proyek/{id}', [progresproyekController::class, 'update'])->name('proyek.progress.update');
    Route::delete('/progres-proyek/{id}', [progresproyekController::class, 'destroy'])->name('proyek.progress.destroy');
});
Route::get('/laporan/export-pdf', [LaporanPemasukanController::class, 'exportPDF'])->name('pemasukan.export.pdf');
Route::get('/laporan-proyek/export-pdf', [LaporanProyekController::class, 'exportPDF'])->name('proyek.export.pdf');
Route::get('/laporan-proyek/export', [LaporanProyekController::class, 'export'])->name('proyek.export');
Route::get('/api/get-latest-project-id', [proyekController::class, 'getLatestProjectId']);
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
// Remove these duplicate routes
// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');

// Route::get('/forgot-password', [App\Http\Livewire\ForgotPassword::class, '__invoke'])
//     ->middleware('guest')
//     ->name('password.request');

// Keep only these password reset routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

// Update the profile password route to use PUT method
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
use App\Http\Controllers\DashboardDrafterController;

// Fix the middleware namespace
Route::get('/dashboard-drafter', [DashboardDrafterController::class, 'index'])
    ->middleware(['auth'])  // Updated middleware
    ->name('dashboard.drafter');





