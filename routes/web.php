<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('guest')->name('login');



// Admin Routes
Route::group(['middleware' => ['auth','can:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pasien', [AdminController::class, 'pasienIndex'])->name('admin.pasien');
    Route::get('/admin/pasien/create', [AdminController::class, 'pasienCreate'])->name('admin.pasien.create');
    Route::get('/admin/biaya', [AdminController::class, 'biayaIndex'])->name('admin.biaya');
    Route::get('/admin/biaya/create', [AdminController::class, 'biayaCreate'])->name('admin.biaya.create');
    Route::get('/admin/jadwal', [AdminController::class, 'jadwalIndex'])->name('admin.jadwal');
});

// Super Admin Routes
Route::group(['middleware' => ['auth','can:superadmin']], function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/pasien', [SuperAdminController::class, 'pasienIndex'])->name('superadmin.pasien');
    Route::get('/superadmin/pasien/create', [SuperAdminController::class, 'pasienCreate'])->name('superadmin.pasien.create');
    Route::get('/superadmin/biaya', [SuperAdminController::class, 'biayaIndex'])->name('superadmin.biaya');
    Route::get('/superadmin/biaya/create', [SuperAdminController::class, 'biayaCreate'])->name('superadmin.biaya.create');
    Route::get('/superadmin/jadwal', [SuperAdminController::class, 'jadwalIndex'])->name('superadmin.jadwal');
    Route::get('/superadmin/jadwal/create', [SuperAdminController::class, 'jadwalCreate'])->name('superadmin.jadwal.create');
    Route::get('/superadmin/user/create', [SuperAdminController::class, 'createUser'])->name('superadmin.user.create');
});
