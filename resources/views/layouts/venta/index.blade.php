@extends('layouts.app')
@section('nombreBarra', 'Facturar')



@section('title', 'Ventas')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .icon-eliminar {
        color: black;
        /* Color inicial */
        font-size: 20px;
        /* Tamaño inicial */
        transition: color 0.3s ease, transform 0.3s ease;
        /* Transiciones suaves */
        position: absolute;
        /* Para que no afecte el tamaño de la celda */
        top: 50%;
        /* Centrar verticalmente */
        left: 50%;
        /* Centrar horizontalmente */
        transform: translate(-50%, -50%);
        /* Ajustar posición */
        cursor: pointer;
        /* Cambiar cursor al pasar */
    }

    .icon-eliminar:hover {
        color: red;
        /* Color al pasar el cursor */
        transform: translate(-50%, -50%) scale(1.2);
        /* Aumentar tamaño al pasar */
    }

        .payment-card {
        transition: all 0.3s ease; /* Transición suave */
        border: 2px solid transparent; /* Sin borde visible por defecto */
        cursor: pointer; /* Cambia el cursor a manito */
    }

    .payment-card:hover {
        border: 10px solid #146d28; /* Borde verde al pasar el cursor */
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3); /* Sombra verde suave */
        transform: scale(1.1); /* Ligero aumento de tamaño */
    }

