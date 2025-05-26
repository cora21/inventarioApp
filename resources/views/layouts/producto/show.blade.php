@extends('layouts.app')

@section('title', 'Datos completos del producto')

<style>
    .color-container {
        position: relative;
    }

    .circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .circle:hover {
        transform: scale(1.1);
    }

    .color-count {
        display: block;
        margin-top: 5px;
        font-weight: bold;
        font-size: 14px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@section('contenido')
    <h2>Producto</h2>
    <div class="d-flex justify-content-between">
        <!-- Botón alineado a la izquierda -->
        <a href="{{ url()->previous() }}" type="button" class="btn btn-primary">
            Regresar
        </a>
    </div>
    <div class="container my-5">
        <div class="d-flex">
            <!-- Miniaturas en Columna -->
            <div class="d-flex flex-column me-3">
                @if ($producto->imagenes->isNotEmpty())
                    @foreach ($producto->imagenes as $imagen)
                        <img src="{{ $imagen->ruta }}" class="img-thumbnail mb-2 preview-image"
                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" alt="Miniatura">
                    @endforeach
                @endif
            </div>

            <!-- Imagen Principal -->
            <div class="me-4">
                @if ($producto->imagenes->isNotEmpty())
                    <!-- Mostrar Imagen Principal -->
                    <img id="mainImage" src="{{ $producto->imagenes->first()->ruta }}" class="rounded border"
                        style="width: 350px; height: 350px; object-fit: cover;" blan alt="Imagen Principal">
                @else
                    <!-- Mostrar Cuadro Placeholder -->
                    <div class="d-flex justify-content-center align-items-center border rounded bg-light"
                        style="width: 350px; height: 350px; position: relative;">
                        <div class="text-center">
                            <i class="bi bi-card-image" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="mt-2 text-muted">No hay imágenes disponibles para este producto</p>
                            <a class="btn btn-primary btn-sm mt-2" href="{{ route('producto.imagenes', $producto->id) }}">
                                + Agregar Imagenes
                            </a>
                        </div>
                    </div>
                @endif
                <br>
                <br>
                <!-- Colores Disponibles -->
                @if ($producto->colores->isEmpty())
                    <!-- Mensaje cuando no hay colores -->
                    <div class="alert text-center mt-3 border" style="background-color: #e8eff4" role="alert">
                        <i class="bi bi-palette" style="font-size: 2rem; color: #6c757d;"></i>
                        <p class="mb-3">No hay colores registrados para este producto.</p>
                        <a href="{{ route('producto.colores', $producto->id) }}" class="btn btn-primary btn-sm mt-2">
                            + Registrar colores
                        </a>
                    </div>
                @else
                    <!-- Mostrar colores y unidades sin color -->
                    @php
                        $unidadesConColor = $producto->colores->sum('pivot.unidadesDisponibleProducto');
                        $unidadesSinColor = $producto->cantidadDisponibleProducto - $unidadesConColor;
                    @endphp

                    <div class="d-flex gap-3 flex-wrap">
                        @foreach ($producto->colores as $color)
                            <div class="text-center" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="Cantidad disponible: {{ $color->pivot->unidadesDisponibleProducto }} unidades">
                                <div class="rounded-circle border border-secondary"
                                    style="width: 40px; height: 40px; background-color: {{ $color->codigoHexa }};">
                                </div>
                                <div class="mt-1 small">{{ $color->pivot->unidadesDisponibleProducto }}</div>
                            </div>
                        @endforeach

                        @if ($unidadesSinColor > 0)
                        <a href="{{ route('producto.colores', $producto->id) }}" class="text-decoration-none text-dark">
                            <div class="text-center" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                 title="Unidades sin color: {{ $unidadesSinColor }} unidades, pulsa para agregar colores.">
                                <div class="rounded-circle bg-light border border-secondary position-relative"
                                     style="width: 40px; height: 40px;">
                                    <span class="position-absolute top-50 start-50 translate-middle fw-bold">X</span>
                                </div>
                                <div class="mt-1 small">{{ $unidadesSinColor }}</div>
                            </div>
                        </a>                        
                        @endif
                    </div>
                @endif

            </div>


            <!-- Detalles del Producto -->
            <div class="col-md-6">
                <h2 class="fw-bold display-6">{{ $producto->nombreProducto }}</h2>
                <p class="fs-4"><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                <p class="fs-4"><strong>Marca:</strong> {{ $producto->marcaProducto }}</p>
                <p class="fs-4"><strong>Reseña:</strong> {{ $producto->descripcionProducto }} </p>
                <p class="fs-4"><strong>Almacén principal:</strong> {{ $producto->almacen->nombre ?? 'Sin almacén' }}</p>
                <p class="fs-4"><strong>Proveedor:</strong>
                    {{ $producto->proveedor->nombreProveedor ?? 'Sin proveedor' }}</p>
                <p class="fs-4"><strong>Disponibilidad en almacen:</strong></p>
                <ul>
                    @foreach ($producto->almacenes as $almacen)
                        <li>Se encuentran: {{ $almacen->pivot->cantidad }} unidades disponibles</li>
                    @endforeach
                </ul>
                @if($vesBaseMoneda === 1)
                    <h4 class="text-primary fw-bold display-6">Bs. {{ number_format($producto->precioUnitarioProducto * $dolarBCV, 2) }}</h4>
                    @else
                    <h4 class="text-primary fw-bold display-6">$ {{ number_format($producto->precioUnitarioProducto, 2) }}</h4>
                    @endif
            </div>
        </div>
    </div>
    <script>
        // Seleccionar todas las miniaturas y la imagen principal
        const previews = document.querySelectorAll('.preview-image');
        const mainImage = document.getElementById('mainImage');

        // Agregar evento de clic a cada miniatura
        previews.forEach(preview => {
            preview.addEventListener('click', () => {
                mainImage.src = preview.src; // Cambiar la fuente de la imagen principal
            });
        });
    </script>
    <script>
        // Inicializa todos los tooltips en la página
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

@endsection
