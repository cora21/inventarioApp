<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 40px;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #7ED321; /* Verde manzana */
            margin-bottom: 10px;
        }

        .date {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #ccc;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #111;
            color: #fff;
        }

        th, td {
            border: 1px solid #7ED321;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #0A0A0A;
            color: #7ED321;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #1c1c1c;
        }

        /* Logo de fondo (marca de agua) */
        .background-logo {
            position: fixed;
            top: 50%;
            left: 40%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: -1;
            width: 100%;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Logo de fondo -->
    <img src="{{ public_path('imagenes/fonde del PDF.jpg') }}" class="background-logo" alt="Logo Moto">

    <h2>Reporte de Ventas</h2>
    <span class="date">Fecha: {{ now()->format('d/m/Y') }}</span>

    <table>
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
                            <td>{{ optional($venta->metodoPago)->nombre ?? '-' }}</td>
                            <td>{{ optional(optional($venta->detallePago)->tasaCambio)->valor ?? '-' }}</td>
                            <td>{{ optional($venta->almacen)->nombre ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="9" class="text-center">No hay registros</td></tr>
                @endforelse
            </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Empresa de Repuestos de Motos "Inversiones Mi Protector" | Todos los derechos reservados
    </div>

</body>
</html>