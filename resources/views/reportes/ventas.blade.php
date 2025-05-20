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
                    <div class="col-md-3">
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

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
                        <a href="{{ route('reporte.ventas.index') }}" class="btn btn-secondary w-100">🔄 Reiniciar</a>
                    </div>
                </div>

                <!-- Selector de cantidad de registros por página -->
                <div class="mt-3">
                    <label for="perPage" class="form-label">Mostrar:</label>
                    <select name="perPage" id="perPage" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                        @php $perPage = request('perPage', 10); @endphp
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="ms-2">registros por página</span>
                </div>
            </form>

            <!-- Botones de Exportación -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('reportes.ventas.exportar.pdf') }}" class="btn btn-danger">📄 Exportar PDF</a>
                <a href="{{ route('reportes.ventas.exportar.excel') }}" class="btn btn-success">📊 Exportar Excel</a>
            </div>

            <!-- Contenedor con Scroll Horizontal -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Descripción</th>
                            <th>Producto Disponible</th>
                            <th>Precio de Proveedor</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th>Método Pago</th>
                            <th>Almacén</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            @foreach($venta->detallesVenta as $detalle)
                                <tr>
                                    <td>{{ $loop->parent->iteration + ($ventas->perPage() * ($ventas->currentPage() - 1)) }}</td>
                                    <td>{{ $detalle->cantidadSeleccionadaVenta }}</td>
                                    <td>{{ optional($detalle->producto)->nombreProducto }}</td>
                                    <td>{{ optional(optional($detalle->producto)->categoria)->nombre ?? '-' }}</td>
                                    <td>{{ optional($detalle->producto)->marcaProducto ?? '-' }}</td>
                                    <td>{{ optional($detalle->producto)->modeloProducto ?? '-' }}</td>
                                    <td>{{ optional($detalle->color)->nombreColor ?? '-' }}</td>
                                    <td>{{ optional($detalle->producto)->descripcionProducto ?? '-' }}</td>
                                    <td>{{ optional($detalle->producto)->cantidadDisponibleProducto ?? '-' }}</td>
                                    <td>${{ number_format(optional($detalle->producto)->precioBaseProveedor, 2) }}</td>
                                    <td>${{ number_format($detalle->precioUnitarioProducto, 2) }}</td>
                                    <td>${{ number_format($detalle->precioTotalPorVenta, 2) }}</td>
                                    <td>{{ optional(optional($venta->detallesPago->first())->metodoPago)->nombreMetPago ?? '-' }}</td>
                                    <td>{{ optional(optional($detalle->producto)->almacen)->nombre ?? '-' }}</td>
                                    <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="15" class="text-center">No hay registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación con links -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="mb-0 text-muted">Mostrando del {{ $ventas->firstItem() }} al {{ $ventas->lastItem() }} de {{ $ventas->total() }} resultados</p>
                {{ $ventas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection