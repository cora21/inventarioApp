<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;


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


// rutas de almacen
Route::resource('almacen', AlmacenController::class);
Route::get('edit/{id}', [AlmacenController::class, 'edit'])->name('almacen.edit');


//rutas del metodo de pago
Route::resource('metodoPago', MetodoPagoController::class);
Route::get('index', [MetodoPagoController::class, 'index'])->name('metodo.index');
Route::post('store', [MetodoPagoController::class, 'store'])->name('metodo.store');
Route::get('show/{id}', [MetodoPagoController::class, 'show'])->name('metodo.show');


//rutas de las categorias
Route::resource('categoria', CategoriaController::class);


//rutas de los proveedores
Route::resource('proveedor', ProveedorController::class);

//rutas para el producto modulo mas pesado
Route::resource('producto', ProductoController::class);
Route::get('colores/{id}', [ProductoController::class, 'colores'])->name('producto.colores');
Route::post('producto/{id}/colores', [ProductoController::class, 'guardarColores'])->name('producto.guardarColores');
Route::get('imagenes/{id}', [ProductoController::class, 'imagenes'])->name('producto.imagenes');
Route::post('producto/{id}', [ProductoController::class, 'guardarImagenes'])->name('producto.guardarImagenes');



