<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/grafik/{month}/{year}', [PasienController::class, 'showGrafik']);
Route::get('/jadwal', [JadwalController::class, 'indexDash'])->name('jadwal');

// Admin Routes
Route::group(['middleware' => ['auth','can:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/pasien', [AdminController::class, 'pasienIndex'])->name('admin.pasien');
    Route::get('/admin/pasien/create', [AdminController::class, 'pasienCreate'])->name('admin.pasien.create');
    Route::post('/admin/pasien/store', [PasienController::class, 'store'])->name('admin.pasien.store');
    Route::get('/admin/pasien/{id}/edit', [PasienController::class, 'edit'])->name('admin.pasien.edit');
    Route::put('/admin/pasien/{id}', [PasienController::class, 'update'])->name('admin.pasien.update');
    Route::delete('/admin/pasien/{id}', [PasienController::class, 'destroy'])->name('admin.pasien.destroy');

    Route::get('/admin/biaya', [AdminController::class, 'biayaIndex'])->name('admin.biaya');
    Route::get('/admin/biaya/create', [AdminController::class, 'biayaCreate'])->name('admin.biaya.create');
    Route::post('/admin/biaya/store', [BiayaController::class, 'store'])->name('admin.biaya.store');
    Route::get('/admin/biaya/{id}/edit', [BiayaController::class, 'edit'])->name('admin.biaya.edit');
    Route::put('/admin/biaya/{id}', [BiayaController::class, 'update'])->name('admin.biaya.update');
    Route::delete('/admin/biaya/{id}', [BiayaController::class, 'destroy'])->name('admin.biaya.destroy');

    Route::get('/admin/jadwal', [AdminController::class, 'jadwalIndex'])->name('admin.jadwal');
});

// Super Admin Routes
Route::group(['middleware' => ['auth','can:superadmin']], function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    Route::get('/superadmin/pasien', [SuperAdminController::class, 'pasienIndex'])->name('superadmin.pasien');
    Route::get('/superadmin/pasien/create', [SuperAdminController::class, 'pasienCreate'])->name('superadmin.pasien.create');
    Route::post('/superadmin/pasien/store', [PasienController::class, 'storeSuper'])->name('superadmin.pasien.store');
    Route::get('/superadmin/pasien/{id}/edit', [PasienController::class, 'editSuper'])->name('superadmin.pasien.edit');
    Route::put('/superadmin/pasien/{id}', [PasienController::class, 'updateSuper'])->name('superadmin.pasien.update');
    Route::delete('/superadmin/pasien/{id}', [PasienController::class, 'destroySuper'])->name('superadmin.pasien.destroy');
    Route::get('/superadmin/pasien/export', [PasienController::class, 'export'])->name('superadmin.pasien.export');
    Route::get('/superadmin/pasien/index', [PasienController::class, 'index'])->name('superadmin.pasien.index');

    Route::get('/superadmin/biaya', [SuperAdminController::class, 'biayaIndex'])->name('superadmin.biaya');
    Route::get('/superadmin/biaya/create', [SuperAdminController::class, 'biayaCreate'])->name('superadmin.biaya.create');
    Route::post('/superadmin/biaya/store', [BiayaController::class, 'storeSuper'])->name('superadmin.biaya.store');
    Route::get('/superadmin/biaya/{id}/edit', [BiayaController::class, 'editSuper'])->name('superadmin.biaya.edit');
    Route::put('/superadmin/biaya/{id}', [BiayaController::class, 'updateSuper'])->name('superadmin.biaya.update');
    Route::delete('/superadmin/biaya/{id}', [BiayaController::class, 'destroySuper'])->name('superadmin.biaya.destroy');
    Route::get('/superadmin/biaya/export', [BiayaController::class, 'exportExcel'])->name('superadmin.biaya.export');
    Route::get('/superadmin/biaya/index', [BiayaController::class, 'indexSuper'])->name('superadmin.biaya.index');

    Route::get('/superadmin/jadwal', [SuperAdminController::class, 'jadwalIndex'])->name('superadmin.jadwal');
    Route::get('/superadmin/jadwal/create', [SuperAdminController::class, 'jadwalCreate'])->name('superadmin.jadwal.create');
    Route::post('/superadmin/jadwal/store', [JadwalController::class, 'storeJadwal'])->name('superadmin.jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('superadmin.jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('superadmin.jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('superadmin.jadwal.destroy');
    Route::get('/superadmin/jadwal/export', [JadwalController::class, 'exportExcel'])->name('superadmin.jadwal.export');
    Route::get('/superadmin/jadwal/index', [JadwalController::class, 'indexSuper'])->name('superadmin.jadwal.index');

    Route::get('/superadmin/user/create', [SuperAdminController::class, 'createUser'])->name('superadmin.user.create');
    Route::get('/superadmin/user', [SuperAdminController::class, 'userIndex'])->name('superadmin.userIndex');
    Route::put('/superadmin/user/{user}/role', [SuperAdminController::class, 'updateUserRole'])->name('superadmin.updateRole');
    Route::post('/superadmin/user/store', [SuperAdminController::class, 'storeUser'])->name('superadmin.user.store');
});
