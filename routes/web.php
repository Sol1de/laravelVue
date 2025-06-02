<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\API\PlaylistController as APIPlaylistController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('home', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('test', [HomeController::class, 'index'])->name('test');

Route::prefix('/')->name('tracks.')->group(function () {
    Route::get('/', [TrackController::class, 'index'])->name('index');

    Route::middleware(['auth', IsAdmin::class])->group(function () {
        Route::get('create', [TrackController::class, 'create'])->name('create');
        Route::post('/', [TrackController::class, 'store'])->name('store');
        Route::get('{track}/edit', [TrackController::class, 'edit'])->name('edit');
        Route::put('{track}', [TrackController::class, 'update'])->name('update');
        Route::delete('{track}', [TrackController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::get('/api/playlists', [APIPlaylistController::class, 'index'])->name('api.playlists.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('api-keys', ApiKeyController::class)->only([
        'index', 'create', 'store', 'destroy'
    ])->names('api-keys');

    Route::resource('playlists', PlaylistController::class)->middleware('auth');
});
