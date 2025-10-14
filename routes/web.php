<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PageController; // Import Controller Anda

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Definisikan semua rute web aplikasi Anda di sini.
|
*/

// Rute Home
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


// Rute untuk Bidang (Menggunakan Resource Controller)
// Ini menghasilkan route 'bidangs.index'
Route::resource('bidangs', BidangController::class);

// Rute untuk Pelatihan (Definisi manual)
// Ini menghasilkan route 'pelatihan.index'
Route::get('/pelatihan', [PelatihanController::class, 'index'])->name('pelatihan.index');

Route::get('/import', [ImportController::class, 'index'])->name('import.index');
Route::post('/import-users', [ImportController::class, 'import'])->name('import.users');


// Rute Navbar Lainnya
Route::get('/profil', [PageController::class, 'profil'])->name('profil');
Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur');


Route::get('/input-data', [InputDataController::class, 'index'])->name('inputdata.index');
Route::post('/input-data', [InputDataController::class, 'store'])->name('inputdata.store');
Route::post('/input-data/bidang', [InputDataController::class, 'storeBidang'])->name('inputdata.storeBidang');
Route::post('/input-data/indikator', [InputDataController::class, 'storeIndikator'])->name('inputdata.storeIndikator');

// --- GRUP RUTE ADMINISTRASI DATA MASTER ---
// Rute ini otomatis membuat CRUD routes (index, create, store, show, edit, update, destroy)

// Manajemen Bidang (Resource Controller)
Route::resource('bidangs', BidangController::class);

// Manajemen Indikator (Resource Controller)
Route::resource('indikators', IndikatorController::class);





// --- GRUP RUTE SISTEM PENILAIAN ---

// Route::prefix('penilaian')->name('penilaian.')->group(function () {
//     // Menampilkan daftar pegawai yang akan dinilai
//     Route::get('/', [PenilaianController::class, 'index'])->name('index');
    
//     // Menampilkan form penilaian untuk pegawai tertentu
//     Route::get('/{pegawai}/create', [PenilaianController::class, 'createAssessment'])->name('create');
    
//     // Menyimpan atau memperbarui nilai
//     Route::post('/{pegawai}', [PenilaianController::class, 'storeAssessment'])->name('store');
// });
