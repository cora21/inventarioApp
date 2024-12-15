@extends('layouts.app')
@section('nombreBarra', 'Facturar')



@section('title', 'Ventas')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

</style>
@section('contenido')
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

    <div class="container" style="height: 500px; background-color: rgb(228, 227, 227);">
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
                <div class="col-12 col-md-12 border" style="height: 300px; background-color: rgb(255, 255, 255); max-height: 420px; overflow-y: auto;">
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
                                            <input type="text" value="1" min="1"
                                                class="form-control text-center mx-2 cantidad" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Cantidad seleccionada" style="width: 80px;"
                                                readonly>
                                            <a class="sumar" data-id="{{ $producto->id }}">
                                                <i class="bi bi-plus-lg mx-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td style="width: 180px; height: 50px;">
                                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                        <!-- Select de colores -->
                                        <select name="color_id" class="form-control select-color"
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
                                                <span class="x-icon" style="color: gray; font-size: 20px;">&times;</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="width: 150px; height: 50px;">
                                        <!-- Mostrar unidades disponibles -->
                                        <input type="text" id="unidades-{{ $producto->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Cantidad disponible por color"
                                            value="{{ $producto->colores->isNotEmpty() ? $producto->colores[0]->pivot->unidadesDisponibleProducto : $producto->cantidadDisponibleProducto }}"
                                            readonly class="form-control">
                                    </td>
                                    <!-- Nueva celda para el monto calculado -->
                                    <td style="width: 170px; height: 50px;">
                                        <input type="text" value="${{ $producto->precioUnitarioProducto }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Precio total por productos" class="form-control text-center mx-2 monto" value="0" readonly
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
                    <button class="btn btn-success btn-lg d-flex justify-content-between w-100" id="procesarVenta">
                        <span>Vender</span>
                        <span id="totalFactura" style="font-weight: bold;">$729.00</span>
                    </button>
                    <a class="btn btn-outline-success  d-flex justify-content-between w-100 mt-2" id="cancelarVenta">
                        <span id="totalProductos">9 productos</span>
                        <span>Cancelar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

        {{-- hasta aqui todo funciona --}}
        {{-- calculo del precio total --}}























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

        {{-- hace de todo, aumenta el valor, multiplica elimina con el menos de todo --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Manejar cambio en el select de colores
                document.querySelectorAll('.select-color').forEach(select => {
                    select.addEventListener('change', () => {
                        const productoRow = select.closest('tr'); // Encuentra la fila del producto
                        const cantidadInput = productoRow.querySelector(
                        '.cantidad'); // Encuentra el campo de cantidad
                        cantidadInput.value = 1; // Restablece el valor a 1
                        actualizarMonto(productoRow); // Actualiza el monto al cambiar el color
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
                            alt(
                            `No puedes seleccionar más de ${maxUnidades} unidades de este producto.`);
                        }

                        // Actualizar monto
                        const productoRow = button.closest('tr');
                        actualizarMonto(productoRow);
                    });
                });

                // Función para obtener el máximo de unidades disponibles
                function obtenerMaxUnidades(button) {
                    const productoRow = button.closest('tr');
                    const unidadesInput = productoRow.querySelector('[id^="unidades-"]');
                    return parseInt(unidadesInput.value) || 0;
                }

                // Función para eliminar el producto mediante AJAX
                function eliminarProductoConAjax(button) {
                    const productoId = button.getAttribute('data-id');

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
                            const productoRow = button.closest('tr');
                            productoRow.remove();
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
                    montoInput.value = monto.toFixed(2); // Redondeamos a 2 decimales
                    // Agregar el símbolo de dólar en el input
                        montoInput.setAttribute('placeholder', `$${monto.toFixed(2)}`); // Solo visualiza el símbolo $ en el placeholder

                    // Si se requiere mostrar el símbolo directamente dentro del valor del campo
                    montoInput.value = `$${monto.toFixed(2)}`;
                                    }
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
