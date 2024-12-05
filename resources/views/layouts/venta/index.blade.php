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
                    <!-- Input group for search -->
                    <div class="input-group mb-3">
                        <!-- Icono de lupa -->
                        <span class="input-group-text border-success" style="background-color: rgb(189, 225, 201)"
                            id="search-icon">
                            <i class="bi bi-search"></i>
                        </span>
                        <!-- Campo de búsqueda -->
                        <input type="search" name="" class="form-control border-success rounded"
                            placeholder="Buscar productos">
                        <!-- Botón de agregar producto -->
                        <a href="{{ route('producto.index') }}" class="btn btn-outline-primary ms-1" type="button">Nuevo
                            producto+
                        </a>
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
                                            title="Productos disponibles en estos colores" >Colores</th>
                                            <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($producto as $row)
                                            <tr>
                                                <td class="border">
                                                    <a href="{{ route('producto.show', $row->id) }}"
                                                        class="text-primary hover-shadow">{{ $row->nombreProducto }}</a>
                                                </td>
                                                <td>{{ $row->categoria->nombre ?? 'Sin Categoría' }}</td>
                                                <td class="border">{{ $row->marcaProducto }}</td>
                                                <td class="border">{{ $row->cantidadDisponibleProducto }}</td>
                                                <td class="border">${{ $row->precioUnitarioProducto }}</td>
                                                <td class="border" style="max-height: 100px; overflow-y: auto;">
                                                    @if ($row->colores->isNotEmpty())
                                                        @foreach ($row->colores as $color)
                                                        <span class="badge" style="background-color: {{ $color->codigoHexa }}; border-radius: 50%; width: 20px; height: 20px; display: inline-block; border: 1px solid gray;" title="{{ $color->nombreColor }}"></span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Sin Colores</span>
                                                    @endif
                                                </td>
                                                <td class="border">
                                                    <button class="btn btn-primary btn-sm">Agregar</button>
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
            <!-- Cuadro 2 (2 partes) -->
            <div class="col-12 col-md-5 border response" style="height: 500px; background-color: lightgreen;">

            </div>
        </div>
    </div>

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
@endsection
