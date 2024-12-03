@extends('layouts.app')

@section('title', 'Registro del producto')

@section('contenido')
    <!-- Agregar Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hover-shadow:hover {
            filter: brightness(0.5);
            transform: scale(2);
            transition: all 0.1s;
        }
    </style>

    <h1>comienza el modulo mas arrecho con la fé puesta en dios y creyendo en mi todo saldra bien</h1>
    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Registrado con éxito!',
            text: '{{ session('success') }}',
            icon: "success",
            confirmButtonText: "Aceptar",
            timer: 1500, // Desaparece después de 3 segundos
        });
        </script>
    @endif
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        + Nuevo Producto
    </button>
    <br><br>
    <table class="table table-hover">
        <thead>
            <tr style="background-color: rgb(212, 212, 212); ">
                <th scope="col" style="border-radius: 15px 0px 0px 0px;">Producto</th>
                <th class="bordered">Marca</th>
                <th>Precio</th>
                <th>Cantidad Total</th>
                <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($producto as $row)
                <tr>
                    <td  class="border" ><a href="{{route('producto.show', $row->id)}}" class="text-primary hover-shadow">{{ $row->nombreProducto }}</a></td>
                    <td class="border" >{{ $row->marcaProducto }}</td>
                    <td class="border" >${{ $row->precioUnitarioProducto }}</td>
                    <td class="border" >{{ $row->cantidadDisponibleProducto }}</td>
                    <td class="border" >
                        <div class="d-flex gap-3">
                            <!-- Icono de Editar -->
                            <a href="#" class="text-primary hover-shadow" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Editar">
                                <i class="bi bi-pencil-square fs-4"></i>
                            </a>
                            <!-- Icono de Subir Foto -->
                            <a href="{{ route('producto.imagenes', $row->id) }}" class="text-primary hover-shadow" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Subir Foto">
                                <i class="bi bi-camera fs-4"></i>
                            </a>
                            <!-- Icono de Agregar Colores -->
                            <a href="{{ route('producto.colores', $row->id) }}" class="text-primary hover-shadow"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar Colores">
                                <i class="bi bi-palette fs-4"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Modal registro del formulario-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #8cc7bf">
                    <h1 class="modal-title" id="exampleModalLabel">Nuevo Producto</h1>
                </div>
                <div class="modal-body" style="background-color: #E0E0E0">
                    {{-- da incio lo interno al modal --}}
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('producto.store') }}" method="post" class="row g-3">
                                @csrf
                                <div class="col-md-4">
                                    <label for="" class="form-label">Nombre:</label></strong><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <input type="text" name="nombreProducto"
                                        class="form-control @error('nombreProducto') is-invalid @enderror" id="inputEmail4">
                                    @error('nombreProducto')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Marca:</label></strong><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <input type="text" name="marcaProducto" class="form-control @error('marcaProducto') is-invalid @enderror" id="">
                                    @error('marcaProducto')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputAddress" class="form-label">Modelo:</label></strong><span
                                        class="text-light" style="font-size: 1.2rem;"> * </span>
                                    <input type="text" name="modeloProducto" class="form-control" id="inputAddress"
                                        placeholder="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputAddress" class="form-label">Descripción:</label>
                                    <textarea name="descripcionProducto" class="form-control" aria-label="With textarea"
                                        style="withd: 100%; height: 90%; resize: none;"></textarea>
                                </div>
                                <br>
                                <div class="col-4">
                                    <label for="inputState" class="form-label">Categorias:</label></strong><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <select name="categoria_id" id="inputState" class="form-select @error('categoria_id') is-invalid @enderror">
                                        <option value="">- Seleccione -</option>
                                        @foreach ($categoria as $categorias)
                                            <option value="{{ $categorias->id }}">{{ $categorias->nombre }}</option>
                                        @endforeach
                                        @error('categoria_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="inputState" class="form-label">Proveedor:</label></strong><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <select name="proveedor_id" id="inputState" class="form-select @error('proveedor_id') is-invalid @enderror">
                                        <option value="">- Seleccione -</option>
                                        @foreach ($proveedor as $proveedores)
                                            <option value="{{ $proveedores->id }}">{{ $proveedores->nombreProveedor }}
                                            </option>
                                        @endforeach
                                        @error('proveedor_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="almacen_id" class="form-label">Almacen:</label></strong><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <select name="almacen_id" id="almacen_id" class="form-select @error('almacen_id') is-invalid @enderror">
                                        <option value="">- Seleccione -</option>
                                        @foreach ($almacen as $valor)
                                            <option value="{{ $valor->id }}">{{ $valor->nombre }}</option>
                                        @endforeach
                                        @error('almacen_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Cantidad Disponible:</label><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <input type="text" name="cantidadDisponibleProducto" class="form-control @error('cantidadDisponibleProducto') is-invalid @enderror"
                                        id="cantidadDisponibleProducto" oninput="calcularPrecioTotal()">
                                        @error('cantidadDisponibleProducto')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Precio Unitario:</label><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <input type="text" step="0.01" name="precioUnitarioProducto"
                                        class="form-control @error('precioUnitarioProducto') is-invalid @enderror" id="precioUnitarioProducto"
                                        oninput="formatDecimal(this); calcularPrecioTotal()">
                                        @error('precioUnitarioProducto')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Total</label><span class="text-light"
                                        style="font-size: 1.2rem;"> * </span>
                                    <input type="text" name="precioTotal" class="form-control" id="precioTotal"
                                        readonly>
                                </div>

                        </div>
                    </div>
                    <script>
                        // Función para calcular el precio total
                        function calcularPrecioTotal() {
                            // Obtener los valores de los campos de cantidad y precio unitario
                            var cantidad = parseFloat(document.getElementById("cantidadDisponibleProducto").value);
                            var precioUnitario = parseFloat(document.getElementById("precioUnitarioProducto").value);

                            // Calcular el precio total
                            if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
                                var precioTotal = cantidad * precioUnitario;
                                // Mostrar el resultado en el campo de precioTotal
                                document.getElementById("precioTotal").value = precioTotal.toFixed(2); // Formateamos a dos decimales
                            } else {
                                // Si los valores no son válidos, limpiamos el campo de precioTotal
                                document.getElementById("precioTotal").value = '';
                            }
                        }
                    </script>
                    {{-- el script que permite que el modal se abra exitosamente --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Revisa si hay errores de validación
                            @if ($errors->any())
                                // Selecciona el modal por su ID
                                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                // Muestra el modal
                                modal.show();
                            @endif
                        });
                    </script>
                    <script>
                        function formatDecimal(input) {
                            // Elimina cualquier carácter no numérico excepto el punto
                            let value = input.value.replace(/[^0-9.]/g, "");

                            // Convierte el valor en un número flotante
                            let number = parseFloat(value);

                            // Si es un número válido, formatea a dos decimales
                            if (!isNaN(number)) {
                                input.value = number.toFixed(2);
                            } else {
                                input.value = ""; // Si no es válido, limpia el campo
                            }
                        }
                    </script>
                    {{-- da inicio lo de aqui para arriba el modal --}}
                </div>
                <div class="modal-footer">
                    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                            style="font-size: 1.2rem;">*</span>
                        <strong> son obligatorios</strong>
                    </p>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-gray">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection


