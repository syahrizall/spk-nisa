<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PerhitunganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/calculation', [HomeController::class, 'index']);

Route::get('/kriteria', function () {
    return view('kriteria');
});

// Route untuk login
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    ///dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/update-jumlah-penerima', [DashboardController::class, 'updateJumlahPenerima'])->name('updateJumlahPenerima');

    // kriteria
    Route::get('/bobot', [KriteriaController::class, 'indexBobot']);
    Route::put('/bobot-update/{id}', [KriteriaController::class, 'updateBobot'])->name('bobot.update');
    Route::get('/nilai', [KriteriaController::class, 'indexNilai']);
    Route::get('/wiraga', [KriteriaController::class, 'indexWiraga']);

    // pegawai
    Route::get('/penerima', [PenerimaController::class, 'index']);
    Route::post('/penerima-store', [PenerimaController::class, 'store'])->name('createPenerima');
    Route::put('/penerima-update/{id}', [PenerimaController::class, 'update'])->name('updatePenerima');
    Route::get('/penerima-delete/{id}', [PenerimaController::class, 'delete'])->name('deletePenerima');

    // hasil perhitungan
    Route::get('/data-alternatif', [PerhitunganController::class, 'indexAlternatif']);
    Route::get('/refresh-ranking', [PerhitunganController::class, 'refreshRanking'])->name('refreshRanking');
    Route::get('/data-ranking', [PerhitunganController::class, 'indexRanking']);
});
