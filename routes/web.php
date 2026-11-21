<?php

use App\Http\Controllers\Site\ArtistController;
use App\Http\Controllers\Site\ArtworkController;
use App\Http\Controllers\Site\EventController;
use App\Http\Controllers\Site\GalleryController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Publik Sanggar Gita Lestari
|--------------------------------------------------------------------------
| Dashboard admin (/admin) diatur otomatis oleh Filament
| (App\Providers\Filament\AdminPanelProvider).
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/profil', ProfileController::class)->name('profile');

Route::get('/seniman', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/seniman/{artist}', [ArtistController::class, 'show'])->name('artists.show');

Route::get('/karya', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/karya/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');

Route::get('/kegiatan', [EventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/galeri', GalleryController::class)->name('gallery');
