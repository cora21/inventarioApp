@extends('layouts.app')

@section('title', 'Generación de factura')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
.borderCard {
  border-radius: 20px;
}

.hover-effect {
  transition: background-color 0.4s ease-in-out, transform 0.3s ease-in-out, box-shadow 0.2s;
  box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
}

.hover-effect:hover {
  background-color: #f0f0f0;
  transform: scale(1);
  box-shadow: 0px 5px 10px rgba(0,0,0,0.2);
}
</style>
@section('contenido')
    <div class="d-flex" style="height: 100vh;">
        <div class="flex-grow-1" style="background-color: #ffffff; height: 800px; width: 200px;">
            @foreach ($venta as $row)
            <form action="{{ route('factura.agregar') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="idTablaVenta" value="{{ $row->id }}">
                <div class="hover-effect border-bottom border-3 p-2"
                    style="width: 100%; height: 7%; background-color: rgb(241, 241, 241);"
                    onclick="this.closest('form').submit();">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <strong>Factura: {{ $row->id }}</strong>
                            <br>
                            {{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y g:i a') }}
                        </span>
                        <span class="text-end">
                            ${{ number_format($row->montoTotalVenta, 2) }}
                        </span>
                    </div>
                </div>
            </form>
            @endforeach
        </div>


        <div class="flex-grow-1 p-4" style="background-color: #e0e0e0; height: 800px; width: 600px;">
            <div class="card borderCard shadow-lg">
                <div class="card-body">
                    @php
                        // Recuperar el idTablaVenta de la sesión
                        $ventaId = session('idTablaVenta');

                        // Consultar las filas relacionadas en detalle_ventas
                        $detallesVentas = $ventaId ? \App\Models\DetalleVenta::where('venta_id', $ventaId)->get() : [];

                        // Consultar la venta para obtener información adicional
                        $venta = $ventaId ? \App\Models\Venta::find($ventaId) : null;
                        $detallesPagos = $ventaId ? \App\Models\DetallePago::where('venta_id', $ventaId)->get() : [];
                        // Consultar los pagos relacionados
                        // Recuperar montoTotalVenta de la venta
                        $montoTotalVenta = $venta ? $venta->montoTotalVenta : 0; // Si no existe, asignar 0
                    @endphp

                    @if ($ventaId)
                        <!-- Encabezado -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5>Factura número {{ $ventaId }}</h5>
                            <button class="btn btn-outline-success btn-lg" onclick="window.print()">
                                <i class="bi bi-printer"></i> Imprimir
                            </button>
                        </div>

                        <!-- Detalles de la factura plista de arriba-->
                        <div class="mb-4">
                            <table class="table" style="font-size: 13px;">
                                <tbody>
                                    <tr>
                                        <td style="width: 30%; height: 25px; background-color: rgb(241, 241, 241); border-radius: 15px 0px 0px 0px;">Estado:</td>
                                        <td class="bg-white" style="height: 25px;"><span class="text-success">Pagado</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="height: 25px; background-color: rgb(241, 241, 241);">Fecha de Creación:</td>
                                        <td class="bg-white" style="height: 25px;">{{ $venta ? \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y g:i a') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="height: 25px; background-color: rgb(241, 241, 241);">Almacen:</td>
                                        <td class="bg-white" style="height: 25px;"><!-- Sin datos por ahora --></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="height: 25px; background-color: rgb(241, 241, 241);">Vendedor:</td>
                                        <td class="bg-white" style="height: 25px;"> <!-- Sin datos por ahora --></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="height: 25px; background-color: rgb(241, 241, 241); border-radius: 0px 0px 0px 15px; border-bottom: none;">Cliente:</td>
                                        <td class="bg-white" style="height: 25px;"> <!-- Sin datos por ahora --></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detalles de los productos -->
                        @if ($detallesVentas->isNotEmpty())
                            <h6>Productos</h6>
                            <table class="table" style="font-size: 13px;">
                                <thead>
                                    <tr style="background-color: rgb(241, 241, 241); ">
                                        <th style="border-radius: 15px 0px 0px 0px;">Producto</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col" style="border-radius: 0px 15px 0px 0px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detallesVentas as $detalle)
                                    <tr>
                                        <!-- Buscar el nombre del producto dentro del ciclo de productos -->
                                        @foreach ($producto as $selec)
                                            @if($selec->id === $detalle->producto_id)
                                                <th scope="row">{{ $selec->nombreProducto }}</th> <!-- Mostrar el nombre del producto -->
                                                @break <!-- Termina el ciclo de productos una vez que encuentre el nombre -->
                                            @endif
                                        @endforeach
                                        <td>${{ number_format($detalle->precioUnitarioProducto, 2) }}</td>
                                        <td>{{ $detalle->cantidadSeleccionadaVenta }}</td>
                                        <td>${{ number_format($detalle->precioTotalPorVenta, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No hay detalles de productos para mostrar.</p>
                        @endif
                    @else
                        <p>No hay detalles de la factura para mostrar.</p>
                    @endif
                    <div style="display: flex; justify-content: space-between; gap: 20px;">
                        <!-- Tabla de Método de Pago -->
                        <table class="table" style="font-size: 13px; width: 48%;">
                            <thead>
                                <tr style="background-color: rgb(241, 241, 241);">
                                    <th style="border-radius: 15px 0px 0px 0px; width: 40%;">Método de Pago</th>
                                    <th scope="col" style="width: 30%;">Monto</th>
                                    <th scope="col" style="border-radius: 0px 15px 0px 0px; width: 30%;">Moneda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detallesPagos as $detallePago)
                                    <tr>
                                        @foreach ($metPago as $selecPago)
                                            @if($selecPago->id === $detallePago->metodo_pago_id)
                                                <th scope="row">{{ $selecPago->nombreMetPago }}</th>
                                                @break
                                            @endif
                                        @endforeach

                                        {{-- <td style="width: 30%;">${{ number_format($detallePago->monto, 2) }}</td> <!-- Monto --> --}}
                                        @if($detallePago->nombrePago === 'VES')
                                        <th scope="row"> {{ number_format($detallePago->monto * $dolarBCV , 2) }}</th>
                                        @else
                                            <th scope="row">{{ $detallePago->monto }}</th>
                                        @endif
                                        <td style="width: 30%;">{{ $detallePago->nombrePago }}</td> <!-- Nombre del pago -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Tabla de Subtotal y Total -->
                        <div style="width: 48%; font-size: 13px;">
                            <ul style="list-style-type: none; padding: 0; margin: 0; border-left: 2px solid #000; padding-left: 10px;">
                                @foreach ($detallesPagos as $detallePago)
                                <li style="padding: 10px 0; display: flex; justify-content: space-between; border-bottom: 1px solid #000;">
                                    @if($detallePago->nombrePago === 'VES')
                                    <span>Pago en bolivares:</span>
                                    <span>Bs. {{ number_format($detallePago->monto * $dolarBCV, 2) }}</span>
                                    @else
                                    <span>Pago en dolares:</span>
                                    <span>${{ number_format($detallePago->monto, 2) }}</span>
                                    @endif
                                </li>
                                @endforeach
                                <li style="padding: 10px 0; display: flex; justify-content: space-between; border-bottom: 1px solid #000;">
                                    <span>Total de la factura:</span>
                                    <span>${{ number_format($montoTotalVenta, 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>




                </div>
            </div>
        </div>













    </div>

@endsection

