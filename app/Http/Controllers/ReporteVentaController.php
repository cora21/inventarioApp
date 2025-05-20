<?php

// app/Http/Controllers/ReporteVentaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\DetallePago;
use App\Models\TasasCambios;
use App\Models\MetodoPago;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\HistoriaTasasCambios;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReporteVentaController extends Controller
{
    public function index()
{
    $ventas = Venta::with([
                    'detallesVenta.producto.categoria',
                    'metodoPago',
                    'almacen',
                    'detallesPago.tasaCambio'
                ])
                ->latest()
                ->paginate(10);

    $productos = Producto::with('categoria')->get();
    $metodosPago = MetodoPago::all();
    $almacenes = Almacen::all();

    return view('reportes.ventas', compact('ventas', 'productos', 'metodosPago', 'almacenes'));
}

    public function filtrar(Request $request)
    {
        $query = Venta::with(['detallesVenta.producto']);

        if ($request->filled('producto_id')) {
            $query->whereHas('detallesVenta', function ($q) use ($request) {
                $q->where('producto_id', $request->producto_id);
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        $ventas = $query->paginate(10)->appends($request->all());

        $productos = Producto::all();
        $metodosPago = MetodoPago::all();
        $almacenes = Almacen::all();


        return view('reportes.ventas', compact('ventas', 'productos', 'metodosPago', 'almacenes'));
    }

    public function exportarPdf(Request $request)
    {
        $ventas = $this->filtrarQuery($request)->get();
        $pdf = PDF::loadView('reportes.pdf.ventas_pdf', compact('ventas'));

        return $pdf->download('reporte_ventas_' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportarExcel(Request $request)
    {
        $ventas = $this->filtrarQuery($request)->get();

        $data = [];
        foreach ($ventas as $venta) {
            foreach ($venta->detallesVenta as $detalle) {
                $data[] = [
                    'Fecha' => $venta->created_at->format('d/m/Y'),
                    'Producto' => $detalle->producto->nombre ?? '-',
                    'Cantidad' => $detalle->cantidadSeleccionadaVenta,
                    'Precio Unitario' => number_format($detalle->precioUnitarioProducto, 2),
                    'Total' => number_format($detalle->precioTotalPorVenta, 2),
                ];
            }
        }

        return Excel::create('Reporte_Ventas_' . now()->format('Y-m-d'), function ($excel) use ($data) {
            $excel->sheet('Ventas', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }

    private function filtrarQuery(Request $request)
    {
        $query = Venta::with([
            'detallesVenta.producto.categoria',
            'metodoPago',
            'almacen',
            'detallePago.tasaCambio'
        ]);

        if ($request->filled('producto_id')) {
            $query->whereHas('detallesVenta', function ($q) use ($request) {
                $q->where('producto_id', $request->producto_id);
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        if ($request->filled('metodo_pago_id')) {
            $query->where('metodo_pago_id', $request->metodo_pago_id);
        }

        if ($request->filled('almacen_id')) {
            $query->where('almacen_id', $request->almacen_id);
        }

        return $query;
    }
}