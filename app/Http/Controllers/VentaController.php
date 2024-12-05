<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class VentaController extends Controller{

    public function index(){
    $almacen = Almacen::all();
    $categoria = Categoria::all();
    $colores = Color::all();
    $proveedor = Proveedor::all();
    $producto = Producto::with(['categoria', 'colores', 'almacen','proveedor' ])->get();
    return view('layouts.venta.index', compact('almacen', 'categoria', 'colores', 'proveedor', 'producto'));
}


}


