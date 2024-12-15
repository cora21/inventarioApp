<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;

class VentaController extends Controller
{
    public function index()
    {
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::with(['categoria', 'colores', 'almacen', 'proveedor'])->get();

        // Convertir los productos almacenados en sesión a objetos Producto
        $productosAgregados = collect(session('productos_agregados', []))->map(function ($producto) {
            return Producto::find($producto['id']); // Convertimos cada array en una instancia de Producto
        });

        return view('layouts.venta.index', compact(
            'almacen',
            'categoria',
            'colores',
            'proveedor',
            'producto',
            'productosAgregados'
        ));
    }

    public function agregarProducto(Request $request){
        // Validar el producto_id
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);
        // Obtener el producto desde la base de datos
        $producto = Producto::find($request->producto_id);
        // Agregar el producto a la sesión
        session()->push('productos_agregados', ['id' => $producto->id]);
        return redirect()->route('venta.index')->with('mensaje', 'Producto agregado temporalmente.');
    }

    public function eliminarProducto(Request $request){
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
    ]);
    $productosAgregados = session('productos_agregados', []);
    $productosAgregados = array_filter($productosAgregados, function ($producto) use ($request) {
        return $producto['id'] != $request->producto_id;
    });
    session(['productos_agregados' => $productosAgregados]);
    return response()->json(['mensaje' => 'Producto eliminado correctamente.']);
}

}
