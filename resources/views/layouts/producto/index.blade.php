@extends('layouts.app')

@section('title', 'Registro del producto')

@section('contenido')
{{--


totalDescontable tienes el total del producto sin descuento ni ndasa



--}}
    <!-- Agregar Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hover-shadow:hover {
            filter: brightness(0.5);
            transform: scale(2);
            transition: all 0.1s;
        }
    </style>

    {{-- <h1>comienza el modulo mas arrecho con la fé puesta en dios y creyendo en mi todo saldra bien</h1> --}}
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
    {{-- contiene la seccion de los botones para el buscador --}}
    <div class="card">
        <div class="card-body">
            <div class="container p-3">
                <!-- Contenedor de los select y el buscador -->
                <div class="row">
                    <!-- Select 1 -->
                    <div class="col-md-4">
                        <select id="SelectBuscadorAlmacen" class="form-select">
                            <option value="">Busqueda mediante almacen</option>
                            @foreach ($almacen as $row)
                            <option value="{{ $row->nombre }}">{{ $row->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select 2 -->
                    <div class="col-md-4">
                        <select id="SelectBuscadorCategoria" class="form-select">
                            <option value="">Busqueda mediante categoria</option>
                            @foreach ($categoria as $row)
                            <option value="{{ $row->nombre }}">{{ $row->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <a href="{{ route('generar.pdf') }}" class="btn btn-outline-primary btn-lg me-2" target="_blank" style="width: 120px;">Imprimir</a>
                        <button id="btnExportar" class="btn btn-outline-secondary btn-lg" style="width: 120px;">Exportar</button>
                    </div>
                </div>

                <!-- Buscador -->
                <div class="row mt-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text border-success" style="background-color: rgb(189, 225, 201)"
                            id="search-icon">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" id="search-productos" class="form-control border-success rounded"
                            placeholder="Buscar productos por nombre o marca...">
                        {{-- <a href="{{ route('producto.index') }}" class="btn btn-outline-success ms-1" type="button">Nuevo
                            producto + </a> --}}
                            <a type="button" class="btn btn-outline-success ms-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                + Nuevo Producto
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA DE LOS PRODUCTOS --}}
    <div class="card">
        <div class="card-body">
            <table id="productos-table" class="table table-hover">
                <thead>
                    <tr style="background-color: rgb(212, 212, 212); ">
                        <th scope="col" style="border-radius: 15px 0px 0px 0px;">Producto</th>
                        <th class="bordered">Marca</th>
                        <th class="bordered">Almacen</th>
                        <th class="bordered">Categoria</th>
                        <th>Precio</th>
                        <th>Cantidad Total</th>
                        <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producto as $row)
                    @php
                        // Calcular el porcentaje de cantidadDisponibleProducto respecto a totalDescontable
                        if ($row->totalDescontable > 0) {
                            $porcentaje = ($row->cantidadDisponibleProducto / $row->totalDescontable) * 100;
                            $bajoInventario = $porcentaje <= 10; // Si es menor o igual al 10%
                        } else {
                            $bajoInventario = false; // Evitar división por cero
                        }
                    @endphp
                        <tr>
                            <td  class="border" ><a href="{{route('producto.show', $row->id)}}" class="text-primary hover-shadow">{{ $row->nombreProducto }}</a></td>
                            <td class="border" >{{ $row->marcaProducto }}</td>
                            @foreach ($almacen as $almacenRow)
                                @if ($row->almacen_id === $almacenRow->id)
                                <td class="border">{{ $almacenRow->nombre }}</td>
                                @break
                                @endif
                            @endforeach


                            @foreach ($categoria as $categoriaRow)
                                @if ($row->categoria_id === $categoriaRow->id)
                                <td class="border">{{ $categoriaRow->nombre }}</td>
                                @break
                                @endif
                            @endforeach
                            {{-- <td class="border">
                                {{ number_format($row->precioUnitarioProducto * 51.93, 2) }}
                            </td> --}}
                            @if($vesBaseMoneda === 1)
                            <td class="border">Bs.{{ number_format($row->precioUnitarioProducto * $dolarBCV, 2) }}</td>
                            @else
                            <td class="border" >${{ $row->precioUnitarioProducto }}</td>
                            @endif
                            <td class="border" style="width: 200px;">
                                {{ $row->cantidadDisponibleProducto }}
                                @if ($bajoInventario)
                                    <!-- Alerta de bajo inventario -->
                                    <div class="alert alert-warning p-2 m-0 d-inline-flex align-items-center gap-2">
                                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                        <span>¡Bajo inventario!</span>
                                    </div>
                                @endif
                            </td>
                            <td class="border" >
                                <div class="d-flex gap-3">
                                    <!-- Icono de Editar -->
                                    <a href="{{ route('producto.edit', $row->id) }}" class="text-primary hover-shadow" data-bs-toggle="tooltip"
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
        </div>
    </div>

    <!-- Alerta flotante -->
    @if ($bajoInventario)
    <div id="alertaFlotante"
        class="alert alert-warning position-fixed top-0 end-0 m-3 p-4 border border-3 rounded shadow-lg d-none"
        role="alert"
        style="z-index: 1050; width: 350px; font-size: 1.2rem; background-color: #fffae6; border-color: #ffc107;">
        <strong>¡Atención!</strong> Algunos productos tienen bajo inventario.
    </div>
    @endif




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
                                <input type="hidden" name="totalDescontable">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Precio Unitario:</label><span
                                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <input type="number"  name="precioUnitarioProducto"
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
                                <br>
                                <div class="col-12 mb-3">
                                    <label for="inputAddress" class="form-label">Descripción:</label>
                                    <textarea name="descripcionProducto" class="form-control" aria-label="With textarea"
                                        style="withd: 100%; height: 90%; resize: none;"></textarea>
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
                            // Obtener el valor ingresado
                            let value = input.value;

                            // Elimina cualquier carácter no numérico, excepto los números
                            value = value.replace(/[^0-9]/g, "");

                            // Si el valor tiene menos de 2 dígitos, se agrega un "0." al inicio
                            if (value.length === 1) {
                                value = '0.0' + value; // Lo convierte en un número con un decimal
                            } else if (value.length === 2) {
                                value = '0.' + value; // Lo convierte en un número con dos decimales
                            } else if (value.length > 2) {
                                value = value.substring(0, value.length - 2) + '.' + value.substring(value.length - 2);
                            }

                            // Convertir a flotante para asegurar la conversión adecuada
                            let number = parseFloat(value);

                            // Si el número es válido, lo formatea con dos decimales
                            if (!isNaN(number)) {
                                input.value = number.toFixed(2); // Garantiza dos decimales
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alertaFlotante = document.getElementById('alertaFlotante');

            if (alertaFlotante) {
                // Mostrar la alerta al cargar la página
                alertaFlotante.classList.remove('d-none');

                // Ocultar automáticamente después de 5 segundos
                setTimeout(() => {
                    alertaFlotante.classList.add('d-none');
                }, 1000); // Mostrar la alerta por 5 segundos
            }
        });
    </script>
    {{-- script del buscador  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-productos');
            const table = document.getElementById('productos-table');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();

                Array.from(rows).forEach(row => {
                    const producto = row.cells[0].textContent.toLowerCase(); // Columna Producto
                    const marca = row.cells[1].textContent.toLowerCase(); // Columna Marca

                    if (producto.includes(filter) || marca.includes(filter)) {
                        row.style.display = ''; // Mostrar fila
                    } else {
                        row.style.display = 'none'; // Ocultar fila
                    }
                });
            });
        });
    </script>


