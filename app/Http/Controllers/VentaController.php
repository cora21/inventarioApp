<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\MetodoPago;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\models\DetallePago;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $metPago = MetodoPago::all();
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::with(['categoria', 'colores', 'almacen', 'proveedor'])->get();
        $venta = Venta::latest()->first(); // Última venta registrada (o selecciona una venta específica)
        $detalleVenta = DetalleVenta::all();
        $detallePago = DetallePago::all();

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
            'productosAgregados',
            'metPago',
            'venta',
            'detalleVenta',
            'detallePago',
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





// Paso 1: Registrar la venta
public function registrarVenta(Request $request){
    $venta = Venta::create([
        'montoTotalVenta' => $request->montoTotal
    ]);
    return response()->json(['venta_id' => $venta->id], 201);
}





// Paso 2: Registrar los detalles de la venta
public function registrarDetallesVenta(Request $request){
    $detalles = $request->detalles;
    foreach ($detalles as $detalle) {
        DetalleVenta::create([
            'venta_id' => $detalle['venta_id'],
            'producto_id' => $detalle['producto_id'],
            'cantidadSeleccionadaVenta' => $detalle['cantidad'],
            'color_id' => $detalle['color_id'],
            'precioUnitarioProducto' => $detalle['precio_unitario'],
            'precioTotalPorVenta' => $detalle['precio_total']
        ]);
    }
    return response()->json(['message' => 'Detalles registrados exitosamente'], 201);
}




public function guardarPago(Request $request){
        try {
            // Lógica para guardar el pago
            $detallePago = new DetallePago();
            $detallePago->venta_id = $request->venta_id;
            $detallePago->metodo_pago_id = $request->metodo_pago_id;
            $detallePago->monto = $request->monto;
            $detallePago->save();

            // Responder con éxito
            return response()->json([
                'success' => true,
                'message' => 'Pago guardado correctamente.'
            ]);
        } catch (\Exception $e) {
            // Puedes registrar el error para fines de depuración si lo necesitas
            Log::error('Error al guardar el pago: ' . $e->getMessage());

            // Responder con un mensaje genérico sin detalles del error
            return response()->json([
                'success' => false,
                'messageGenerico' => 'Hubo un error al guardar el pago.'
            ]);
        }finally {
            // Eliminar la sesión 'venta' al final de la función
            session()->forget('productos_agregados');
        }
    }

   public function guardarPagosCombinados(Request $request){
    try {
        // Iniciar una transacción para asegurar que todos los pagos se guarden correctamente
        DB::beginTransaction();

        // Obtener el array de pagos desde la solicitud
        $pagos = $request->input('pagos');

        // Recorrer el array de pagos y guardarlos
        foreach ($pagos as $pago) {
            // Guardar el pago en la tabla detalles_pagos
            DetallePago::create([
                'venta_id' => $pago['venta_id'],
                'metodo_pago_id' => $pago['metodo_pago_id'],
                'monto' => $pago['monto']
            ]);
        }

        // Confirmar la transacción si no hubo errores
        DB::commit();

        // Responder con éxito
        return response()->json([
            'success' => true,
            'message' => 'Pagos guardados correctamente.'
        ]);
    } catch (\Exception $e) {
        // Revertir la transacción si hubo un error
        DB::rollback();

        // Log del error
        Log::error('Error al guardar los pagos combinados: ' . $e->getMessage());

        // Responder con un error
        return response()->json([
            'success' => false,
            'message' => 'Hubo un error al guardar los pagos.',
            'error' => $e->getMessage()
        ]);
    } finally {
        // Eliminar la sesión 'venta' al final de la función
        session()->forget('productos_agregados');
    }
}
}






