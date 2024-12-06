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
                                                            <span class="badge"
                                                                style="background-color: {{ $color->codigoHexa }};"></span>
                                                        @endforeach
                                                    @else
                                                        Sin colores
                                                    @endif
                                                </td>
                                                <td>
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
    <script>
       document.querySelector('#search-productos').addEventListener('input', function () {
    const query = this.value.toLowerCase(); // Convertimos a minúsculas para comparación insensible a mayúsculas/minúsculas.

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
                    if (!query) return text; // Si no hay término, devolvemos el texto original.
                    const regex = new RegExp(`(${query})`, 'gi'); // Creamos una expresión regular para resaltar el término.
                    return text.replace(regex, '<mark style="background-color: #FFFFFFFF; color: #0F0F0FFF;">$1</mark>'); // Envolvemos la coincidencia en <mark>.
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
@endsection

