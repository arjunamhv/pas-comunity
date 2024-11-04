<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/provinsi', [AddressController::class, 'getProvinsi'])->name('provinsi.get');

Route::get('/kota', [AddressController::class, 'getKota'])->name('kota.get');

Route::get('/kecamatan', [AddressController::class, 'getKecamatan'])->name('kecamatan.get');

Route::get('/kelurahan', [AddressController::class, 'getKelurahan'])->name('kelurahan.get');

require __DIR__.'/auth.php';
