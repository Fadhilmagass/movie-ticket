<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::redirect('/', '/movies')->name('home'); // Redirect root to movies page

// Authentication Routes (from auth.php)
require __DIR__ . '/auth.php';

// Google Authentication Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Movie Routes (Public)
Route::prefix('movies')->name('movies.')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('index');
    Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
});

// Review Routes (Authenticated Users Only)
Route::middleware('auth')->prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/', [ReviewController::class, 'store'])->name('store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Review
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Movie Management
    Route::resource('movies', AdminMovieController::class)->except(['show']);
});
