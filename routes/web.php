<?php

use App\Http\Controllers\Api\ChartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\KoefisieniController;
use App\Http\Controllers\PrediksiController;

// ===================
// Halaman Login
// ===================
Route::get('/', function () {
    return view('login');
})->name('login');

// ===================
// Proses Login Manual
// ===================
Route::post('/', function (Request $request) {
    $username = $request->username;
    $password = $request->password;

    if ($username === 'admin' && $password === '123') {
        session(['is_admin' => true]);
        return redirect('/admin');
    }

    return back()->withErrors(['login' => 'Username atau Password salah!']);
})->name('login.proses');

// ===================
// Logout
// ===================
Route::get('/logout', function () {
    session()->forget('is_admin');
    return redirect('/');
})->name('logout');

// ===================
// Dashboard Admin
// ===================
use App\Http\Controllers\DashboardController;

Route::get('/admin', function () {
    if (!session('is_admin')) {
        return redirect('/');
    }
    return app(DashboardController::class)->index(); // <-- GANTI view() ke controller
})->name('index');


// ===================
// CRUD Data Penjualan
// ===================
Route::get('/admin/data-penjualan', function () {
    if (!session('is_admin')) return redirect('/');
    return app(PenjualanController::class)->index();
})->name('penjualan.index');

Route::post('/admin/data-penjualan', function (Request $request) {
    if (!session('is_admin')) return redirect('/');
    return app(PenjualanController::class)->store($request);
})->name('penjualan.store');

Route::delete('/admin/data-penjualan/{id}', function ($id) {
    if (!session('is_admin')) return redirect('/');
    return app(PenjualanController::class)->destroy($id);
})->name('penjualan.destroy');
Route::put('/admin/data-penjualan/{id}', function (Request $request, $id) {
    if (!session('is_admin')) return redirect('/');
    return app(App\Http\Controllers\PenjualanController::class)->update($request, $id);
})->name('penjualan.update');


// ===================
// VIEW - Tabel Koefisien & Intercept
// ===================
Route::get('/admin/koefisien', function () {
    if (!session('is_admin')) return redirect('/');
    return app(KoefisieniController::class)->index();
})->name('koefisien');

// ===================
// VIEW - Tabel Prediksi Penjualan
// ===================
Route::get('/admin/hasil-prediksi', function () {
    if (!session('is_admin')) return redirect('/');
    return app(PrediksiController::class)->index();
})->name('hasil.prediksi');

// ===================
// VIEW - Detail Produk & Grafik Prediksi
// ===================
Route::get('/admin/detail-produk/{id}', function ($id) {
    if (!session('is_admin')) return redirect('/');
    return app(PrediksiController::class)->show($id);
})->name('produk.detail');


Route::get('/chart/sektor', [ChartController::class, 'buahPerSektor']);
Route::get('/chart/pegawai', [ChartController::class, 'buahPerPegawai']);
Route::get('/chart/cuaca', [ChartController::class, 'buahPerCuaca']);
Route::get('/chart/pendapatan-tertinggi', [ChartController::class, 'pendapatanTertinggi']);