<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google_callback');

// All Logged in user
Route::middleware('auth')->group(function () {
    Route::post('/user/change-password/{id}', [UserController::class, 'changePassword'])->name('user.change_password');
});

// User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'userHome'])->name('user_home');
    Route::get('/daftar', [KandidatController::class, 'create'])->name('daftar_kandidat_form');
    Route::post('/daftar', [KandidatController::class, 'store'])->name('daftar_kandidat_post');
    Route::post('/vote/{idKandidat}', [KandidatController::class, 'vote'])->name('vote_kandidat');
});

// Panitia
Route::middleware(['auth', 'role:panitia,master'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'panitiaHome'])->name('panitia_home');
    Route::resource('/pemilih', PemilihController::class);
    Route::delete('/delete-selected/pemilih', [PemilihController::class, 'deleteSelected'])->name('pemilih.delete_selected');
    Route::post('/pemilih/import', [PemilihController::class, 'importPemilih'])->name('pemilih.import');
    Route::get('/template-download', [PanitiaController::class, 'downloadTemplatePemilih'])->name('panitia.download_template_pemilih');
    Route::resource('/kandidat', KandidatController::class)->only(['index', 'destroy', 'show']);
    Route::get('/kandidat/kelengkapan/{idKandidat}/{kelengkapan}', [KandidatController::class, 'cekKelengkapan'])->name('kandidat.cek_kelengkapan');
    Route::get('/kandidat/kelengkapan/{idKandidat}/{kelengkapan}/download', [KandidatController::class, 'downloadKelengkapan'])->name('kandidat.download_kelengkapan');
    Route::post('/kandidat/verifikasi/{idKandidat}', [KandidatController::class, 'verifikasiData'])->name('kandidat.verifikasi_data');
    Route::get('/pengaturan', [PanitiaController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan', [PanitiaController::class, 'pengaturanPost'])->name('pengaturan_post');
    Route::get('/status-pemilihan', [PanitiaController::class, 'statusPemilihan'])->name('status_pemilihan');
    Route::get('/get-data-pemilihan', [PanitiaController::class, 'getDataPemilihan'])->name('get_data_pemilihan');
    Route::get('/kirim-email/{id}', [PanitiaController::class, 'kirimEmail'])->name('kirim_email_user');
    Route::get('/kirim-email-all', [PanitiaController::class, 'kirimEmailAll'])->name('kirim_email_all');
});

// Master
Route::middleware(['auth', 'role:master'])->group(function () {
    Route::get('/dashboard/master', [HomeController::class, 'masterHome'])->name('master_home');
    Route::resource('/panitia', PanitiaController::class);
    Route::delete('/delete-selected/panitia', [PanitiaController::class, 'deleteSelected'])->name('panitia.delete_selected');
    Route::resource('/user', UserController::class);
    Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.reset_password');
});
