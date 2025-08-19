<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RiwayatEventController;

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
    Route::post('/update-jumlah-peserta', [DashboardController::class, 'updateJumlahPeserta'])->name('updateJumlahPeserta');

    // kriteria
    Route::get('/bobot', [KriteriaController::class, 'indexBobot']);
    Route::put('/bobot-update/{id}', [KriteriaController::class, 'updateBobot'])->name('bobot.update');
    Route::get('/nilai', [KriteriaController::class, 'indexNilai']);
    Route::get('/wiraga', [KriteriaController::class, 'indexWiraga']);

    // peserta
    Route::get('/peserta', [PesertaController::class, 'index']);
    Route::post('/peserta-store', [PesertaController::class, 'store'])->name('createPeserta');
    Route::put('/peserta-update/{id}', [PesertaController::class, 'update'])->name('updatePeserta');
    Route::get('/peserta-delete/{id}', [PesertaController::class, 'delete'])->name('deletePeserta');

    // hasil perhitungan
    Route::get('/data-alternatif', [PerhitunganController::class, 'indexAlternatif']);
    Route::get('/refresh-ranking', [PerhitunganController::class, 'refreshRanking'])->name('refreshRanking');
    Route::get('/data-ranking', [PerhitunganController::class, 'indexRanking']);

    // event
    Route::get('/tambah-event', [EventController::class, 'tambahEvent'])->name('tambah-event');
    Route::post('/event-store', [EventController::class, 'store'])->name('createEvent');
    Route::put('/event-update/{id}', [EventController::class, 'update'])->name('updateEvent');
    Route::get('/event-delete/{id}', [EventController::class, 'delete'])->name('deleteEvent');
    Route::get('/lihat-event', [EventController::class, 'lihatEvent'])->name('lihat-event');
    Route::put('/event/update-peserta', [EventController::class, 'updatePesertaEvent'])->name('updatePesertaEvent');
    Route::get('/event/{id}/mark-completed', [EventController::class, 'markAsCompleted'])->name('markEventCompleted');

    // riwayat event
    Route::get('/riwayat-event', [RiwayatEventController::class, 'index'])->name('riwayat-event.index');
});
