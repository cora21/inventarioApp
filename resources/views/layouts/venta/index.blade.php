@extends('layouts.app')
@section('nombreBarra', 'Facturar')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .sidebar {
        width: 250px;
        transition: all 0.3s ease;
    }

    .sidebar.collapsed {
        width: 0;
        overflow: hidden;
    }
    /* Animación para el deslizamiento de izquierda a derecha */
    @keyframes slideIn {
        from {
            transform: translateX(-100%); /* Comienza fuera de la pantalla (hacia la izquierda) */
            opacity: 0;
        }
        to {
            transform: translateX(0); /* Finaliza en su posición original */
            opacity: 1;
        }
    }

    .producto-fila {
        animation: slideIn 0.3s ease-in-out; /* Aplica la animación con una duración de 0.5 segundos */
    }

/* Estilos para la celda del precio */
.celda-precio {
    position: relative;
    overflow: hidden; /* Evita que el cuadro sobresalga fuera de la celda */
}

/* El cuadro emergente con animación de deslizamiento de derecha a izquierda */
.cuadro-acciones {
    position: absolute;
    top: 0;
    right: 0;
    width: 0; /* Inicialmente el cuadro tiene un ancho de 0 */
    height: 100%; /* Cubrir toda la altura de la celda */
    padding: 10px;
    background-color: #ffffff;
    display: flex;
    justify-content: space-around;
    align-items: center;
    opacity: 0;
    visibility: hidden;
    transform: translateX(100%); /* Desplazado fuera de la celda a la derecha */
    transition: transform 0.3s ease, opacity 0.3s ease, visibility 0.3s ease, width 0.3s ease;
}

/* Mostrar el cuadro emergente al pasar el ratón */
.celda-precio:hover .cuadro-acciones {
    opacity: 1;
    visibility: visible;
    transform: translateX(0); /* El cuadro se desliza hacia la izquierda */
    width: 100%; /* Expandir para cubrir todo el ancho de la celda */
}

/* Estilos para los botones dentro del cuadro */
.cuadro-acciones a {
    cursor: pointer;
    font-size: 1.5em;
    color: #333;
    transition: color 0.3s ease;
}

.cuadro-acciones a:hover {
    color: #c01e1e;
}


</style>