</style>
@section('contenido')
<button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Open first modal</button>
    <div class="container">
        <div class="row response">
            <div class="col-12 col-md-12 border" style="height: 400px; background-color: rgb(215, 224, 227);">
                <div class="py-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text border-success" style="background-color: rgb(189, 225, 201)"
                            id="search-icon">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" id="search-productos" class="form-control border-success rounded"
                            placeholder="Buscar productos por nombre o marca...">
                        <a href="{{ route('producto.index') }}" class="btn btn-outline-success ms-1" type="button">Nuevo
                            producto + </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table w-100">
                                    <thead style="position: sticky; top: 0; z-index: 100;">
                                        <tr style="background-color: rgb(212, 212, 212);">
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Nombre del producto" style="border-radius: 15px 0px 0px 0px;">
                                                Producto
                                            </th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Categoria donde esta registrado el producto">
                                                Categoría
                                            </th>
                                            <th scope="col">Marca</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Cantidad disponible en el inventario">Cant.</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Precio Unitario">Precio</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Productos disponibles en estos colores">Colores disponibles</th>
                                            <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-productos">
                                        @foreach ($producto as $producto)
                                            <tr>
                                                <td><a
                                                        href="{{ route('producto.show', $producto->id) }}">{{ $producto->nombreProducto }}</a>
                                                </td>
                                                <td>{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td>
                                                <td>{{ $producto->marcaProducto }}</td>
                                                <td>{{ $producto->cantidadDisponibleProducto }}</td>
                                                <td>${{ $producto->precioUnitarioProducto }}</td>
                                                <td>
                                                    @if ($producto->colores->isNotEmpty())
                                                        @foreach ($producto->colores as $color)
                                                            <span class="badge d-inline-block"
                                                                style="display: inline-block; width: 20px; height: 20px; background-color: {{ $color->codigoHexa }};
                                                                border-radius: 50%; {{ strtolower($color->codigoHexa) == '#ffffff' ? 'border: 2px solid #ccc;' : '' }}"></span>
                                                        @endforeach
                                                    @else
                                                        Sin colores disponibles
                                                    @endif
                                                </td>
                                                <td style="position: relative;">
                                                    <form action="{{ route('venta.agregar') }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="producto_id"
                                                            value="{{ $producto->id }}">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm">Agregar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="container" style="height: 550px; background-color: rgb(228, 227, 227);">
        <div class="row response">
            <div>
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <h5 class="h3">Factura de Venta</h5>
                    <div>
                        <!-- Ícono de impresión -->
                        <a class="btn btn-light" title="Imprimir">
                            <i class="bi bi-printer"></i>
                        </a>
                        <!-- Ícono de ajustes -->
                        <a class="btn btn-light" title="Configuración">
                            <i class="bi bi-sliders"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-12 border"
                    style="height: 300px; background-color: rgb(255, 255, 255); max-height: 420px; overflow-y: auto;">
                    <table id="tabla-agregados" class="table table-hover">
                        <div class="card" style="">
                            <tbody>
                                @foreach ($productosAgregados as $producto)
                                    <tr id="producto-{{ $producto->id }}">
                                        <td style="width: 170px; height: 50px;">
                                            {{ $producto->nombreProducto }} <br>
                                            <small
                                                style="color: gray; font-size: 0.8em;">${{ $producto->precioUnitarioProducto }}</small>
                                        </td>
                                        <td style="width: 200px; height: 50px;">
                                            <div class="d-flex align-items-center">
                                                <a class="restar" data-id="{{ $producto->id }}">
                                                    <i class="bi bi-dash-lg mx-2"></i>
                                                </a>
                                                <input type="text" name="cantidadSelecionadaVenta" value="1" min="1"
                                                    class="form-control text-center mx-2 cantidad" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Cantidad seleccionada"
                                                    style="width: 80px;" readonly>
                                                <a class="sumar" data-id="{{ $producto->id }}">
                                                    <i class="bi bi-plus-lg mx-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td style="width: 180px; height: 50px;">
                                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                            <!-- Select de colores -->
                                            <select name="colorIdVenta" class="form-control select-color"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Seleccione el color del producto">
                                                @if ($producto->colores->isNotEmpty())
                                                    @foreach ($producto->colores as $color)
                                                        <option value="{{ $color->id }}"
                                                            data-color="{{ $color->codigoHexa }}"
                                                            data-unidades="{{ $color->pivot->unidadesDisponibleProducto }}">
                                                            {{ $color->nombreColor }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected>Color no disponible</option>
                                                @endif
                                            </select>
                                        </td>

                                        <td style="width: 100px; height: 50px;">
                                            <!-- Verificar si el producto tiene colores disponibles -->
                                            @if (!empty($producto->colores) && $producto->colores->count() > 0)
                                                <!-- Verificar si el color es blanco -->
                                                @if ($producto->colores[0]->codigoHexa == '#FFFFFF')
                                                    <div class="color-circulo"
                                                        style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $producto->colores[0]->codigoHexa }}; border: 2px solid #928f8f;">
                                                    </div>
                                                @else
                                                    <div class="color-circulo"
                                                        style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $producto->colores[0]->codigoHexa }};">
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Mostrar un círculo vacío si no hay colores disponibles -->
                                                <div class="color-circulo disabled"
                                                    style="width: 30px; height: 30px; border-radius: 50%; background-color: transparent; border: 2px solid #928f8f; display: flex; align-items: center; justify-content: center;">
                                                    <span class="x-icon"
                                                        style="color: gray; font-size: 20px;">&times;</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="width: 150px; height: 50px;">
                                            <!-- Mostrar unidades disponibles -->
                                            <input type="text" id="unidades-{{ $producto->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Cantidad disponible por color"
                                                value="{{ $producto->colores->isNotEmpty() ? $producto->colores[0]->pivot->unidadesDisponibleProducto : $producto->cantidadDisponibleProducto }}"
                                                readonly class="form-control">
                                        </td>
                                        <!-- Nueva celda para el monto calculado -->
                                        <td style="width: 170px; height: 50px;">
                                            <input type="text" name="" value="${{ $producto->precioUnitarioProducto }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Precio total por productos"
                                                class="form-control text-center mx-2 monto" value="0" readonly
                                                style="width: 120px; color: black; font-size: 15px">
                                        </td>

                                        <td style="position: relative;">
                                            <a href="#" class="eliminar-producto" data-id="{{ $producto->id }}"
                                                onclick="event.preventDefault();">
                                                <i class="fas fa-trash-alt icon-eliminar" title="Eliminar"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </div>
                    </table>
                </div>
            </div>

            <div class="mt-4 py-2 d-flex sticky-bottom" style="margin-top: auto; flex-direction: column; height: 100%;">
                <div style="margin-top: auto;">
                    {{-- data-bs-target="#exampleModalToggle" data-bs-toggle="modal" --}}
                    <button class="btn btn-success btn-lg d-flex justify-content-between w-100" id="procesarVenta"
                        style="padding: 10px; font-size: 1.5rem; width: 150%;">
                        <span>Vender</span>
                        <span id="totalFactura" style="font-weight: bold;">$0.00</span>
                    </button>
                    <a class="btn btn-outline-success  d-flex justify-content-between w-100 mt-2" id="cancelarVenta"
                        style="padding: 10px; font-size: 1rem; width: 120%;">
                        <span id="totalProductos">9 productos</span>
                        <span>Cancelar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>






    {{-- comienza la sesion del modal doble --}}
    {{-- primera parte modal 1 --}}
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3" id="exampleModalToggleLabel">Pagar factura</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <div class="container mt-6">
                        <!-- Aquí agregamos un campo oculto para almacenar el venta_id -->
                        <input type="hidden" id="ventaIdModal" name="venta_id" value="">
                        <div class="row justify-content-center">
                            @foreach ($metPago as $row)
                            <div class="col-lg-3 col-md-3 col-sm-12 mb-3 payment-card-item" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-method-id="{{ $row->id }}" data-method-name="{{ $row->nombreMetPago }}">
                                <div class="bg-light border p-2 text-center payment-card">
                                    <div class="mb-2">
                                        @if ($row->imagenMetPago)
                                            <a>
                                                <img src="{{ $row->imagenMetPago }}" alt="Imagen del método" class="img-fluid rounded" style="max-width: 50px;">
                                            </a>
                                        @else
                                            <div class="text-muted">
                                                <i class="bi bi-bank" style="font-size: 2.5rem;"></i>
                                                <br>
                                                <p class="small mt-1">No hay imagen disponible</p>
                                            </div>
                                        @endif
                                        <h6 class="fw-bold text-secondary mb-1">{{ $row->nombreMetPago }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-md-5 col-sm-12 mb-3">
                                <div class="bg-light border rounded shadow-sm p-2 text-center payment-card">
                                    <div class="mb-2">
                                        <div class="text-muted">
                                            <i class="bi bi-sliders" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <a href="{{ route('metodoPago.index') }}" class="fw-bold text-secondary mb-1">
                                            Otros métodos de pago
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                    {{-- final del body del modal --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open
                        second modal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- final del primer modal --}}
    {{-- segunda parte modal 2 --}}
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Pagar factura paso 2</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                            <i class="bi bi-arrow-down-up"></i> Regresar al primer modal
                        </button>
                        <!-- Aquí mostramos el nombre del método de pago seleccionado -->
                        <p><strong>Método de pago seleccionado: </strong><span id="selectedPaymentMethod">Ninguno</span></p>

                        <!-- Campo oculto para almacenar el ID del método de pago -->
                        <input type="hidden" id="paymentMethodId" name="payment_method_id">

                        <!-- Campo para ingresar el monto pagado -->
                        <div class="form-group">
                            <label for="amountPaid">Monto pagado</label>
                            <input type="number" class="form-control" id="amountPaid" name="amount_paid" placeholder="Ingrese el monto pagado" required>
                        </div>

                        <!-- Opcionalmente, puedes agregar un campo de comentario -->
                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Comentario (opcional)"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Back to first</button>
                </div>
            </div>
        </div>
    </div>
    {{-- final del segundo modal --}}










    <script>
        // Agregar un evento de clic a cada elemento del método de pago
        $('.payment-card-item').on('click', function () {
            // Capturamos el ID y el nombre del método de pago
            var methodId = $(this).data('method-id');
            var methodName = $(this).data('method-name');

            // Asignamos estos valores a los campos del segundo modal
            $('#selectedPaymentMethod').text(methodName); // Muestra el nombre del método de pago
            $('#paymentMethodId').val(methodId);  // Almacena el ID del método de pago en un campo oculto

            // Si es necesario, también puedes agregar más lógica aquí para otras partes del modal
        });
    </script>






    {{-- guarda en la base de datos ventas y detalle venta, me abre el modal ni loco se elimina --}}
    <script>
        // Botón "Vender" - Registrar la venta
        $('#procesarVenta').on('click', function (event) {
            event.preventDefault(); // Evitar que la página se recargue al hacer clic

            const totalFactura = parseFloat($('#totalFactura').text().replace('$', ''));

            // Paso 1: Registrar la venta
            $.ajax({
                url: '{{ route("venta.registrar") }}',
                method: 'POST',
                data: {
                    montoTotal: totalFactura,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    const ventaId = response.venta_id;

                    // Paso 2: Registrar los detalles de la venta
                    registrarDetallesVenta(ventaId);
                },
                error: function (xhr, status, error) {
                    console.error('Error al registrar la venta:', error);
                    Swal.fire('Error', 'Hubo un error al procesar la venta.', 'error');
                }
            });
        });

        // Función para registrar los detalles de la venta
        function registrarDetallesVenta(ventaId) {
            const detalles = [];

            $('#tabla-agregados tr').each(function () {
                const productoId = $(this).find('input[name="producto_id"]').val();
                const cantidad = $(this).find('.cantidad').val();
                const colorId = $(this).find('.select-color').val();
                const precioUnitario = parseFloat($(this).find('small').text().replace('$', '').trim());
                const precioTotal = parseFloat($(this).find('.monto').val().replace('$', '').trim());

                // Validar si el color está vacío o no
                const colorIdValidado = colorId ? colorId : null;

                detalles.push({
                    venta_id: ventaId,
                    producto_id: productoId,
                    cantidad: cantidad,
                    color_id: colorIdValidado,
                    precio_unitario: precioUnitario,
                    precio_total: precioTotal
                });
            });

            // Enviar los detalles de la venta
            $.ajax({
                url: '{{ route("venta.detalles") }}',
                method: 'POST',
                data: {
                    detalles: detalles,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log('Detalles registrados exitosamente:', response);

                    // Paso 3: Mostrar SweetAlert2 y no recargar hasta que el usuario presione aceptar
                    Swal.fire({
                        title: 'Venta registrada',
                        text: 'Venta y detalles registrados exitosamente.',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Paso 4: Abrir el modal y pasar el venta_id después de que se haya registrado todo
                            $('#ventaIdModal').val(ventaId);  // Asignamos el ID de la venta al campo oculto en el modal
                            $('#exampleModalToggle').modal('show');  // Mostrar el modal

                            // Imprimir el id de la venta en consola para asegurarnos de que es correcto
                            console.log('ID de la venta registrada:', ventaId);
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error al registrar los detalles:', error);
                    Swal.fire('Error', 'Hubo un error al registrar los detalles de la venta.', 'error');
                }
            });
        }
    </script>

    {{-- calculo del precio total --}}
    {{-- hace de todo, aumenta el valor, multiplica elimina con el menos de todo --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const totalFacturaSpan = document.getElementById('totalFactura');
            const totalProductosSpan = document.getElementById('totalProductos');

            // Función para actualizar el total general en el botón "Vender"
            function calcularTotal() {
                const montoInputs = document.querySelectorAll('.monto');
                let total = 0;

                montoInputs.forEach(input => {
                    const valor = parseFloat(input.value.replace('$', '').trim());
                    if (!isNaN(valor)) {
                        total += valor;
                    }
                });

                totalFacturaSpan.textContent = `$${total.toFixed(2)}`;
            }

            // Función para contar el número total de productos seleccionados
            function contarProductos() {
                const cantidadInputs = document.querySelectorAll('.cantidad');
                let totalProductos = 0;

                cantidadInputs.forEach(input => {
                    const cantidad = parseInt(input.value) || 0;
                    totalProductos += cantidad;
                });

                totalProductosSpan.textContent = `${totalProductos} productos`;
            }

            // Manejar cambio en el select de colores
            document.querySelectorAll('.select-color').forEach(select => {
                select.addEventListener('change', () => {
                    const productoRow = select.closest('tr'); // Encuentra la fila del producto
                    const cantidadInput = productoRow.querySelector(
                    '.cantidad'); // Encuentra el campo de cantidad
                    cantidadInput.value = 1; // Restablece el valor a 1
                    actualizarMonto(productoRow); // Actualiza el monto al cambiar el color
                    calcularTotal(); // Recalcula el total general
                    contarProductos(); // Actualiza el conteo de productos
                });
            });

            // Manejar clic en botones de restar
            document.querySelectorAll('.restar').forEach(button => {
                button.addEventListener('click', () => {
                    const input = button.parentElement.querySelector('.cantidad');
                    let currentValue = parseInt(input.value) || 1;

                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    } else if (currentValue === 1) {
                        eliminarProductoConAjax(button);
                    }

                    // Actualizar monto
                    const productoRow = button.closest('tr');
                    actualizarMonto(productoRow);
                    calcularTotal(); // Recalcula el total general
                    contarProductos(); // Actualiza el conteo de productos
                });
            });

            // Manejar clic en botones de sumar
            document.querySelectorAll('.sumar').forEach(button => {
                button.addEventListener('click', () => {
                    const input = button.parentElement.querySelector('.cantidad');
                    const maxUnidades = obtenerMaxUnidades(button);
                    let currentValue = parseInt(input.value) || 1;

                    if (currentValue < maxUnidades) {
                        input.value = currentValue + 1;
                    } else {
                        alert(
                            `No puedes seleccionar más de ${maxUnidades} unidades de este producto.`);
                    }

                    // Actualizar monto
                    const productoRow = button.closest('tr');
                    actualizarMonto(productoRow);
                    calcularTotal(); // Recalcula el total general
                    contarProductos(); // Actualiza el conteo de productos
                });
            });

            // Manejar clic en el ícono de eliminar
            document.querySelectorAll('.eliminar-producto').forEach(icon => {
                icon.addEventListener('click', (event) => {
                    event.preventDefault();
                    eliminarProductoConAjax(icon);
                });
            });

            // Función para obtener el máximo de unidades disponibles
            function obtenerMaxUnidades(button) {
                const productoRow = button.closest('tr');
                const unidadesInput = productoRow.querySelector('[id^="unidades-"]');
                return parseInt(unidadesInput.value) || 0;
            }

            // Función para eliminar el producto mediante AJAX
            function eliminarProductoConAjax(element) {
                const productoId = element.getAttribute('data-id');

                fetch("{{ route('venta.eliminar') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            producto_id: productoId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('No se pudo eliminar el producto.');
                        }
                        return response.json();
                    })
                    .then(() => {
                        const productoRow = element.closest('tr');
                        productoRow.remove(); // Elimina la fila
                        calcularTotal(); // Recalcula el total general
                        contarProductos(); // Actualiza el conteo de productos
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Función para actualizar el monto del producto
            function actualizarMonto(productoRow) {
                const precioUnitario = parseFloat(productoRow.querySelector('small').textContent.replace('$', '')
                    .trim());
                const cantidadInput = productoRow.querySelector('.cantidad');
                const cantidad = parseInt(cantidadInput.value) || 1;
                const monto = precioUnitario * cantidad;

                // Actualizamos el campo de monto
                const montoInput = productoRow.querySelector('.monto');
                montoInput.value = `$${monto.toFixed(2)}`;
            }

            // Inicializar el total y conteo al cargar la página
            calcularTotal();
            contarProductos();
        });
    </script>

    {{-- para eliminar los productos en el segundo div --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEliminar = document.querySelectorAll('.eliminar-producto');

            botonesEliminar.forEach(boton => {
                boton.addEventListener('click', function() {
                    const productoId = this.getAttribute('data-id');

                    // Enviar solicitud AJAX al servidor
                    fetch("{{ route('venta.eliminar') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                producto_id: productoId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('No se pudo eliminar el producto.');
                            }
                            return response.json();
                        })
                        .then(() => {
                            // Eliminar la fila del producto en la tabla
                            const fila = this.closest('tr');
                            fila.remove();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            });
        });
    </script>

    {{-- controla los colores en los circulos, asi como la cantidad disponible --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Selecciona todos los selects de colores
            document.querySelectorAll('.select-color').forEach(select => {
                select.addEventListener('change', function() {
                    // Obtener el option seleccionado
                    const selectedOption = this.options[this.selectedIndex];

                    // Obtener los valores del color y las unidades
                    const unidadesDisponibles = selectedOption.getAttribute('data-unidades');
                    const productoId = this.closest('tr').querySelector('input[name="producto_id"]')
                        .value;

                    // Actualizar el círculo del color
                    const colorCirculo = this.closest('tr').querySelector('.color-circulo');

                    if (selectedOption.value) { // Si hay un color seleccionado
                        const colorHex = selectedOption.getAttribute('data-color');
                        colorCirculo.style.backgroundColor = colorHex;
                        colorCirculo.style.border = 'none'; // Quitar borde
                    } else { // Si no hay color seleccionado
                        colorCirculo.style.backgroundColor = 'transparent';
                        colorCirculo.style.border = '2px solid #ccc'; // Borde visible
                    }

                    // Actualizar el input con las unidades disponibles
                    const unidadesInput = document.getElementById('unidades-' + productoId);
                    if (unidadesDisponibles && unidadesDisponibles !== "undefined") {
                        unidadesInput.value = unidadesDisponibles; // Actualiza el valor del input
                    } else {
                        unidadesInput.value = ''; // Limpia el valor si no hay unidades
                    }
                });
            });
        });
    </script>

    {{-- aqui comienzan los scrips controla el sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const isIndexPage = window.location.pathname.includes('producto'); // Ajusta según tu ruta

            if (isIndexPage) {
                // Cierra automáticamente el sidebar quitando 'expand'
                sidebar.classList.remove('expand');
            }
        });
    </script>

    {{-- controla los toolstips --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar los tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover', // El tooltip aparece al pasar el cursor
                    delay: {
                        show: 0,
                        hide: 200
                    } // Retardo de aparición y desaparición del tooltip (en milisegundos)
                });
            });
        });
    </script>

    {{-- controla los input para buscar --}}
    <script>
        document.querySelector('#search-productos').addEventListener('input', function() {
            const query = this.value
                .toLowerCase(); // Convertimos a minúsculas para comparación insensible a mayúsculas/minúsculas.
            const tableBody = document.querySelector('#tabla-productos'); // Contenedor de las filas originales.
            const allRows = Array.from(tableBody.querySelectorAll('tr')); // Guardamos todas las filas originales.

            let hasMatch = false; // Bandera para verificar si hay coincidencias.

            // Mostrar todas las filas si no hay búsqueda
            if (!query) {
                allRows.forEach(row => row.style.display = ''); // Restablecer la visibilidad
                // Eliminar mensaje de "sin coincidencias" si existe
                const noMatchRow = tableBody.querySelector('.no-match-row');
                if (noMatchRow) noMatchRow.remove();
                return;
            }

            // Filtrar y mostrar filas que coincidan con la búsqueda
            allRows.forEach(row => {
                const cells = Array.from(row.querySelectorAll(
                    'td')); // Obtenemos todas las celdas de la fila.
                const matches = cells.some(cell =>
                    cell.textContent.toLowerCase().includes(
                        query) // Comprobamos si alguna celda contiene el texto.
                );

                // Mostrar fila si coincide, ocultar si no
                row.style.display = matches ? '' : 'none';
                if (matches) hasMatch =
                    true; // Si hay al menos una coincidencia, establecemos la bandera en true.
            });

            // Verificar si no hubo coincidencias
            const noMatchRow = tableBody.querySelector(
                '.no-match-row'); // Comprobar si ya existe una fila de "sin coincidencias".
            if (!hasMatch) {
                // Si no hay coincidencias y no existe una fila de "sin coincidencias", la añadimos.
                if (!noMatchRow) {
                    const noMatchHtml = `
                        <tr class="no-match-row">
                            <td colspan="7" class="text-center">
                                <div class="alert alert-danger" role="alert">
                                    No se encontraron productos disponibles con ese nombre
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', noMatchHtml);
                }
            } else {
                // Si hay coincidencias y existe la fila de "sin coincidencias", la eliminamos.
                if (noMatchRow) noMatchRow.remove();
            }
        });
    </script>

    {{-- mantener la posicion de la pagina --}}
    <script>
        // Guardar la posición de desplazamiento al recargar la página
        window.addEventListener("beforeunload", function() {
            localStorage.setItem("scrollPosition", window.scrollY); // Guardamos la posición actual del scroll
        });

        // Restaurar la posición de desplazamiento después de cargar la página
        window.addEventListener("load", function() {
            const scrollPosition = localStorage.getItem("scrollPosition"); // Obtenemos la posición guardada

            if (scrollPosition) {
                window.scrollTo(0, scrollPosition); // Restauramos la posición guardada
                localStorage.removeItem("scrollPosition"); // Limpiamos el valor guardado en localStorage
            }
        });
    </script>




@endsection
