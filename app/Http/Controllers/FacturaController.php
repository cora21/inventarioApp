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
use App\Models\DetallePago;
use App\Models\TasasCambios;
use App\Models\HistoriaTasasCambios;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class FacturaController extends Controller{
    public function index(){
        $venta = Venta::orderBy('id', 'desc')->get();  // Ordena por id de forma descendente
        $tasa = TasasCambios::all();
        $detalleVenta = DetalleVenta::all();
        $detallePago = DetallePago::all();
        $producto = Producto::all();
        $metPago = MetodoPago::all();
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores  = Color::all();
        $proveedor = Proveedor::all();
        $valorDolarDiario = HistoriaTasasCambios::all();

        $dolarBCV = DB::table('tasas_cambios')->where('id', 2)->value('valorMoneda');
        $dolarBCV = number_format($dolarBCV, 2);

        
        return view('layouts.factura.index', compact( 'almacen', 'categoria', 'colores', 'proveedor', 'producto', 'metPago', 'venta', 'detalleVenta', 'detallePago', 'tasa', 'dolarBCV', 'valorDolarDiario'
        ));
    }

    public function agregarProducto(Request $request){
        // Validar que el idTablaVenta sea enviado y exista en la tabla ventas
        $request->validate([
            'idTablaVenta' => 'required|exists:ventas,id',
        ]);

        // Guardar el idTablaVenta seleccionado en la sesión
        session(['idTablaVenta' => $request->idTablaVenta]);

        // Redirigir a la vista factura
        return redirect()->route('factura.index');
    }

}
