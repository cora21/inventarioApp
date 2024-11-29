<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;

class ProductoController extends Controller{
    

    public function index(){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::all();
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor','producto'));
    }

    public function create(){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor'));
    }
        public function store(Request $request){
        // Validar los datos enviados desde el formulario
        $validated = $request->validate([
            'nombreProducto' => 'required|string',
            'marcaProducto' => 'required|string|',
            'modeloProducto' => 'nullable|string|',
            'descripcionProducto' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'cantidadDisponibleProducto' => 'required|integer|min:0',
            'precioUnitarioProducto' => 'required|numeric|min:0',
            'precioTotal' => 'numeric',
        ]);
        // Crear el producto manualmente
        $producto = new Producto();
        $producto->nombreProducto = $validated['nombreProducto'];
        $producto->marcaProducto = $validated['marcaProducto'];
        $producto->modeloProducto = $validated['modeloProducto'];
        $producto->descripcionProducto = $validated['descripcionProducto'];
        $producto->categoria_id = $validated['categoria_id'];
        $producto->proveedor_id = $validated['proveedor_id'];
        $producto->almacen_id = $validated['almacen_id'];
        $producto->cantidadDisponibleProducto = $validated['cantidadDisponibleProducto'];
        $producto->precioUnitarioProducto = $validated['precioUnitarioProducto'];
        $producto->precioTotal = $validated['precioTotal'];
        $producto->save(); // Guarda el producto en la base de datos
        // Registrar la relación en la tabla intermedia `producto_almacen`
        $producto->almacenes()->attach($validated['almacen_id'], [
            'cantidad' => $validated['cantidadDisponibleProducto'], // Usar cantidadDisponibleProducto como valor en la relación
        ]);
        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
    }

    public function colores($id){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::find($id);
        return view('layouts.producto.colores', compact('almacen', 'categoria', 'colores','proveedor', 'producto'));
        //return route('producto.color', compact('almacen', 'categoria', 'colores','proveedor'));
    }



}