@section('title', 'Ventas')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@section('contenido')


    <h1>comienza el camino de las ventas</h1>
    <div class="container mt-5">
        <div class="row response">
            <!-- Cuadro 1 (3 partes) -->
            <div class="col-12 col-md-7 border" style="height: 500px; background-color: rgb(215, 224, 227);">
                <div class="py-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text border-success" style="background-color: rgb(189, 225, 201)"
                            id="search-icon">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" id="search-productos" class="form-control border-success rounded"
                            placeholder="Buscar productos">
                        <a href="{{ route('producto.index') }}" class="btn btn-outline-success ms-1" type="button">Nuevo
                            producto + </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: rgb(212, 212, 212);">
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Nombre del producto" style="border-radius: 15px 0px 0px 0px;">
                                                Producto</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Categoria donde esta registrado el producto">Categoría</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Cantidad disponible en el inventario">Cant.</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Precio Unitario">Precio</th>
                                            <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Productos disponibles en estos colores">Colores</th>
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
                                                        Sin colores
                                                    @endif
                                                </td>

                                                <td>
                                                    <a class="btn btn-success btn-sm agregar-producto"
                                                            data-precio="{{ $producto->precioUnitarioProducto }}"
                                                            data-nombre="{{ $producto->nombreProducto }}"
                                                            data-id="{{ $producto->id }}"
                                                            data-cantidad-disponible="{{ $producto->cantidadDisponibleProducto }}">
                                                        Agregar
                                                </a>

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

            <!-- SEGUNDOOO PASOOOOOO -->
            <div class="col-12 col-md-5 border response" style="height: 500px; background-color: rgb(255, 255, 255); display: flex; flex-direction: column;">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <h5 class="h3 m-0">Factura de venta</h5>
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

                <!-- Contenedor con scroll para los productos -->
                <div class="table-responsive" style="flex-grow: 1; overflow-y: auto;">
                    <table class="table table-hover border-top">
                        <tbody id="tabla-factura">
                            <!-- Los productos seleccionados aparecerán aquí -->
                        </tbody>
                    </table>
                </div>
                <!-- Espacio para los totales, pegado a la parte inferior -->
                <div class="mt-4 py-2" style="margin-top: auto;">
                    <!-- Botones de resumen y acción, alineados al final -->
                    <div style="margin-top: auto;">
                        <!-- Botón de "Vender" con el total de la factura -->
                        <!-- Botón Vender que abre el modal -->
                        <button class="btn btn-success btn-lg d-flex justify-content-between w-100"
                                id="procesarVenta">
                            <span>Vender</span>
                            <span id="totalFactura" style="font-weight: bold;">$0.00</span>
                        </button>
                        <!-- Botón con la cantidad de productos y el botón de "Cancelar" -->
                        <a class="btn btn-outline-success  d-flex justify-content-between w-100 mt-2" id="cancelarVenta">
                            <span id="totalProductos">0 productos</span>
                            <span>Cancelar</span>

                        </a>
                    </div>

                </div>
            </div>


            <!-- Modal de Detalles de la Venta -->
            <div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetallesLabel">Detalles de la Venta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #ececec">
                            <ul id="productosDetalles">
                                @foreach ($basura as $item)
                                    <li class="list-group-item">
                                        <div class="card mx-auto">
                                            <div class="card-body mx-auto">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Producto Id</label>
                                                        <input type="text" value="{{ $item->producto_id }}" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Producto Nombre</label>
                                                        <input type="text" value="{{ $item->producto_nombre }}" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="form-label">Cantidad Seleccionada</label>
                                                        <input type="text" value="{{ $item->cantidad_seleccionada }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Aquí el select para los colores -->
                                            <select class="form-select form-select-lg me-2" aria-label="Large select example" style="max-width: 300px; height: auto;">
                                                <option value="">Seleccione un color</option>
                                                @if(isset($productoColores[$item->producto_id]))
                                                    @foreach ($productoColores[$item->producto_id] as $color)
                                                        <option value="{{ $color->id }}" style="background-color: {{ $color->codigoHexa }};">{{ $color->nombreColor }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No hay colores disponibles</option>
                                                @endif
                                            </select>
                                        </div>
                                    </li>
                                @endforeach


                            </ul>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- aqui terminan las 2 columnas --}}




    {{-- scrip que maneja las ventas --}}
    <script>
        // Evento para el botón "Vender"
        document.getElementById('procesarVenta').addEventListener('click', () => {
            const filas = document.querySelectorAll('#tabla-factura tr');

            // Guardar datos
            filas.forEach(fila => {
                const idProducto = fila.id.split('-')[1];
                const nombreProducto = fila.querySelector('td span').innerText;
                const cantidadSeleccionada = fila.querySelector('.cantidad').value;

                guardarEnBasura(idProducto, nombreProducto, cantidadSeleccionada);
            });

            // Recargar la página después de guardar
            setTimeout(() => {
                location.reload(); // Recargar la página para actualizar datos
            }, 500);
        });

        // Función para guardar datos en la base de datos
        function guardarEnBasura(idProducto, nombreProducto, cantidadSeleccionada) {
            fetch('/guardar-en-basura', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    producto_id: idProducto,
                    producto_nombre: nombreProducto,
                    cantidad_seleccionada: cantidadSeleccionada,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Datos guardados:', data);
                })
                .catch(error => {
                    console.error('Error al guardar los datos:', error);
                });
        }
    </script>

    {{-- scritp que controla el borra la tabla basura --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Seleccionar el modal
            const modalDetalles = document.getElementById('modalDetalles');

            // Escuchar el evento 'hidden.bs.modal' que ocurre al cerrar el modal
            modalDetalles.addEventListener('hidden.bs.modal', function () {
                // Realizar una solicitud al servidor para eliminar los registros
                fetch('/vaciar-basura', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Token CSRF
                    },
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Tabla basura vaciada correctamente');
                    } else {
                        console.error('Error al vaciar la tabla basura');
                    }
                })
                .catch(error => console.error('Error en la solicitud:', error));
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
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    {{-- controla los input para buscar --}}
    <script>
        document.querySelector('#search-productos').addEventListener('input', function() {
            const query = this.value
                .toLowerCase(); // Convertimos a minúsculas para comparación insensible a mayúsculas/minúsculas.

            fetch(`/buscar-productos?q=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const tableBody = document.querySelector('#tabla-productos');
                    tableBody.innerHTML = '';

                    data.forEach(producto => {
                        const highlight = (text, query) => {
                            if (!query)
                                return text; // Si no hay término, devolvemos el texto original.
                            const regex = new RegExp(`(${query})`,
                                'gi'); // Creamos una expresión regular para resaltar el término.
                            return text.replace(regex,
                                '<mark style="background-color: #FFFFFFFF; color: #0F0F0FFF;">$1</mark>'
                            ); // Envolvemos la coincidencia en <mark>.
                        };

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <a href="/producto/${producto.id}">
                                    ${highlight(producto.nombreProducto, query)}
                                </a>
                            </td>
                            <td>${producto.categoria ? highlight(producto.categoria.nombre, query) : 'Sin Categoría'}</td>
                            <td>${highlight(producto.marcaProducto, query)}</td>
                            <td>${producto.cantidadDisponibleProducto}</td>
                            <td>$${producto.precioUnitarioProducto}</td>
                            <td>
                                ${
                                    producto.colores.length > 0
                                        ? producto.colores.map(color => `
                                                    <span class="badge" style="background-color: ${color.codigoHexa};"></span>
                                                `).join('')
                                        : 'Sin colores'
                                }
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm">Agregar</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    if (data.length === 0) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-danger" role="alert">
                                        No se encontraron productos disponibles con ese nombre
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error durante la búsqueda:', error);
                });
        });
    </script>

    {{-- scrips que controlan los botones de pasar los productos a la factura --}}
    <script>
        // Obtener botones y tabla de factura
            const botonesAgregar = document.querySelectorAll('.agregar-producto');
            const tablaFactura = document.getElementById('tabla-factura');

            // Función para actualizar el total de productos
            function actualizarTotalProductos() {
                let totalProductos = 0;
                const filas = document.querySelectorAll('#tabla-factura tr');
                filas.forEach(fila => {
                    const cantidad = parseInt(fila.querySelector('.cantidad').value);
                    totalProductos += cantidad;
                });
                // Actualizar el total en la interfaz
                document.getElementById('totalProductos').innerText = `${totalProductos} productos`;
            }

            // Función para actualizar el total de la factura
            function actualizarTotalFactura() {
                let totalFactura = 0;
                const filas = document.querySelectorAll('#tabla-factura tr');
                filas.forEach(fila => {
                    const precio = parseFloat(fila.querySelector('.precio').innerText.replace('$', ''));
                    totalFactura += precio;
                });
                // Actualizar el total en la interfaz
                document.getElementById('totalFactura').innerText = `$${totalFactura.toFixed(2)}`;
            }

            // Manejar el evento de clic en el botón "Agregar"
            botonesAgregar.forEach((boton) => {
                boton.addEventListener('click', () => {
                    // Obtener datos del producto
                    const precioProducto = parseFloat(boton.getAttribute('data-precio'));
                    const nombreProducto = boton.getAttribute('data-nombre');
                    const idProducto = boton.getAttribute('data-id');
                    const cantidadDisponible = parseInt(boton.getAttribute('data-cantidad-disponible')); // Cantidad disponible en el inventario

                    // Validar que el precio del producto sea un número válido
                    if (isNaN(precioProducto) || precioProducto <= 0) {
                        alert('Precio del producto no válido.');
                        return;
                    }

                    // Verificar si el producto ya está en la factura
                    const filaExistente = document.querySelector(`#producto-${idProducto}`);
                    if (filaExistente) {
                        // Si el producto ya existe, solo se actualiza la cantidad
                        const cantidadInput = filaExistente.querySelector('.cantidad');
                        let cantidadActual = parseInt(cantidadInput.value);

                        // Verificar que la cantidad no supere la disponible en inventario
                        if (cantidadActual < cantidadDisponible) {
                            cantidadInput.value = cantidadActual + 1; // Incrementar la cantidad
                            actualizarPrecio(filaExistente, precioProducto); // Actualizar precio
                        } else {
                            alert(`Solo quedan ${cantidadDisponible} unidades disponibles.`);
                        }
                    } else {
                        // Crear nueva fila para la tabla de factura
                        const fila = document.createElement('tr');
                        fila.id = `producto-${idProducto}`; // Asignar un id único al producto

                        fila.innerHTML = `
                            <td>
                                <span class="text-dark">${nombreProducto}</span>
                                <div style="font-size: 13px; color: rgb(142, 142, 142)">$${precioProducto.toFixed(2)}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a class="restar">
                                        <i class="bi bi-dash-lg mx-2"></i>
                                    </a>
                                    <input type="text" value="1" min="1" class="form-control text-center mx-2 cantidad" style="width: 80px;">
                                    <a class="sumar">
                                        <i class="bi bi-plus-lg mx-2"></i>
                                    </a>
                                </div>
                                <div class="mensaje-maximo" style="color: red; font-size: 12px; display: none;">
                                    Has alcanzado el máximo disponible.
                                </div>
                            </td>
                            <td class="celda-precio">
                                $<span class="precio">${precioProducto.toFixed(2)}</span>
                                <div class="cuadro-acciones">
                                    <a href="#" class="eliminar"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        `;

                        // Agregar fila a la tabla de factura
                        tablaFactura.appendChild(fila);

                        // Agregar la clase de animación a la fila recién agregada
                        fila.classList.add('producto-fila'); // Esta clase contiene la animación CSS

                        // Manejar eventos de la fila recién creada
                        manejarEventosFila(fila, precioProducto, cantidadDisponible);
                    }

                    // Actualizar el total de la factura y productos
                    actualizarTotalFactura();
                    actualizarTotalProductos();
                });
            });

            // Función para manejar eventos en la fila
            function manejarEventosFila(fila, precioProducto, cantidadDisponible) {
                // Botón restar cantidad
                fila.querySelector('.restar').addEventListener('click', () => {
                    const input = fila.querySelector('.cantidad');
                    let cantidadActual = parseInt(input.value);

                    if (cantidadActual > 1) {
                        input.value = cantidadActual - 1; // Reducir la cantidad
                        actualizarPrecio(fila, precioProducto); // Actualizar el precio
                    } else {
                        fila.remove(); // Eliminar la fila de la tabla
                    }

                    // Actualizar el total de la factura y productos
                    actualizarTotalFactura();
                    actualizarTotalProductos();
                });

                // Botón sumar cantidad
                fila.querySelector('.sumar').addEventListener('click', () => {
                    const input = fila.querySelector('.cantidad');
                    let cantidadActual = parseInt(input.value);

                    if (cantidadActual < cantidadDisponible) {
                        input.value = cantidadActual + 1; // Incrementar la cantidad
                        actualizarPrecio(fila, precioProducto); // Actualizar el precio
                        ocultarMensaje(fila); // Ocultar el mensaje si la cantidad es válida
                    } else {
                        mostrarMensaje(fila); // Mostrar mensaje si la cantidad excede
                    }

                    // Actualizar el total de la factura y productos
                    actualizarTotalFactura();
                    actualizarTotalProductos();
                });

                // Evento para el botón eliminar (eliminar la fila)
                fila.querySelector('.eliminar').addEventListener('click', (event) => {
                    event.preventDefault(); // Evitar que se recargue la página
                    fila.remove(); // Eliminar la fila de la tabla
                    // Actualizar el total de la factura y productos
                    actualizarTotalFactura();
                    actualizarTotalProductos();
                });
            }

            // Función para actualizar el precio total al cambiar la cantidad
            function actualizarPrecio(fila, precioProducto) {
                const cantidad = fila.querySelector('.cantidad').value;
                const totalPrecio = precioProducto * parseInt(cantidad); // Calcular el precio total
                fila.querySelector('.precio').innerText = totalPrecio.toFixed(2); // Actualizar el precio total en la tabla
            }

            // Función para mostrar el mensaje de "Has alcanzado el máximo disponible"
            function mostrarMensaje(fila) {
                const mensaje = fila.querySelector('.mensaje-maximo');
                mensaje.style.display = 'block'; // Mostrar mensaje
            }

            // Función para ocultar el mensaje de "Has alcanzado el máximo disponible"
            function ocultarMensaje(fila) {
                const mensaje = fila.querySelector('.mensaje-maximo');
                mensaje.style.display = 'none'; // Ocultar mensaje
            }

    </script>


    @if(count($basura) > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function () {
                // Crear una instancia del modal y mostrarlo si hay registros
                const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'));
                modalDetalles.show();
        });
    </script>
    @endif


@endsection
