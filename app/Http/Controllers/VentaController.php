<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Imagen;
use App\Models\Basura;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VentaController extends Controller{

    public function index(){
    $almacen = Almacen::all();
    $categoria = Categoria::all();
    $colores = Color::all();
    $proveedor = Proveedor::all();
    $basura = Basura::all();
    $producto = Producto::with(['categoria', 'colores', 'almacen','proveedor' ])->get();

    $productoColores = [];

    foreach ($basura as $item) {
        // Obtener los colores relacionados con el producto_id en la tabla intermedia 'producto_colores'
        $coloresRelacionados = DB::table('productos_colores')
            ->join('colores', 'colores.id', '=', 'productos_colores.color_id')
            ->where('productos_colores.producto_id', $item->producto_id)
            ->get(['colores.id', 'colores.nombreColor', 'colores.codigoHexa']); // Obtener los colores asociados con este producto

        // Agregar los colores relacionados a cada producto en el array
        $productoColores[$item->producto_id] = $coloresRelacionados;
    }







    return view('layouts.venta.index', compact('almacen', 'categoria', 'colores', 'proveedor', 'producto', 'basura', 'productoColores'));
}

public function guardarEnBasura(Request $request) {
    // Validación y guardado
    $request->validate([
        'producto_id' => 'required|string',
        'producto_nombre' => 'required|string',
        'cantidad_seleccionada' => 'required|string',
    ]);

    Basura::create([
        'producto_id' => $request->producto_id,
        'producto_nombre' => $request->producto_nombre,
        'cantidad_seleccionada' => $request->cantidad_seleccionada,
    ]);

    // Pasar indicador a la vista
    return redirect()->back()->with('abrirModal', true);
}

public function vaciarBasura() {
    // Vaciar la tabla 'basura'
    \App\Models\Basura::truncate();
    // Devolver respuesta
    return response()->json(['message' => 'Tabla basura vaciada correctamente'], 200);
}


}


