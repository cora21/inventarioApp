@extends('layouts.app')

@section('title', 'Registra colores del producto')

@section('contenido')
    <h1>aqui registro los colores de los productos</h1>
    {{ $producto->id }}
    <br>
    {{ $producto->nombreProducto }}
    <br>
    {{ $producto->marcaProducto }}
    <br>
    {{ $producto->modeloProducto }}
    <br>
    {{ $producto->descripcionProducto }}
    <br>
    {{ $producto->categoria_id }}
    <br>
    {{ $producto->proveedor_id }}
    <br>
    {{ $producto->almacen_id }}
    <br>
    {{ $producto->cantidadDisponibleProducto }}
    <br>
    {{ $producto->precioUnitarioProducto }}
    <br>
    {{ $producto->precioTotal }}
    <br>



    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Especifica el color
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Asignar colores a los productos</h2>
                    <p>Total disponible: <strong id="total-disponible">{{ $producto->cantidadDisponibleProducto }}</strong></p>
                    <p>Unidades asignadas: <strong id="total-asignado">0</strong></p>
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-3">
                                <button class="btn btn-primary" id="add-inputs-button">Agregar</button>
                                <button class="btn btn-danger" id="remove-inputs-button">Eliminar</button>
                            </div>
                            <form action="#" method="post" class="row g-3">
                                @csrf
                                <!-- Contenedor dinámico -->
                                <div id="input-container">
                                    <!-- Aquí se agregan los inputs -->
                                </div>
                                <!-- Mensaje de error -->
                                <div class="mt-3">
                                    <p id="error-message" class="text-danger" style="display: none;">¡Has alcanzado el
                                        límite máximo de productos!</p>
                                </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Variables y referencias
                    const totalDisponible = {{ $producto->cantidadDisponibleProducto }}; // Límite total de productos
                    const inputContainer = document.getElementById('input-container');
                    const addButton = document.getElementById('add-inputs-button');
                    const removeButton = document.getElementById('remove-inputs-button');
                    const errorMessage = document.getElementById('error-message');
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
                            return false;
                        } else {
                            errorMessage.style.display = "none"; // Ocultar mensaje de error
                            return true;
                        }
                    }
                
                    // Función para actualizar el color de fondo del input según el color seleccionado
                    function updateColorHex(selectElement) {
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        const hexValue = selectedOption.getAttribute('data-hexa');
                        const inputGroup = selectElement.closest('.input-group'); // Encuentra el grupo de inputs
                        const hexInput = inputGroup.querySelector('input[name="codigoColor[]"]');
                        if (hexValue) {
                            hexInput.style.backgroundColor = hexValue;
                            //hexInput.value = `Color seleccionado (${hexValue})`; // Opcional: mostrar texto
                        } else {
                            hexInput.style.backgroundColor = '';
                            hexInput.value = '';
                        }
                    }
                
                    // Agregar inputs dinámicamente
                    addButton.addEventListener('click', () => {
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
                                <select name="ColorPorducto[]" id="inputState" class="form-select" onchange="updateColorHex(this)">
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
                                <input type="number" name="unidadesDisponibleProducto[]" class="form-control unidades-input" min="1" oninput="validarLimite()">
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Vista del Color:</label><span class="text-light" style="font-size: 1.2rem;"> *</span>
                                <input type="text" name="codigoColor[]" class="form-control" readonly>
                            </div>
                            <div>
                                <label for=""></label>
                                <input type="hidden" value="{{ $producto->id }}" name="id_producto[]" class="form-control">
                            </div>
                        `;
                        inputContainer.appendChild(newInputs);
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
                        const totalAsignado = calcularTotal();
                        if (totalAsignado >= totalDisponible) {
                            document.querySelectorAll('input[name="unidadesDisponibleProducto[]"]').forEach(input => {
                                if (!input.value) input.disabled = true;
                            });
                        } else {
                            document.querySelectorAll('input[name="unidadesDisponibleProducto[]"]').forEach(input => {
                                input.disabled = false;
                            });
                        }
                        validarLimite();
                    });
                </script>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>










    <div class="card">
        <div class="card-body">
            <p>
                El Producto <strong>{{ $producto->nombreProducto }}</strong> se encuentra disponible en los siguientes
                colores
            </p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Color:</th>
                        <th scope="col">Unidades:</th>
                        <th scope="col">vista del color</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
