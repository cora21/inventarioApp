@extends('layouts.app')

@section('title', 'Reporte de Ventas')

@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>📉 Reporte de Ventas</h3>
            <hr>

            <!-- Formulario de Filtro -->
            <form action="{{ route('reporte.ventas.filtrar') }}" method="GET" class="mb-4">
                <div class="row">
            <div class="col-md-4">
                <label for="producto_id" class="form-label">Producto:</label>
                <select name="producto_id" id="producto_id" class="form-control">
                    <option value="">-- Seleccionar producto --</option>
                    @foreach($productos as $prod)
                        <option value="{{ $prod->id }}" {{ request('producto_id') == $prod->id ? 'selected' : '' }}>
                            {{ $prod->nombreProducto }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="metodo_pago_id" class="form-label">Método de pago:</label>
                <select name="metodo_pago_id" id="metodo_pago_id" class="form-control">
                    <option value="">-- Todos --</option>
                    @foreach($metodosPago as $mp)
                        <option value="{{ $mp->id }}" {{ request('metodo_pago_id') == $mp->id ? 'selected' : '' }}>
                            {{ $mp->nombreMetPago }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="almacen_id" class="form-label">Almacén:</label>
                <select name="almacen_id" id="almacen_id" class="form-control">
                    <option value="">-- Todos --</option>
                    @foreach($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

    <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
    </div>
</div>
            </form>

            <!-- Botones de Exportación -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('reportes.ventas.exportar.pdf') }}" class="btn btn-danger">📄 Exportar PDF</a>
                <a href="{{ route('reportes.ventas.exportar.excel') }}" class="btn btn-success">📊 Exportar Excel</a>
            </div>

            <!-- Tabla de Resultados -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Método Pago</th>
                        <th>Tasa Cambio</th>
                        <th>Almacén</th>
                    </tr>
                </thead>
            <tbody>
                @forelse($ventas as $venta)
                    @foreach($venta->detallesVenta as $detalle)
                        <tr>
                            <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                            <td>{{ optional($detalle->producto)->nombreProducto }}</td>
                            <td>{{ optional(optional($detalle->producto)->categoria)->nombre ?? '-' }}</td>
                            <td>{{ $detalle->cantidadSeleccionadaVenta }}</td>
                            <td>${{ number_format($detalle->precioUnitarioProducto, 2) }}</td>
                            <td>${{ number_format($detalle->precioTotalPorVenta, 2) }}</td>
                            <td>{{ optional($venta->metodoPago)->nombreMetPago ?? '-' }}</td>
                            <td>{{ optional(optional($venta->detallePago)->tasaCambio)->nombreMoneda ?? '-' }}</td>
                            <td>{{ optional($venta->almacen)->nombre ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="9" class="text-center">No hay registros</td></tr>
                @endforelse
            </tbody>
            </table>

            {{ $ventas->links() }}
        </div>
    </div>
</div>
@endsection