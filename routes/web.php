<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\UserRelationshipController;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/news', [NewsController::class, 'news'])->name('news');
Route::get('/news/load-more', [NewsController::class, 'loadMore'])->name('news.load-more');
Route::get('/news/{id}', [NewsController::class, 'newsDetail'])->name('news.detail');
Route::get('/events', [EventController::class, 'events'])->name('events');
Route::get('/events/{id}', [EventController::class, 'eventDetail'])->name('events.detail');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/user/{id}', [UserController::class, 'user']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/community', CommunityController::class);
    Route::resource('/relations', UserRelationshipController::class);

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::resource('/control/events', EventController::class);
        Route::resource('/control/news', NewsController::class);
        Route::resource('/control/users', UserController::class);
    });
});

Route::get('/provinsi', [AddressController::class, 'getProvinsi'])->name('provinsi.get');

Route::get('/kota', [AddressController::class, 'getKota'])->name('kota.get');

Route::get('/kecamatan', [AddressController::class, 'getKecamatan'])->name('kecamatan.get');

Route::get('/kelurahan', [AddressController::class, 'getKelurahan'])->name('kelurahan.get');

Route::get('/kotalahir', [AddressController::class, 'getKotabyid'])->name('get.kota.by.id');

Route::get('kota-lahir/autocomplete', [AddressController::class, 'autocomplete_kota_lahir'])->name('kota.lahir.autocomplete');

require __DIR__.'/auth.php';
