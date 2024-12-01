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
@section('contenido')
    <h2>Producto</h2>
    <div class="d-flex justify-content-between">
        <!-- Botón alineado a la izquierda -->
        <a href="{{ route('producto.index') }}" type="button" class="btn btn-primary">
            Regresar
        </a>
    </div>
    <div class="container my-5">
        <div class="d-flex">
            <!-- Miniaturas en Columna -->
            <div class="d-flex flex-column me-3">
                @foreach ($producto->imagenes as $imagen)
                    <img src="{{ $imagen->ruta }}" class="img-thumbnail mb-2 preview-image"
                        style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" alt="Miniatura">
                @endforeach
            </div>

            <!-- Imagen Principal -->
            <div class="me-4">
                <img id="mainImage" src="{{ $producto->imagenes->first()->ruta }}" class="rounded border"
                    style="width: 350px; height: 350px; object-fit: cover;" alt="Imagen Principal">
                <br>
                <!-- Colores Disponibles -->
                <div class="mt-4">
                    <p><strong>Colores Disponibles:</strong></p>
                    <div class="d-flex gap-3 justify-content-start">
                        @foreach ($producto->colores as $color)
                            <div class="color-container text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Cantidad disponible: {{ $color->pivot->unidadesDisponibleProducto }} unidades">
                                <div class="circle" style="background-color: {{ $color->codigoHexa }};"></div>
                                <span
                                    class="color-count mt-2 d-block">{{ $color->pivot->unidadesDisponibleProducto }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
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
                <h4 class="text-primary fw-bold display-6">$ {{ number_format($producto->precioUnitarioProducto, 2) }}</h4>

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
