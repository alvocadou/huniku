<?php

use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\ListingManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertySubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/cari', [ListingController::class, 'index'])->name('listings.index');
Route::get('/properti/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/favorit', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorit/{listing}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/daftarkan-properti', [PropertySubmissionController::class, 'create'])->name('submit.create');
    Route::post('/daftarkan-properti', [PropertySubmissionController::class, 'store'])->name('submit.store');
    Route::get('/listing-saya', [PropertySubmissionController::class, 'index'])->name('submit.index');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profil/jadi-developer', [ProfileController::class, 'becomeDeveloperForm'])->name('profile.become-developer');
    Route::post('/profil/jadi-developer', [ProfileController::class, 'becomeDeveloper'])->name('profile.become-developer.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('listings', ListingManageController::class)->except(['show']);
    Route::post('listings/{listing}/approve', [ListingManageController::class, 'approve'])->name('listings.approve');
    Route::post('listings/{listing}/reject', [ListingManageController::class, 'reject'])->name('listings.reject');

    Route::get('developers', [DeveloperController::class, 'index'])->name('developers.index');
    Route::get('developers/{user}', [DeveloperController::class, 'show'])->name('developers.show');
    Route::post('developers/{user}/verify', [DeveloperController::class, 'verify'])->name('developers.verify');
    Route::post('developers/{user}/reject', [DeveloperController::class, 'reject'])->name('developers.reject');
});