<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('motors', \App\Http\Controllers\Admin\MotorController::class);
    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
});

// Manager Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
    
    // Stok Global & Stok Masuk
    Route::get('/stocks', [\App\Http\Controllers\Manager\StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks', [\App\Http\Controllers\Manager\StockController::class, 'store'])->name('stocks.store');
    
    // Sesi Penjualan Seller
    Route::get('/sessions', [\App\Http\Controllers\Manager\SessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/{session}', [\App\Http\Controllers\Manager\SessionController::class, 'show'])->name('sessions.show');
    Route::post('/sessions/{session}/approve', [\App\Http\Controllers\Manager\SessionController::class, 'approveStock'])->name('sessions.approve');
    Route::post('/sessions/{session}/close', [\App\Http\Controllers\Manager\SessionController::class, 'closeSession'])->name('sessions.close');
    
    // Gaji / Upah
    Route::get('/salaries', [\App\Http\Controllers\Manager\SalaryController::class, 'index'])->name('salaries.index');
    Route::post('/salaries/{salary}/approve', [\App\Http\Controllers\Manager\SalaryController::class, 'approve'])->name('salaries.approve');
});

require __DIR__.'/auth.php';
