<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlmacenController;


Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () { return view('layouts.welcome'); })->name('dashboard');

    /* USERS */
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('almacen', [AlmacenController::class, 'index'])->name('almacen.index');
Route::post('almacen', [AlmacenController::class, 'store'])->name('almacen.store');
