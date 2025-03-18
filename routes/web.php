<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;

Auth::routes();


Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';




Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [PrincipalController::class, 'index'])->name('dashboard');
    Route::post('/actualizar-tasa-cambio', [PrincipalController::class, 'actualizarTasaCambio'])->name('actualizar.tasa.cambio');
    Route::post('/updateBaseMoneda', [PrincipalController::class, 'updateBaseMoneda'])->name('updateBaseMoneda');
    Route::get('/api/movimientos-semanales', [PrincipalController::class, 'getMovimientosSemanales']);
    Route::get('/api/productos-ventas', [PrincipalController::class, 'getProductosVentas']);






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
Route::get('edit/{id}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::post('producto/{id}/colores', [ProductoController::class, 'guardarColores'])->name('producto.guardarColores');
Route::get('imagenes/{id}', [ProductoController::class, 'imagenes'])->name('producto.imagenes');
Route::post('producto/{id}', [ProductoController::class, 'guardarImagenes'])->name('producto.guardarImagenes');
Route::get('/buscar-productos', [ProductoController::class, 'buscar'])->name('producto.buscar');
Route::delete('/imagenes/{id}', [ProductoController::class, 'destroy'])->name('imagenes.destroy');
Route::delete('/eliminar-color/{id}', [ProductoController::class, 'destroycolores']);





//rutas de las ventas
Route::resource('venta', VentaController::class);
Route::post('/venta/agregar', [VentaController::class, 'agregarProducto'])->name('venta.agregar');
Route::post('/venta/eliminar', [VentaController::class, 'eliminarProducto'])->name('venta.eliminar');
Route::post('/venta/registrar', [VentaController::class, 'registrarVenta'])->name('venta.registrar');
Route::post('/venta/detalles', [VentaController::class, 'registrarDetallesVenta'])->name('venta.detalles');
Route::post('/venta/guardar-pago', [VentaController::class, 'guardarPago'])->name('venta.guardarPago');
Route::post('/venta/guardar-pagos-combinados', [VentaController::class, 'guardarPagosCombinados'])->name('venta.guardarPagosCombinados');

//rutas de las facturas
Route::resource('factura', FacturaController::class);
Route::post('/factura/agregar', [FacturaController::class, 'agregarProducto'])->name('factura.agregar');

//rutas para el pdf
Route::get('/generar-pdf', [PDFController::class, 'generarPDF'])->name('generar.pdf');
Route::get('/generar-factura-pdf', [PDFController::class, 'generarFacturaPDF'])->name('generarFactura.pdf');



//rutas para la configuracion
Route::get('configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');



