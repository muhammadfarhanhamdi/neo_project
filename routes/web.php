<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AlumniTrackingController;
use App\Models\Lowongan;

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
    $latestLowongans = Lowongan::latest()->take(3)->withCount('applications')->get();
    return view('welcome', compact('latestLowongans'));
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/bantuan/password', 'help.password')->name('help.password');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/pelamar/dashboard', [DashboardController::class, 'pelamar'])->name('pelamar.dashboard');
    Route::get('/perusahaan/dashboard', [DashboardController::class, 'perusahaan'])->name('perusahaan.dashboard');
    Route::get('/pesan', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/pesan', [MessageController::class, 'store'])->name('messages.store');
    
    // pelamar profile
    Route::get('/pelamar/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('pelamar.profile.edit');
    Route::post('/pelamar/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('pelamar.profile.update');
    Route::get('/pelamar/riwayat', [App\Http\Controllers\DashboardController::class, 'pelamarHistory'])->name('pelamar.riwayat');

    // perusahaan profile
    Route::get('/perusahaan/profile', [App\Http\Controllers\ProfileController::class, 'companyEdit'])->name('perusahaan.profile.edit');
    Route::post('/perusahaan/profile', [App\Http\Controllers\ProfileController::class, 'companyUpdate'])->name('perusahaan.profile.update');
});

Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->whereNumber('id')->name('lowongan.show');

Route::middleware('auth')->group(function () {
    Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
    Route::post('/lowongan/{id}/apply', [ApplicationController::class, 'store'])->whereNumber('id')->name('lowongan.apply');
    Route::post('/lowongan/{id}/save', [LowonganController::class, 'save'])->whereNumber('id')->name('lowongan.save');
    Route::delete('/lowongan/{id}/unsave', [LowonganController::class, 'unsave'])->whereNumber('id')->name('lowongan.unsave');
    Route::get('/pelamar/disimpan', [LowonganController::class, 'saved'])->name('pelamar.saved');
    // company updates application status
    Route::post('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->whereNumber('id')->name('applications.updateStatus');
    // perusahaan-specific pages
    Route::get('/perusahaan/lowongans', [App\Http\Controllers\DashboardController::class, 'lowongansSaya'])->name('perusahaan.lowongans');
    Route::get('/perusahaan/pelamar', [App\Http\Controllers\DashboardController::class, 'pelamarForCompany'])->name('perusahaan.pelamar');
    Route::get('/perusahaan/pelamar/{id}', [App\Http\Controllers\DashboardController::class, 'showPelamarForCompany'])->whereNumber('id')->name('perusahaan.pelamar.show');
    Route::get('/perusahaan/lowongan/{id}', [App\Http\Controllers\DashboardController::class, 'showLowonganForCompany'])->whereNumber('id')->name('perusahaan.lowongan.show');

    // admin alumni tracking
    Route::get('/admin/dashboard', [AlumniTrackingController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/alumni-tracking', [AlumniTrackingController::class, 'index'])->name('admin.alumni.index');
    Route::get('/admin/alumni-tracking/export/pdf', [AlumniTrackingController::class, 'export'])->name('admin.alumni.export');
    Route::get('/admin/alumni-tracking/export/excel', [AlumniTrackingController::class, 'exportExcel'])->name('admin.alumni.export.excel');
    // admin user management (edit basic profile fields)
    Route::get('/admin/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->whereNumber('id')->name('admin.users.edit');
    Route::post('/admin/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->whereNumber('id')->name('admin.users.update');
    // view single alumni detail
    Route::get('/admin/alumni/{id}', [AlumniTrackingController::class, 'show'])->whereNumber('id')->name('admin.alumni.show');
});