{{-- select busscador de almacen --}}
<script>
        document.getElementById('SelectBuscadorAlmacen').addEventListener('change', function () {
        const filterValue = this.value.toLowerCase(); // Obtener el valor seleccionado
        const table = document.getElementById('productos-table'); // Referencia a la tabla
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'); // Obtener todas las filas del cuerpo de la tabla

        // Iterar sobre las filas de la tabla
        Array.from(rows).forEach(row => {
            // Encontrar la celda que contiene el nombre del almacén
            const almacenCell = row.cells[2]; // La tercera celda (columna del almacén, índice 2)
            const almacenText = almacenCell ? almacenCell.textContent.toLowerCase() : ''; // Obtener texto en minúsculas

            // Mostrar/ocultar filas dependiendo de la coincidencia
            if (filterValue === '' || almacenText.includes(filterValue)) {
                row.style.display = ''; // Mostrar fila
            } else {
                row.style.display = 'none'; // Ocultar fila
            }
        });
    });
</script>
{{-- controla el select buscador de categoria --}}
<script>
    document.getElementById('SelectBuscadorCategoria').addEventListener('change', function () {
    const filterValue = this.value.toLowerCase(); // Obtener el valor seleccionado
    const table = document.getElementById('productos-table'); // Referencia a la tabla
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'); // Obtener todas las filas del cuerpo de la tabla

    // Iterar sobre las filas de la tabla
    Array.from(rows).forEach(row => {
        // Encontrar la celda que contiene el nombre de la categoría
        const categoriaCell = row.cells[3]; // La cuarta celda (columna de la categoría, índice 3)
        const categoriaText = categoriaCell ? categoriaCell.textContent.toLowerCase() : ''; // Obtener texto en minúsculas

        // Mostrar/ocultar filas dependiendo de la coincidencia
        if (filterValue === '' || categoriaText.includes(filterValue)) {
            row.style.display = ''; // Mostrar fila
        } else {
            row.style.display = 'none'; // Ocultar fila
        }
    });
});

</script>
@endsection


