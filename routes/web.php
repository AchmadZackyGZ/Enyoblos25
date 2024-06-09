<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


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
    Route::get('/daftar', [CandidatController::class, 'create'])->name('daftar_kandidat_form');
    Route::post('/daftar', [CandidatController::class, 'store'])->name('daftar_kandidat_post');
    Route::post('/vote/{idKandidat}', [CandidatController::class, 'vote'])->name('vote_kandidat');
});

// Panitia
Route::middleware(['auth', 'role:panitia,master'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'panitiaHome'])->name('panitia_home');
    Route::resource('/pemilih', VoterController::class);
    Route::delete('/delete-selected/pemilih', [VoterController::class, 'deleteSelected'])->name('pemilih.delete_selected');
    Route::post('/pemilih/import', [VoterController::class, 'importPemilih'])->name('pemilih.import');
    Route::get('/template-download', [CommitteeController::class, 'downloadTemplatePemilih'])->name('panitia.download_template_pemilih');
    Route::resource('/kandidat', CandidatController::class);
    Route::get('/kandidat/kelengkapan/{idKandidat}/{kelengkapan}', [CandidatController::class, 'cekKelengkapan'])->name('kandidat.cek_kelengkapan');
    Route::get('/kandidat/kelengkapan/{idKandidat}/{kelengkapan}/download', [CandidatController::class, 'downloadKelengkapan'])->name('kandidat.download_kelengkapan');
    Route::post('/kandidat/verifikasi/{idKandidat}', [CandidatController::class, 'verifikasiData'])->name('kandidat.verifikasi_data');
    Route::get('/pengaturan', [CommitteeController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan', [CommitteeController::class, 'pengaturanPost'])->name('pengaturan_post');
    Route::get('/status-pemilihan', [CommitteeController::class, 'statusPemilihan'])->name('status_pemilihan');
    Route::get('/get-data-pemilihan', [CommitteeController::class, 'getDataPemilihan'])->name('get_data_pemilihan');
    Route::get('/kirim-email/{id}', [CommitteeController::class, 'kirimEmail'])->name('kirim_email_user');
    Route::get('/kirim-email-all', [CommitteeController::class, 'kirimEmailAll'])->name('kirim_email_all');
});

// Master
Route::middleware(['auth', 'role:master'])->group(function () {
    Route::get('/dashboard/master', [HomeController::class, 'masterHome'])->name('master_home');
    Route::resource('/panitia', CommitteeController::class)->only(['index', 'store']);
    Route::delete('/delete-selected/panitia', [CommitteeController::class, 'deleteSelected'])->name('panitia.delete_selected');
    Route::resource('/user', UserController::class);
    Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.reset_password');
});
