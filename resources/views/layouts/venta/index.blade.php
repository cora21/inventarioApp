@extends('layouts.app')
{{-- @section('nombreBarra', 'Generar Venta') --}}
{{--
        OJOOOOOOOO
        totalDescontable es el total original recuerdalooooooooooooooooo


        de donde eliminaremos es de cantidadDisponibleProducto

        SUPER OJOOOOOOOO
--}}


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
        transition: all 0.3s ease;
        /* Transición suave */
        border: 2px solid transparent;
        /* Sin borde visible por defecto */
        cursor: pointer;
        /* Cambia el cursor a manito */
    }

    .payment-card:hover {
        border: 10px solid #146d28;
        /* Borde verde al pasar el cursor */
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        /* Sombra verde suave */
        transform: scale(1.1);
        /* Ligero aumento de tamaño */
    }

    #selectedPaymentMethod,
    #totalVentaModal {
        visibility: visible !important;
        display: inline-block !important;
        color: #000 !important;
        /* Asegurar que el texto sea visible */
    }

    /* aqui comienzan los estilos para las fotos pequeñas de los productos, en ventas */
    .product-cell {
        position: relative;
        white-space: nowrap;
    }

    .product-preview-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Espacio entre el texto y la imagen */
        position: relative;
        z-index: 1;
    }

    .product-link {
        color: #3d8edf;
        /* Asegura que mantenga el color azul */
        text-decoration: underline;
        /* Opcional: para que se vea como enlace */
        flex-shrink: 0;
        /* Evita que el texto se encime con la imagen */
    }

    .product-thumbnail {
        display: none;
        position: absolute;
        left: 100%;
        /* A la derecha del contenedor */
        top: 50%;
        transform: translateY(-50%);
        z-index: 9999;
        background: white;
        border: 1px solid #ccc;
        padding: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        width: 60px;
        height: auto;
    }

    .product-thumbnail img {
        width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .product-preview-wrapper:hover .product-thumbnail {
        display: block;
    }

    /* Eliminar dentro del mismo td */
    .equis-eliminar {
        position: absolute;
        top: 4px;
        right: 6px;
        font-size: 18px;
        color: #777;
        transition: color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
        z-index: 2;
    }

    .equis-eliminar:hover {
        color: red;
        transform: scale(1.3);
    }
</style>
@section('contenido')
    <input type="hidden" id="dolarBCV" class="form-control" value="{{ $dolarBCV }}">

    <div class="container-fluid">
        <div class="row">
            <!-- Columna izquierda: Lista de productos -->
            <div class="col-12 col-lg-7">
                <div class="container">
                    <div class="row response">
                        <div class="col-12 col-md-12 border" style="height: 500px; background-color: rgb(215, 224, 227);">
                            <div class="py-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-success"
                                        style="background-color: rgb(189, 225, 201)" id="search-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="search" id="search-productos" class="form-control border-success rounded"
                                        placeholder="Buscar productos por nombre o marca...">
                                    <a href="{{ route('producto.index') }}" class="btn btn-outline-success ms-1"
                                        type="button">Nuevo
                                        producto + </a>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                            <table class="table w-100">
                                                <thead style="position: sticky; top: 0; z-index: 100;">
                                                    <tr style="background-color: rgb(212, 212, 212);">
                                                        <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Nombre del producto"
                                                            style="border-radius: 15px 0px 0px 0px;">
                                                            Producto
                                                        </th>
                                                        <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Categoria donde esta registrado el producto">
                                                            Categoría
                                                        </th>
                                                        <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Cantidad disponible en el inventario">Cant.</th>
                                                        <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Precio Unitario">Precio</th>
                                                        <th scope="col" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Productos disponibles en estos colores">Colores</th>
                                                        <th scope="col" style="border-radius: 0px 15px 0px 0px;"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Agrega Productos a la factura">Agregar
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabla-productos">
                                                    @foreach ($producto as $producto)
                                                        <tr>
                                                            <td class="product-cell">
                                                                <div class="product-preview-wrapper">
                                                                    <a href="{{ route('producto.show', $producto->id) }}"
                                                                        class="product-link">
                                                                        {{ $producto->nombreProducto }}
                                                                    </a>

                                                                    @if ($producto->imagenes->isNotEmpty())
                                                                        <span class="product-thumbnail">
                                                                            <img src="{{ asset($producto->imagenes->first()->ruta) }}"
                                                                                alt="Miniatura del producto" />
                                                                        </span>
                                                                    @else
                                                                        <!-- No hay imagen disponible -->
                                                                    @endif

                                                                </div>
                                                            </td>
                                                            {{-- <td>
                                                                <a href="{{ route('producto.show', $producto->id) }}">{{ $producto->nombreProducto }}</a>
                                                            </td> --}}
                                                            <td>{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td>
                                                            <td>{{ $producto->cantidadDisponibleProducto }}</td>
                                                            @if ($vesBaseMoneda === 1)
                                                                <td>Bs.{{ number_format($producto->precioUnitarioProducto * $dolarBCV, 2) }}
                                                                    <br>
                                                                    <small
                                                                        style="color: gray; font-size: 0.8em;">${{ $producto->precioUnitarioProducto }}
                                                                    </small>
                                                                </td>
                                                            @else
                                                                <td>${{ $producto->precioUnitarioProducto }}
                                                                    <br>
                                                                    <small
                                                                        style="color: gray; font-size: 0.8em;">Bs.{{ number_format($producto->precioUnitarioProducto * $dolarBCV, 2) }}
                                                                    </small>
                                                                </td>
                                                            @endif
                                                            {{-- <td>${{ $producto->precioUnitarioProducto }}</td> --}}
                                                            <td>
                                                                @if ($producto->colores->isNotEmpty())
                                                                    @foreach ($producto->colores as $color)
                                                                        @if (empty($color->codigoHexa))
                                                                            <!-- Círculo con una X en el medio -->
                                                                            <span data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="Productos sin color asignado"
                                                                                class="badge d-inline-block"
                                                                                style="display: inline-block; width: 20px; height: 20px; background-color: #fff; border-radius: 50%; border: 2px solid #ccc; position: relative; text-align: center; line-height: 20px;">
                                                                                <span
                                                                                    style="font-size: 14px; color: #ccc; position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; justify-content: center; align-items: center;">✖</span>
                                                                            </span>
                                                                        @else
                                                                            <!-- Círculo con el color -->
                                                                            <span class="badge d-inline-block"
                                                                                style="display: inline-block; width: 20px; height: 20px; background-color: {{ $color->codigoHexa }}; border-radius: 50%; {{ strtolower($color->codigoHexa) == '#ffffff' ? 'border: 2px solid #ccc;' : '' }}"></span>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    Sin colores disponibles
                                                                @endif
                                                            </td>
                                                            <!-- En el primer div, donde el usuario agrega productos -->
                                                            <td style="position: relative;">
                                                                <div>
                                                                    <form action="{{ route('venta.agregar') }}"
                                                                        method="POST" style="display: inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="producto_id"
                                                                            value="{{ $producto->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm btn-agregar"
                                                                            id="btn-agregar-{{ $producto->id }}"
                                                                            data-id="{{ $producto->id }}"
                                                                            data-cantidadDisponibleProducto="{{ $producto->cantidadDisponibleProducto }}">
                                                                            +
                                                                        </button>
                                                                    </form>
                                                                </div>
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
            </div>

            <!-- Columna derecha: Factura de venta -->
            <div class="col-12 col-lg-5">
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
                                <table id="tabla-agregados" class="table table-hover align-middle text-center">
                                    <tbody>
                                        @foreach ($productosAgregados as $producto)
                                            <tr id="producto-{{ $producto->id }}">

                                                {{-- 1. Nombre + Precio  / Unidades disponibles --}}
                                                <td style="width: 250px;">
                                                    <div class="text-center mb-2">
                                                        <strong>{{ $producto->nombreProducto }}</strong><br>
                                                        <small
                                                            style="color: gray;">${{ $producto->precioUnitarioProducto }}</small>
                                                    </div>
                                                    <input type="text" id="unidades-{{ $producto->id }}"
                                                        class="form-control text-center"
                                                        value="{{ $producto->colores->isNotEmpty() ? $producto->colores[0]->pivot->unidadesDisponibleProducto : $producto->cantidadDisponibleProducto }}"
                                                        readonly style="width: 60px;">
                                                </td>
                                                {{-- Celda 2: Select Colores / Cantidad seleccionada --}}
                                                <td style="width: 250px;">
                                                    <input type="hidden" name="producto_id"
                                                        value="{{ $producto->id }}">
                                                    <select name="colorIdVenta" class="form-control select-color mb-2"
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
                                                            <option value="" disabled selected>Color no disponible
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <a class="restar" data-id="{{ $producto->id }}">
                                                            <i class="bi bi-dash-lg mx-2"></i>
                                                        </a>
                                                        <input type="text" name="cantidadSelecionadaVenta"
                                                            value="1" min="1"
                                                            class="form-control text-center mx-1 cantidad"
                                                            style="width: 60px;" readonly data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Cantidad seleccionada">
                                                        <a class="sumar" data-id="{{ $producto->id }}"
                                                            data-cantDisponible="{{ $producto->cantidadDisponibleProducto }}">
                                                            <i class="bi bi-plus-lg mx-2"></i>
                                                        </a>
                                                    </div>
                                                </td>

                                                {{-- 3. Círculo de color / Monto calculado --}}
                                                <td class="td-color-monto" style="width: 200px; position: relative;">
                                                    {{-- Botón eliminar en la esquina superior derecha --}}
                                                    <a href="#" class="eliminar-producto"
                                                        data-id="{{ $producto->id }}" onclick="event.preventDefault();">
                                                        <span class="equis-eliminar" title="Eliminar">&times;</span>
                                                    </a>

                                                    {{-- Círculo de color --}}
                                                    <div class="text-center mb-2">
                                                        @php $hexa = $producto->colores[0]->codigoHexa ?? null; @endphp
                                                        @if ($hexa)
                                                            <div class="color-circulo mx-auto"
                                                                style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $hexa }};{{ $hexa == '#FFFFFF' ? 'border: 2px solid #928f8f;' : '' }}">
                                                            </div>
                                                        @else
                                                            <div class="color-circulo disabled mx-auto"
                                                                style="width: 30px; height: 30px; border-radius: 50%; background-color: transparent; border: 2px solid #928f8f; display: flex; align-items: center; justify-content: center;">
                                                                <span class="x-icon" style="color: gray;">&times;</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    {{-- Monto total --}}
                                                    <input type="text" class="form-control text-center monto"
                                                        value="${{ $producto->precioUnitarioProducto }}"
                                                        data-bs-toggle="tooltip" title="Precio total por productos"
                                                        readonly style="width: 90px;">
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>

                        <div class="mt-4 py-2 d-flex sticky-bottom"
                            style="margin-top: auto; flex-direction: column; height: 100%;">
                            <div style="margin-top: auto;">
                                {{-- data-bs-target="#exampleModalToggle" data-bs-toggle="modal" --}}
                                <button class="btn btn-success btn-lg d-flex justify-content-between w-100"
                                    id="procesarVenta" style="padding: 10px; font-size: 1.5rem; width: 150%;">
                                    <span>Vender</span>
                                    <span id="totalFactura" style="font-weight: bold;">$0.00</span>
                                </button>
                                <a class="btn btn-success btn-lg d-flex justify-content-between w-100 mt-2"
                                    style="padding: 10px; font-size: 1rem; width: 150%;">
                                    <span>Total en Bolívares:</span>
                                    <span id="totalBolivares" style="font-weight: bold;">Bs. 0.00</span>
                                </a>

                            </div>
                        </div>
                    </div>
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
                    <div class="container mt-3">
                        <!-- Aquí agregamos un campo oculto para almacenar el venta_id -->
                        <input type="hidden" id="ventaIdModal" name="venta_id" value="">

                        <!-- Mostrar el monto total de la venta en grande -->
                        <div class="text-center mb-4">
                            <h4><strong>Total de la venta: </strong><span id="totalVentaModal"
                                    style="font-size: 2rem;">$0.00</span></h4>
                        </div>

                        <div class="row justify-content-center">
                            @foreach ($metPago as $row)
                                @php
                                    $isCombinado = $row->id == 5 && $row->nombreMetPago == 'Combinado';
                                @endphp
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-3 payment-card-item"
                                    data-bs-target="{{ $isCombinado ? '#modalCombinado' : '#exampleModalToggle2' }}"
                                    data-bs-toggle="modal" data-method-id="{{ $row->id }}"
                                    data-method-name="{{ $row->nombreMetPago }}">
                                    <div class="bg-light border p-2 text-center payment-card">
                                        <div class="mb-2">
                                            @if ($row->imagenMetPago)
                                                <a>
                                                    <img src="{{ $row->imagenMetPago }}" alt="Imagen del método"
                                                        class="img-fluid rounded" style="max-width: 50px;">
                                                </a>
                                            @else
                                                <div class="text-muted">
                                                    <i class="bi bi-bank" style="font-size: 2.5rem;"></i>
                                                    <br>
                                                </div>
                                            @endif
                                            <h6 class="fw-bold text-secondary mb-1">{{ $row->nombreMetPago }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row justify-content-center">
                            {{-- <div class="col-lg-3 col-md-5 col-sm-12 mb-3">
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
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- final del primer modal --}}
    {{-- segunda parte modal 2 --}}
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3" id="exampleModalToggleLabel2">Pagar factura paso 2</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Botón para regresar al primer modal -->
                    <button class="btn btn-outline-success" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                        <i class="bi bi-arrow-down-up"></i> Regresar al primer modal
                    </button>
                    <br><br>

                    <!-- Mostrar el método de pago seleccionado -->
                    <p>
                        <strong>Método de pago seleccionado: </strong>
                        <span id="selectedPaymentMethod" class="text-success">Ninguno</span>
                    </p>

                    <!-- Campo oculto para el ID del método de pago -->
                    <input type="hidden" id="paymentMethodId" name="payment_method_id">

                    <!-- Campo oculto para el ID de la venta -->
                    <input type="hidden" id="ventaIdModal" name="venta_id">

                    <!-- Mostrar el total de la venta -->
                    <div class="text-center mb-4">
                        <h3><strong>Total de la venta:</strong>
                            <span id="totalVentaSpan" style="font-size: 2rem;"></span>
                        </h3>
                    </div>

                    <!-- Contenido específico para el método "Combinado" -->
                    <div id="modalContent"></div>

                    <!-- Resto del contenido del modal (campos regulares) -->
                    <div class="container mt-3 regular-fields">
                        <div class="card">
                            <div class="container mt-3">
                                <div class="row m-3">
                                    <!-- Columna Izquierda -->
                                    <div class="col-md-6 border-end">
                                        <div class="mb-3 pb-2 border-bottom">
                                            <label for="valorPago" class="form-label fw-bold">Valor del pago: *</label>
                                            <input type="number" class="form-control" id="valorPago"
                                                placeholder="Ingresa el valor">
                                        </div>

                                        <!-- Opciones rápidas -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Opciones rápidas</label>
                                            <div id="opcionesRapidas">
                                                <!-- Los botones se generarán aquí dinámicamente -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna Derecha -->
                                    <div class="col-md-6">
                                        <label for="descripcionPago" class="form-label fw-bold">Observaciones</label>
                                        <textarea class="form-control" name="descripcionPago" id="descripcionPago" rows="5"
                                            placeholder="Ingresa tu observación"></textarea>
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="mb-3">
                                        <label for="nombrePago" class="form-label fw-bold">Moneda</label>
                                        <select class="form-control" id="nombrePago">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($tasas as $row)
                                                <option value="{{ $row->nombreMoneda }}">{{ $row->nombreMoneda }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnGuardarPago">Guardar</button>
                        </div>
                    </div>

                    <!-- Campos principales para los campos Combinados -->
                    <div id="combinadoFields" class="card mt-3" style="display: none;">
                        <div class="card-body">
                            <!-- Primera fila (modelo) -->
                            <div class="row m-3 combinado-row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="select1" class="form-label fw-bold">Método Pago:</label>
                                        <select class="form-control select1">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($metPago as $row)
                                                @if ($row->nombreMetPago !== 'Combinado')
                                                    <option value="{{ $row->id }}">{{ $row->nombreMetPago }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="input1" class="form-label fw-bold">Valor del Pago:</label>
                                        <input type="text" required class="form-control input1" placeholder="0.00"
                                            pattern="^\d+(\.\d{1,2})?$"
                                            title="Ingrese un monto válido con hasta dos decimales">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nombrePago" style="width: 50%;" class="form-label fw-bold">Moneda de
                                            Pago:</label>
                                        <select class="form-control" id="nombrePago" name="nombrePago">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($tasas as $row)
                                                <option value="{{ $row->nombreMoneda }}">{{ $row->nombreMoneda }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Botones para agregar y eliminar fila -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-add me-2">
                                    <i class="bi bi-plus-lg"></i> <!-- Icono de + -->
                                </button>
                                <button type="button" class="btn btn-danger btn-remove">
                                    <i class="bi bi-trash"></i> <!-- Icono de basura -->
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnGuardarPagoCombinado">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- final del segundo modal --}}


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

                    // Verificar la reversión de estado del botón "Agregar"
                    const productoId = button.getAttribute('data-id'); // Obtener el ID del producto
                    let totalCantidad = 0;
                    const cantDisponible = parseInt(document.querySelector(
                        `#btn-agregar-${productoId}`).getAttribute(
                        'data-cantidadDisponibleProducto'));

                    // Calcular el total de cantidad actual para el producto
                    document.querySelectorAll('.cantidad').forEach(input => {
                        const inputId = input.closest('tr').querySelector('.sumar')
                            .getAttribute('data-id');
                        if (inputId === productoId) {
                            totalCantidad += parseInt(input.value) || 0;
                        }
                    });

                    // Obtener el botón "Agregar" correspondiente
                    const btnAgregar = document.querySelector(`#btn-agregar-${productoId}`);
                    if (btnAgregar) {
                        if (totalCantidad < cantDisponible) {
                            // Revertir el estado del botón a habilitado
                            btnAgregar.style.backgroundColor = ""; // Restaurar color original
                            btnAgregar.style.color = ""; // Restaurar color original del texto
                            btnAgregar.disabled = false; // Habilitar el botón
                        }
                    }

                    // Actualizar monto
                    const productoRow = button.closest('tr');
                    actualizarMonto(productoRow);
                    calcularTotal(); // Recalcula el total general
                    contarProductos(); // Actualiza el conteo de productos
                });
            });




            // Manejar clic en botones de sumar
            // Manejar clic en botones de sumar
            document.querySelectorAll('.sumar').forEach(button => {
                button.addEventListener('click', () => {
                    const input = button.parentElement.querySelector('.cantidad');
                    const maxUnidades = obtenerMaxUnidades(button);
                    let currentValue = parseInt(input.value) || 1;
                    let totalCantidad = 0;

                    // Obtener el ID del producto
                    const productoId = button.getAttribute('data-id');

                    // Obtener directamente el valor de data-cantDisponible desde el botón
                    const cantDisponible = button.getAttribute('data-cantDisponible');

                    // Calcular la suma total de las cantidades de filas con el mismo data-id
                    document.querySelectorAll('.cantidad').forEach(input => {
                        const inputId = input.parentElement.querySelector('.sumar')
                            .getAttribute('data-id');
                        if (inputId === productoId) {
                            totalCantidad += parseInt(input.value) || 0;
                        }
                    });

                    // Verificar si el input existe
                    console.log(`Cantidad Disponible: ${cantDisponible}`);
                    console.log(`Total Cantidad: ${totalCantidad}`);


                    if (totalCantidad >= cantDisponible) {
                        alert("Ya no quedan unidades disponibles.");
                        const btnAgregar = document.querySelector(`#btn-agregar-${productoId}`);
                        if (btnAgregar) {
                            btnAgregar.style.backgroundColor = "gray"; // Fondo gris
                            btnAgregar.style.color = "black"; // Letras negras
                            btnAgregar.disabled = true; // Deshabilitar el botón
                        } else {
                            const btnAgregar = document.querySelector(`#btn-agregar-${productoId}`);
                            if (btnAgregar) {
                                btnAgregar.style.backgroundColor = ""; // Restaurar color original
                                btnAgregar.style.color = ""; // Restaurar color original del texto
                                btnAgregar.disabled = false; // Habilitar el botón
                            }
                        }


                    } else if (currentValue >= maxUnidades) {
                        alert(
                            `No puedes seleccionar más de ${maxUnidades} unidades de este producto.`
                        );
                    } else {
                        input.value = currentValue + 1;
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const totalFacturaSpan = document.getElementById('totalFactura'); // Total en dólares
            const totalBolivaresSpan = document.getElementById('totalBolivares'); // Total en bolívares
            const dolarBCVInput = document.getElementById('dolarBCV'); // Input con el valor del dólar

            // Función para calcular y mostrar el total en bolívares
            function actualizarTotalBolivares() {
                // Obtener el total en dólares del contenido del span
                const totalDolares = parseFloat(totalFacturaSpan.textContent.replace('$', '').trim());
                const dolarBCV = parseFloat(dolarBCVInput.value);

                // Verificar que ambos valores sean válidos
                if (!isNaN(totalDolares) && !isNaN(dolarBCV)) {
                    const totalBolivares = totalDolares * dolarBCV;
                    totalBolivaresSpan.textContent = `Bs. ${totalBolivares.toFixed(2)}`;
                } else {
                    console.error('El total en dólares o el valor del dólar BCV no son válidos.');
                    totalBolivaresSpan.textContent = 'Bs. 0.00';
                }
            }

            // Llamar a actualizarTotalBolivares() en la carga inicial
            actualizarTotalBolivares();

            // Observador para detectar cambios en el total en dólares
            const observer = new MutationObserver(() => {
                actualizarTotalBolivares();
            });

            // Configurar el observador para el span del total en dólares
            observer.observe(totalFacturaSpan, {
                childList: true,
                characterData: true
            });
        });
    </script>

    {{-- guardar en metodo combinado tiene ajax --}}
    <script>
        $(document).ready(function() {
            $('#btnGuardarPagoCombinado').click(function() {
                let ventaId = $('#ventaIdModal').val();
                let totalVentaText = $('#totalVentaSpan').text();
                let totalVenta = parseFloat(totalVentaText.replace(/[^0-9.-]+/g, "")) || 0;
                totalVenta = redondear(totalVenta);

                function redondear(valor) {
                    return Math.round(valor * 100) / 100;
                }

                let sumaMontos = 0;
                let pagos = [];

                $('.combinado-row').each(function() {
                    let metodoPagoId = $(this).find('.select1').val();
                    let monto = parseFloat($(this).find('.input1').val()) || 0;
                    let nombrePago = $(this).find('#nombrePago').val();

                    monto = redondear(monto);

                    if (!esMontoValido(monto)) {
                        console.error("Monto inválido");
                        return;
                    }

                    if (metodoPagoId && monto > 0) {
                        pagos.push({
                            venta_id: ventaId,
                            metodo_pago_id: metodoPagoId,
                            monto: monto,
                            nombrePago: nombrePago
                        });
                        sumaMontos += monto;
                    }
                });

                sumaMontos = redondear(sumaMontos);

                console.log("ID de la venta:", ventaId);
                console.log("Total de la venta:", totalVenta);
                console.log("Suma de los montos ingresados:", sumaMontos);
                console.log("Detalles de los pagos:", pagos);

                if (sumaMontos !== totalVenta) {
                    console.warn("La suma de los pagos no coincide con el total de la venta.");
                } else {
                    $.ajax({
                        url: 'venta/guardar-pagos-combinados', // Asegúrate de que esta ruta esté correcta
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token para seguridad
                            pagos: pagos // El array de pagos
                        },
                        success: function(response) {
                            if (response.success) {
                                // Mostrar alerta de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: response.message, // Mensaje de éxito
                                    confirmButtonText: 'Aceptar'
                                }).then(function() {
                                    // Recargar la página después de hacer clic en "Aceptar"
                                    location.reload(); // Recarga la página
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Manejo de errores
                        }
                    });
                }
            });
        });

        function esMontoValido(monto) {
            return /^\d+(\.\d{1,2})?$/.test(monto);
        }
    </script>
    {{-- calcular las opciones rapidas tiene ajax guarda pagos individuales --}}
    <script>
        // Evento al abrir el segundo modal para generar montos sugeridos
        $('#exampleModalToggle2').on('show.bs.modal', function() {
            // Capturamos el total de la venta, eliminamos el símbolo '$' y lo convertimos a número
            var totalVenta = parseFloat($('#totalVentaModal').text().replace('$', '').trim());

            // Imprimir el valor de totalVenta en la consola
            console.log('Total de la venta:', totalVenta);

            // Actualizar el span en la vista con el valor de totalVenta
            $('#totalVentaSpan').text('$' + totalVenta.toFixed(2)); // Se muestra con el símbolo '$' y formato

            // Generar montos sugeridos basados en el total
            var opciones = generarMontosRapidos(totalVenta);

            // Limpiar el contenedor de opciones rápidas
            $('#opcionesRapidas').empty();

            // Crear botones dinámicamente con las opciones generadas
            opciones.forEach(function(monto) {
                var boton =
                    `<button type="button" class="btn btn-outline-secondary me-2 opcion-rapida">${monto.toFixed(2)}</button>`;
                $('#opcionesRapidas').append(boton);
            });
        });

        // Función para generar montos rápidos (menos 10% y 15%)
        function generarMontosRapidos(total) {
            var opciones = [];
            opciones.push(total); // Total exacto
            opciones.push(total * 0.9); // 10% menos
            opciones.push(total * 0.85); // 15% menos
            return opciones;
        }

        // Evento para capturar clic en los botones de opciones rápidas
        $(document).on('click', '.opcion-rapida', function() {
            var valorSeleccionado = $(this).text(); // Capturar el valor del botón
            var valorFormateado = parseFloat(valorSeleccionado).toFixed(2); // Asegurarnos de que tenga 2 decimales
            $('#valorPago').val(valorFormateado); // Pasarlo al input
        });

        // Pasa los datos a los modales cuando se selecciona un método de pago
        $('.payment-card-item').on('click', function() {
            var methodId = $(this).data('method-id');
            var methodName = $(this).data('method-name');
            var totalFactura = $('#totalVentaModal').data(
                'total'); // Captura con respaldo en el atributo data-total

            // Captura el ID de la venta
            var ventaId = $('#ventaIdModal').val();

            // Verificación de totalFactura antes de asignar
            if (totalFactura === undefined || totalFactura === null || isNaN(totalFactura)) {
                totalFactura = $('#totalVentaModal').text().replace('$', '')
                    .trim(); // Captura desde el texto del DOM
            }

            // Asignar valores al segundo modal
            $('#selectedPaymentMethod').text(methodName);
            $('#paymentMethodId').val(methodId);
            $('#ventaIdModal').val(ventaId);
            $('#totalVentaModal').text('$' + parseFloat(totalFactura).toFixed(2));

            // Debug en consola
            console.log('Método de Pago:', methodName);
            console.log('ID del Método:', methodId);
            console.log('ID Venta:', ventaId);
            console.log('Total de la Venta:', totalFactura);

            // Mostrar el segundo modal
            $('#exampleModalToggle2').modal('show');
        });

        // Manejo de la acción de guardar el pago
        $('.btn-primary').on('click', function() {
            // Recoger los datos del formulario
            var monto = parseFloat($('#valorPago').val()).toFixed(2);
            var ventaId = $('#ventaIdModal').val();
            var metodoPagoId = $('#paymentMethodId').val();
            var descripcionPago = $('#descripcionPago').val();
            var nombrePago = $('#nombrePago').val();

            // Validación antes de enviar la solicitud
            if (!monto || !ventaId || !metodoPagoId || !nombrePago) {
                console.log('Por favor, complete todos los campos antes de guardar.');
                return; // Detener ejecución si falta algún dato
            }

            // Enviar los datos por AJAX
            $.ajax({
                url: '/venta/guardar-pago', // La ruta a la que se enviará la solicitud
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF de Laravel
                    venta_id: ventaId,
                    metodo_pago_id: metodoPagoId,
                    monto: monto,
                    descripcionPago: descripcionPago,
                    nombrePago: nombrePago // Moneda seleccionada
                    // Enviar descripcionPago
                },
                success: function(response) {
                    if (response.success) {
                        // Mostrar alerta de éxito con SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Pago guardado correctamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload(); // Recargar la página después de guardar
                        });
                    } else {
                        console.log('Error al guardar el pago:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud:', error); // Imprimir error en consola
                }
            });
        });
    </script>
    {{-- para cambiar entre metodo normal y combinado --}}
    <script>
        // Evento cuando se selecciona un método de pago
        $('.payment-card-item').on('click', function() {
            var methodId = $(this).data('method-id'); // ID del método de pago
            var methodName = $(this).data('method-name'); // Nombre del método de pago

            // Mostrar el método de pago seleccionado
            $('#selectedPaymentMethod').text(methodName);
            $('#paymentMethodId').val(methodId);

            // Lógica para mostrar u ocultar contenido según el método seleccionado
            if (methodName === 'Combinado') {
                $('#combinadoFields').show(); // Mostrar el bloque combinado
                $('.regular-fields').hide(); // Ocultar el bloque regular
            } else {
                $('#combinadoFields').hide(); // Ocultar el bloque combinado
                $('.regular-fields').show(); // Mostrar el bloque regular
            }

            // Mostrar el modal secundario
            $('#exampleModalToggle2').modal('show');
        });
    </script>
    {{-- guarda en la base de datos ventas y detalle venta, me abre el modal ni loco se elimina --}}
    <script>
        // Botón "Vender" - Registrar la venta
        $('#procesarVenta').on('click', function(event) {
            event.preventDefault(); // Evitar que la página se recargue al hacer clic

            const totalFactura = parseFloat($('#totalFactura').text().replace('$', '').trim());

            // Paso 1: Registrar la venta
            $.ajax({
                url: '{{ route('venta.registrar') }}',
                method: 'POST',
                data: {
                    montoTotal: totalFactura,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    const ventaId = response.venta_id;

                    // Paso 2: Registrar los detalles de la venta
                    registrarDetallesVenta(ventaId);

                    // Paso 3: Mostrar el monto total en el primer modal y no recargar hasta que el usuario presione aceptar
                    Swal.fire({
                        title: 'Venta registrada',
                        text: 'Venta y detalles registrados exitosamente.',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Paso 4: Abrir el modal y pasar el venta_id y totalFactura después de que se haya registrado todo
                            $('#ventaIdModal').val(
                                ventaId
                            ); // Asignamos el ID de la venta al campo oculto en el modal
                            $('#exampleModalToggle').modal('show'); // Mostrar el modal

                            // Actualizamos el monto total de la venta en el primer modal
                            $('#totalVentaModal').text('$' + totalFactura.toFixed(2));

                            // Imprimir el id de la venta en consola para asegurarnos de que es correcto
                            console.log('ID de la venta registrada:', ventaId);
                            console.log('Monto total de la venta:', totalFactura);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al registrar la venta:', error);
                    Swal.fire('Error', 'Hubo un error al procesar la venta.', 'error');
                }
            });
        });

        // Función para registrar los detalles de la venta
        function registrarDetallesVenta(ventaId) {
            const detalles = [];

            $('#tabla-agregados tr').each(function() {
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
                url: '{{ route('venta.detalles') }}',
                method: 'POST',
                data: {
                    detalles: detalles,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Detalles registrados exitosamente:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error al registrar los detalles:', error);
                    Swal.fire('Error', 'Hubo un error al registrar los detalles de la venta.', 'error');
                }
            });
        }
    </script>
    {{-- crea las filas del metodo combinado --}}
    <script>
        $(document).ready(function() {
            // Botón para agregar una nueva fila
            $(document).on('click', '.btn-add', function() {
                // Clona la fila de campos
                var newRow = $(this).closest('.card-body').find('.combinado-row:first').clone();

                // Limpia los valores de los campos en la nueva fila
                newRow.find('select').val('');
                newRow.find('input').val('');

                // Agrega la nueva fila al contenedor
                $(this).closest('.card-body').find('.combinado-row:last').after(newRow);
            });

            // Botón para eliminar una fila
            $(document).on('click', '.btn-remove', function() {
                // Verifica si hay más de una fila antes de eliminar
                var rowCount = $(this).closest('.card-body').find('.combinado-row').length;
                if (rowCount > 1) {
                    $(this).closest('.combinado-row').remove(); // Elimina la fila
                } else {
                    alert('No puedes eliminar todas las filas.');
                }
            });
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
    <script>
        document.querySelectorAll('.cantidad').forEach(input => {
            input.addEventListener('input', () => {
                console.log(input.value); // Imprime el valor del input en la consola
            });
        });
    </script>
@endsection
