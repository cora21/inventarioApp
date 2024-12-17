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


public function guardarPago(Request $request)
    {
        try {
            // Guardar el pago sin validación previa
            $detallePago = new DetallePago();
            $detallePago->venta_id = $request->venta_id;
            $detallePago->metodo_pago_id = $request->metodo_pago_id;
            $detallePago->monto = $request->monto;
            $detallePago->save();

            // Responder con éxito
            return response()->json(['success' => true, 'message' => 'Pago guardado correctamente.']);
        } catch (\Exception $e) {
            // En caso de error, capturar y mostrar el mensaje de error
            Log::error('Error al guardar el pago: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Hubo un error al guardar el pago.', 'error' => $e->getMessage()]);
        }
    }


}
