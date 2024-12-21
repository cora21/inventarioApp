<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\MetodoPago;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\models\DetallePago;
use Carbon\Carbon;



class FacturaController extends Controller{
    public function index(){
        $venta = Venta::all();
        $detalleVenta = DetalleVenta::all();
        $detallePago = DetallePago::all();
        $producto = Producto::all();
        $metPago = MetodoPago::all();
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores  = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.factura.index', compact( 'almacen', 'categoria', 'colores', 'proveedor', 'producto', 'metPago', 'venta', 'detalleVenta', 'detallePago'
        ));
    }

    public function agregarProducto(Request $request)
    {
        // Eliminar cualquier sesión previa de productos seleccionados
        session()->forget('productos_seleccionados');

        // Validar que el producto_id exista
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        // Agregar el producto a la sesión
        session()->push('productos_seleccionados', $request->producto_id);

        // Redirigir de nuevo a la vista de factura
        return redirect()->route('factura.index');
    }


}
