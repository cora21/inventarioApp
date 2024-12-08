@extends('layouts.app')
@section('nombreBarra', 'Facturar')
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
                        <a href="{{ route('producto.index') }}" class="btn btn-outline-primary ms-1" type="button">Nuevo
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
                                                    <button class="btn btn-primary btn-sm agregar-producto"
                                                        data-precio="{{ $producto->precioUnitarioProducto }}"
                                                        data-nombre="{{ $producto->nombreProducto }}"
                                                        data-id="{{ $producto->id }}"
                                                        data-cantidad-disponible="{{ $producto->cantidadDisponibleProducto }}">
                                                        Agregar
                                                    </button>
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
            <div class="col-12 col-md-5 border response" style="height: 500px; background-color: rgb(255, 255, 255);">
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

                <div class="table-responsive">
                    <table class="table table-hover border-top">
                        <tbody id="tabla-factura">
                            <!-- Productos seleccionados aparecerán aquí -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    {{-- aqui terminan las 2 columnas --}}

    {{-- aqui comienza la ventana derecha para editar --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom" style="background-color: white;">
            <h3 class="offcanvas-title" id="offcanvasRightLabel">Editar Venta</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="background-color: white;">
            <div class="py-4 border-bottom">
                Sección de la factura
            </div>
            <br>
            <!-- Campos de entrada -->
            <div class="row">
                <div class="col-md-6">
                    <label for="precioBaseCanvas" class="form-label">Precio Base</label>
                    <input type="text" class="form-control" id="precioBaseCanvas">
                </div>
                <div class="col-md-6">
                    <label for="cantidadCanvas" class="form-label">Cantidad</label>
                    <input type="text" class="form-control" id="cantidadCanvas">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="descuento" class="form-label">Descuento (%)</label>
                    <input type="text" class="form-control" id="descuento">
                </div>
                <div class="col-md-6">
                    <label for="precioTotalCanvas" class="form-label">Precio final</label>
                    <input type="text" class="form-control" id="precioTotalCanvas" readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="descripcionCanvas" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcionCanvas" rows="3" style="resize: none"></textarea>
                </div>
            </div>
            <br>
            <div id="dynamicFieldsContainer">
                <div class="row align-items-center gy-2 dynamic-row">
                    <div class="col-md-3">
                        <label for="ColorDisponibleCnavas" class="form-label">Colores:</label>
                        <select id="ColorDisponibleCnavas" class="form-select">
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="CantidadDisponibleCanvas" class="form-label">Cantidad:</label>
                        <input type="text" id="CantidadDisponibleCanvas" class="form-control">
                    </div>
                    <div class="col-md-2 d-grid">
                        <i id="eliminarColor" class="bi bi-dash-lg text-danger fs-3 mt-4" style="cursor: pointer;"></i>
                    </div>
                    <div class="col-md-2 d-grid">
                        <i id="agregarColor" class="bi bi-plus-lg text-primary fs-3 mt-4" style="cursor: pointer;"></i>
                    </div>
                </div>
            </div>
            <br><br><br><br><br><br>
            <!-- Sección de subtotal, descuento y total -->
            <div class="p-3" style="background-color: #f0f8ff; border-radius: 5px;">
                <div class="row">
                    <div class="col-6">
                        <h5>Subtotal:</h5>
                    </div>
                    <div class="col-6 text-end">
                        <h5 id="subtotalDisplay">$0.00</h5>
                    </div>
                </div>
                <div id="discountSection" class="row" style="display: none;">
                    <div class="col-6">
                        <h5>Descuento:</h5>
                    </div>
                    <div class="col-6 text-end text-danger">
                        <h5 id="discountDisplay">- $0.00</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h4>Total:</h4>
                    </div>
                    <div class="col-6 text-end">
                        <h4 id="totalDisplay">$0.00</h4>
                    </div>
                </div>
            </div>
            <br>
            <!-- Botones de acción -->
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-primary me-3" data-bs-dismiss="offcanvas">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>











    {{-- aqui comienzan los scrips --}}
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
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

            // Función para actualizar el total de la factura
            function actualizarTotalFactura() {
                let totalFactura = 0;
                const filas = document.querySelectorAll('#tabla-factura tr');
                filas.forEach(fila => {
                    const precio = parseFloat(fila.querySelector('.precio').innerText.replace('$', ''));
                    totalFactura += precio;
                });
                // Actualizar el total en la interfaz
                document.getElementById('total-factura').innerText = `$${totalFactura.toFixed(2)}`;
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
                                <!-- Aquí va el mensaje que inicialmente está oculto -->
                                <div class="mensaje-maximo" style="color: red; font-size: 12px; display: none;">
                                    Has alcanzado el máximo disponible.
                                </div>

                            </td>
                            <td class="celda-precio ">
                                $<span class="precio">${precioProducto.toFixed(2)}</span>
                                <div class="cuadro-acciones">
                                    <a class="editar" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-pencil"></i></a></a>
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

                    // Actualizar el total de la factura
                    actualizarTotalFactura();
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

                    // Actualizar el total de la factura
                    actualizarTotalFactura();
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
            });
                // Evento para el botón eliminar (eliminar la fila)
                fila.querySelector('.eliminar').addEventListener('click', (event) => {
                    event.preventDefault(); // Evitar que se recargue la página
                        fila.remove(); // Eliminar la fila de la tabla
                    // Actualizar el total de la factura
                    actualizarTotalFactura();
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

    {{-- scrips para el canvas --}}
    <script>
        const precioBaseInput = document.getElementById('precioBaseCanvas');
        const cantidadInput = document.getElementById('cantidadCanvas');
        const descuentoInput = document.getElementById('descuento');
        const precioTotalInput = document.getElementById('precioTotalCanvas');
        const subtotalDisplay = document.getElementById('subtotalDisplay');
        const totalDisplay = document.getElementById('totalDisplay');
        const discountDisplay = document.getElementById('discountDisplay');
        const discountSection = document.getElementById('discountSection');

        // Añadir eventos para recalcular cuando cambien los valores
        precioBaseInput.addEventListener('input', calculateTotal);
        cantidadInput.addEventListener('input', calculateTotal);
        descuentoInput.addEventListener('input', calculateTotal);

        function calculateTotal() {
            // Obtener los valores
            const precioBaseCanvas = parseFloat(precioBaseInput.value) || 0;
            const cantidadCanvas = parseInt(cantidadInput.value) || 0;
            const descuento = parseFloat(descuentoInput.value) || 0;

            // Calcular el subtotal
            let subtotal = precioBaseCanvas * cantidadCanvas;

            // Calcular el descuento y el total
            let descuentoValor = 0;
            if (descuento > 0) {
                descuentoValor = subtotal * (descuento / 100);
            }
            let total = subtotal - descuentoValor;

            // Mostrar u ocultar la sección de descuento
            if (descuentoValor > 0) {
                discountSection.style.display = 'flex';
                discountDisplay.textContent = `- $${descuentoValor.toFixed(2)}`;
            } else {
                discountSection.style.display = 'none';
            }

            // Actualizar los valores en pantalla
            subtotalDisplay.textContent = `$${subtotal.toFixed(2)}`;
            totalDisplay.textContent = `$${total.toFixed(2)}`;
            precioTotalInput.value = total.toFixed(2);
        }
    </script>



    {{-- aqui es el scrip que genera los select de colores para estar pila sera cambiado mas adelante --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('dynamicFieldsContainer');

            // Delegación de eventos para manejar los botones agregar y eliminar
            container.addEventListener('click', (event) => {
                const target = event.target;

                if (target.id === 'agregarColor') {
                    // Crear un nuevo grupo de campos
                    const newRow = document.createElement('div');
                    newRow.className = 'row align-items-center gy-2 dynamic-row';
                    newRow.innerHTML = `
                        <div class="col-md-3">
                            <label for="ColorDisponibleCnavas" class="form-label">Colores:</label>
                            <select id="ColorDisponibleCnavas" class="form-select">
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="yellow">Yellow</option>
                                <option value="purple">Purple</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="CantidadDisponibleCanvas" class="form-label">Cantidad:</label>
                            <input type="text" id="CantidadDisponibleCanvas" class="form-control">
                        </div>
                        <div class="col-md-2 d-grid">
                            <i id="eliminarColor" class="bi bi-dash-lg text-danger fs-3 mt-3" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-md-2 d-grid">
                        <i id="agregarColor" class="bi bi-plus-lg text-primary fs-3 mt-3" style="cursor: pointer;"></i>
                        </div>

                    `;
                    container.appendChild(newRow);
                } else if (target.id === 'eliminarColor') {
                    // Eliminar la fila correspondiente
                    const rowToDelete = target.closest('.dynamic-row');
                    if (rowToDelete) {
                        rowToDelete.remove();
                    }
                }
            });
        });
    </script>
@endsection
