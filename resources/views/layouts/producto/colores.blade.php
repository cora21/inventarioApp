@extends('layouts.app')

@section('title', 'Registra colores del producto')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@section('contenido')
    <!-- Button trigger modal -->
    <div class="d-flex justify-content-between">
        <!-- Botón de regresar -->
        <a href="{{ route('producto.index') }}" type="button" style="height: 35px;" class="btn btn-primary">
            Regresar
        </a>
        <!-- Validación para mostrar el botón o el mensaje -->
        @if ($totalUnidadesConColor < $producto->cantidadDisponibleProducto)
            <!-- Botón para abrir el modal solo si hay productos disponibles -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                + Asigna un color
            </button>
        @else
            <!-- Mensaje cuando todos los productos están asignados -->
            <a class="alert alert-success" role="alert">
                Ya se asignaron todos los colores a los productos disponibles.
            </a>
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalparaEditar">
                <i class="bi bi-pencil-square"></i>
            </button> --}}
        @endif
    </div>
    <br>
    <p class="h3">Nombre del Producto: <strong> {{ $producto->nombreProducto }}</strong></p>
    @if ($totalUnidadesConColor == $producto->cantidadDisponibleProducto)

    @else
    <p class="h3">Productos pendientes para asignarle un color: <strong> {{ $producto->cantidadDisponibleProducto - $totalUnidadesConColor }} </label><span class="text-danger" style="font-size: 1.5rem;"> * </span></strong></p>
    @endif
    <br>
    <div class="card">
        <div class="card-body">
            <p>
                El Producto <strong>{{ $producto->nombreProducto }}</strong> se encuentra disponible en los siguientes
                colores:
            </p>
            <table class="table text-center">
                <thead>
                    <tr style="background-color: rgb(212, 212, 212); ">
                        <th scope="col" style="border-radius: 15px 0px 0px 0px;">Color:</th>
                        <th scope="col">Unidades:</th>
                        <th scope="col">Vista del color</th>
                        <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producto->colores as $color)
                        <tr>
                            <td class="border">{{ $color->nombreColor }}</td> <!-- Nombre del color -->
                            <td class="border">{{ $color->pivot->unidadesDisponibleProducto }}</td>
                            <!-- Unidades disponibles -->
                            <td class="border">
                                @if ($color->id == 6)
                                    <!-- Si el id es 6, se muestra el texto "Color Blanco" -->
                                    <div type="button" class="btn btn-lg border-secondary"
                                        style="background-color: {{ $color->codigoHexa }}; color: {{ $color->codigoHexa }};">
                                        Este es un color
                                    </div>
                                @else
                                    <!-- Si el id no es 6, se muestra el color original del código hexadecimal -->
                                    <div type="button" class="btn btn-lg"
                                        style="background-color: {{ $color->codigoHexa }}; color: {{ $color->codigoHexa }};">
                                        Este es un color
                                    </div>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="eliminarFila({{$color->id}})">
                                    <i class="bi bi-trash"></i> <!-- Icono de eliminar -->
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade @if ($errors->any()) show @endif" id="exampleModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="@if ($errors->any()) display:block; @endif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Asignar colores a los productos</h2>
                    <p>Total disponible: <strong id="total-disponible">{{ $producto->cantidadDisponibleProducto - $totalUnidadesConColor }}</strong>
                    <p>Unidades asignadas: <strong id="total-asignado">0</strong></p>
                    <div class="card">
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3" id="error-messages">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="mt-3">
                                <button class="btn btn-primary" id="add-inputs-button">Agregar</button>
                                <button class="btn btn-danger" id="remove-inputs-button">Eliminar</button>
                                <button class="btn btn-secondary" id="filaUnica">Agregar Fila Predeterminada</button>

                            </div>
                            <form action="{{ route('producto.guardarColores', $producto->id) }}" method="POST">
                                @csrf
                                <!-- Contenedor dinámico -->
                                <div id="input-container">
                                    <!-- Aquí se agregan los inputs -->
                                </div>
                                <!-- Mensaje de error -->
                                <div class="mt-3">
                                    <p id="errorMaximoAlcanzado" class="text-danger" style="display: none;">¡Has alcanzado
                                        el límite máximo de productos!</p>
                                </div>
                        </div>
                    </div>
                </div>
                    <script>
                        // Variables y referencias
                        const totalDisponible = {{ $producto->cantidadDisponibleProducto - $totalUnidadesConColor }}; // Límite total de productos
                        const inputContainer = document.getElementById('input-container');
                        const addButton = document.getElementById('add-inputs-button');
                        const removeButton = document.getElementById('remove-inputs-button');
                        const errorMessage = document.getElementById('errorMaximoAlcanzado');
                        const totalAsignadoDisplay = document.getElementById('total-asignado'); // Referencia para mostrar el total asignado

                        // Función para calcular el total asignado
                        function calcularTotal() {
                            let totalAsignado = 0;
                            document.querySelectorAll('input[name="unidadesDisponibleProducto[]"]').forEach(input => {
                                totalAsignado += parseInt(input.value) || 0; // Si el valor es NaN, usar 0
                            });
                            totalAsignadoDisplay.textContent = totalAsignado; // Mostrar el total en el elemento
                            return totalAsignado;
                        }

                        // Función para validar y manejar el estado de los inputs
                        function validarLimite() {
                            const totalAsignado = calcularTotal();
                            if (totalAsignado > totalDisponible) {
                                errorMessage.style.display = "block"; // Mostrar mensaje de error
                                addButton.disabled = true; // Deshabilitar el botón de agregar
                                document.querySelectorAll('input[name="unidadesDisponibleProducto[]"]').forEach(input => {
                                    input.disabled = true; // Deshabilitar inputs de unidades
                                });
                                return false;
                            } else {
                                errorMessage.style.display = "none"; // Ocultar mensaje de error
                                addButton.disabled = false; // Habilitar el botón de agregar
                                document.querySelectorAll('input[name="unidadesDisponibleProducto[]"]').forEach(input => {
                                    input.disabled = false; // Habilitar inputs de unidades
                                });
                                return true;
                            }
                        }

                        // Función para actualizar el color de fondo del input según el color seleccionado
                        function updateColorHex(selectElement) {
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            const hexValue = selectedOption.getAttribute('data-hexa');
                            const inputGroup = selectElement.closest('.input-group'); // Encuentra el grupo de inputs
                            const hexInput = inputGroup.querySelector('input[name="codigoColor[]"]');

                            // Actualiza el fondo del input con el color hexadecimal
                            if (hexValue) {
                                hexInput.style.backgroundColor = hexValue; // Cambiar el fondo del input
                                hexInput.style.color = hexValue;
                                hexInput.value = hexValue; // Actualizar el valor del input con el código hexadecimal
                            } else {
                                hexInput.style.backgroundColor = ''; // Si no hay color, limpia el fondo
                                hexInput.value = ''; // Limpia el valor
                            }
                        }

                        // Agregar inputs dinámicamente
                        addButton.addEventListener('click', (event) => {
                            event.preventDefault(); // Prevenir que el formulario se envíe si el botón "agregar" está dentro de un formulario

                            const totalAsignado = calcularTotal();
                            if (totalAsignado >= totalDisponible) {
                                errorMessage.style.display = "block";
                                return;
                            }

                            const newInputs = document.createElement('div');
                            newInputs.classList.add('row', 'mt-3', 'input-group');
                            newInputs.innerHTML = `
                                <div class="col-md-4">
                                    <label for="inputState" class="form-label">Colores:</label><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <select name="color_id[]" id="inputState" class="form-select" required onchange="updateColorHex(this)">
                                        <option value="">- Seleccione -</option>
                                        @foreach ($colores as $valor)
                                            <option value="{{ $valor->id }}" data-hexa="{{ $valor->codigoHexa }}">
                                                {{ $valor->nombreColor }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Unidades:</label><span class="text-danger" style="font-size: 1.2rem;"> *</span>
                                    <input type="number" name="unidadesDisponibleProducto[]" required class="form-control unidades-input" min="1" oninput="validarLimite()">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Vista del Color:</label><span class="text-light" style="font-size: 1.2rem;"> *</span>
                                    <input type="text" name="codigoColor[]" class="form-control" readonly>
                                </div>
                                <div>
                                    <input type="hidden" value="{{ $producto->id }}" name="producto_id[]" class="form-control">
                                </div>
                            `;
                            inputContainer.appendChild(newInputs);
                            validarLimite(); // Llamar a la función de validación después de agregar los inputs
                        });

                        // Eliminar los últimos inputs agregados
                        removeButton.addEventListener('click', () => {
                            const lastGroup = inputContainer.lastElementChild;
                            if (lastGroup) {
                                inputContainer.removeChild(lastGroup);
                                validarLimite();
                            }
                        });

                        // Validar cuando se modifique algún input
                        inputContainer.addEventListener('input', () => {
                            validarLimite();
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Mostrar el modal si hay errores
                            @if ($errors->any())
                                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                modal.show();
                            @endif

                            // Hacer desaparecer los mensajes de error después de 5 segundos
                            const errorMessages = document.getElementById('error-messages');
                            if (errorMessages) {
                                setTimeout(() => {
                                    errorMessages.style.display = 'none';
                                }, 5000); // 5000 ms = 5 segundos
                            }
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Referencia al botón y al contenedor
                            const filaUnicaButton = document.getElementById('filaUnica');
                            const inputContainer = document.getElementById('input-container');

                            // Obtener el valor inicial de totalDisponible desde Blade
                            const totalDisponible = {{ $producto->cantidadDisponibleProducto - $totalUnidadesConColor }};

                            // Variable para rastrear si ya existe una fila
                            let filaAgregada = false;

                            // Agregar una fila nueva al contenedor
                            filaUnicaButton.addEventListener('click', (event) => {
                                event.preventDefault(); // Prevenir comportamiento predeterminado del botón

                                // Verificar si ya existe una fila
                                if (filaAgregada) {
                                    alert('Solo puedes agregar una fila predeterminada.');
                                    return;
                                }

                                // Obtener el valor actual de "total asignado" en tiempo real
                                const totalAsignado = parseInt(document.getElementById('total-asignado').textContent) || 0;
                                const diferencia = totalDisponible - totalAsignado;

                                // Verificar si hay productos disponibles
                                if (diferencia <= 0) {
                                    alert('No hay productos disponibles para asignar.');
                                    return;
                                }

                                // Crear la nueva fila
                                const newRow = document.createElement('div');
                                newRow.classList.add('row', 'mt-3', 'input-group');
                                newRow.innerHTML = `
                                    <div class="col-md-6">
                                        <label for="inputState" class="form-label">Colores:</label>
                                        <select name="color_id[]" class="form-select">
                                            <option value="31">Sin Color</option>
                                            <!-- Agregar más opciones aquí si es necesario -->
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label">Unidades:</label>
                                        <input type="number" name="unidadesDisponibleProducto[]" class="form-control" value="${diferencia}" min="1">
                                    </div>
                                `;

                                // Agregar la fila al contenedor
                                inputContainer.appendChild(newRow);

                                // Marcar que ya se agregó una fila
                                filaAgregada = true;
                            });
                        });
                    </script>
                <div class="modal-footer">
                    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                            style="font-size: 1.2rem;">*</span>
                        <strong> son obligatorios</strong>
                    </p>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-gray">Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>


        <!-- Modal para las ediciones -->
        <div class="modal fade" id="exampleModalparaEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                            style="font-size: 1.2rem;">*</span>
                        <strong> son obligatorios</strong>
                    </p>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-gray btn-sm">Guardar</button>
                </div>
            </div>
            </div>
        </div>




        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            function eliminarFila(colorId, button) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esto!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, deseo eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/eliminar-color/' + colorId,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado!',
                                    'El color ha sido eliminado.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Recargar la página
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Ocurrió un error al intentar eliminar el color.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
@endsection
