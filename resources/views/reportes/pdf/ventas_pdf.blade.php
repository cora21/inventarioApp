<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #fff;
            margin: 20px;
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
            font-size: 12px;
            color: #ccc;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #111;
            color: #fff;
            table-layout: fixed; /* Hace que respete el ancho total */
            font-size: 10px; /* Reduce un poco el tamaño del texto */
        }

        th, td {
            border: 1px solid #7ED321;
            padding: 6px; /*Reduce el padding para ahorrar espacio */
            word-wrap: break-word; /*Rompe palabras largas */
            white-space: normal; /* Evita que el texto esté en una sola línea */
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
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Logo de fondo -->
    <img src="{{ public_path('imagenes/fondopdf.jpg') }}" class="background-logo" alt="Logo Moto">

    <h2>Reporte de Ventas</h2>
    <span class="date">Fecha: {{ now()->format('d/m/Y') }}</span>

    <table>
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
                @php $contador = 1; @endphp
                @forelse($ventas as $venta)
                    @foreach($venta->detallesVenta as $detalle)
                        <tr>
                            <td>{{ $contador++ }}</td>
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
                    <tr><td colspan="9" class="text-center">No hay registros</td></tr>
                @endforelse
            </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Empresa de Repuestos de Motos "Inversiones Mi Protector" | Todos los derechos reservados
    </div>

</body>
</html>