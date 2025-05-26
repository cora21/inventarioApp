@extends('layouts.app')

@section('title', 'Editar producto')

@section('contenido')

<div class="container">
    <a href="{{ url()->previous() }}" type="button" class="btn btn-primary">
        Regresar
    </a>
    <br>
    <br>
    <div class="card">
        
        <div class="card-body">
            <form action="{{ route('producto.update', $producto->id) }}" method="post" class="row g-3">
                @csrf
                @method('put')
                <div class="col-md-4">
                    <label for="" class="form-label">Nombre:</label></strong><span
                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                    <input type="text" value="{{$producto->nombreProducto}}" name="nombreProducto"
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
                    <input type="text" value="{{$producto->marcaProducto}}" name="marcaProducto" class="form-control @error('marcaProducto') is-invalid @enderror" id="">
                    @error('marcaProducto')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="inputAddress" class="form-label">Modelo:</label></strong><span
                        class="text-light" style="font-size: 1.2rem;"> * </span>
                    <input type="text" value="{{$producto->modeloProducto}}" name="modeloProducto" class="form-control" id="inputAddress"
                        placeholder="">
                </div>
                <br>
                <div class="col-4">
                    <label for="inputState" class="form-label">Categorias:</label></strong><span
                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                    <select name="categoria_id" id="inputState" class="form-select @error('categoria_id') is-invalid @enderror">
                        <option value="">- Seleccione -</option>
                        @foreach ($categoria as $categorias)
                            <option value="{{ $categorias->id }}"
                                {{ $categorias->id == $producto->categoria_id ? 'selected' : '' }}>{{ $categorias->nombre }}
                            </option>
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
                            <option value="{{ $proveedores->id }}"
                                {{ $proveedores->id == $producto->proveedor_id ? 'selected' : '' }}>
                                {{ $proveedores->nombreProveedor }}
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
                            <option value="{{ $valor->id }}"
                                {{ $valor->id == $producto->almacen_id ? 'selected' : '' }}>
                                {{ $valor->nombre }}
                            </option>
                        @endforeach
                        @error('almacen_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Precio Base-Proveedor:</label><span
                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                    <input type="text" value="{{$producto->precioBaseProveedor}}"  name="precioBaseProveedor"
                        class="form-control">
                        <div>
                            <small style="color: rgb(197, 194, 194)">Se registra el precio base</small>
                        </div>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Cantidad Disponible:</label><span
                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                        <input type="text" value="{{$producto->cantidadDisponibleProducto}}" name="cantidadDisponibleProducto"
                        class="form-control @error('cantidadDisponibleProducto') is-invalid @enderror"
                        id="cantidadDisponibleProducto" oninput="calcularPrecioTotal(); copiarCantidadDisponible()">
                        @error('cantidadDisponibleProducto')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Precio Unitario para la Venta:</label><span
                        class="text-danger" style="font-size: 1.2rem;"> * </span>
                    <input type="text" value="{{$producto->precioUnitarioProducto}}"  name="precioUnitarioProducto"
                        class="form-control @error('precioUnitarioProducto') is-invalid @enderror" id="precioUnitarioProducto"
                        oninput="formatDecimal(this); calcularPrecioTotal()">
                        @error('precioUnitarioProducto')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                </div>
                
                <div class="col-4">
                    <input type="hidden" name="precioTotal" value="{{$producto->precioTotal}}" class="form-control" placeholder="Se calcula automaticamente" id="precioTotal"
                        readonly>
                        <input type="hidden" name="totalDescontable" value="{{$producto->totalDescontable}}" class="form-control"
       placeholder="" id="totalDescontable" readonly>
                </div>
                <br>
                <div class="col-12 mb-3">
                    <label for="inputAddress" class="form-label">Descripción:</label>
                    <textarea name="descripcionProducto" value="{{$producto->descripcionProducto}}" class="form-control" aria-label="With textarea"
                        style="withd: 100%; height: 90%; resize: none;">{{$producto->descripcionProducto}}</textarea>
                </div>

        </div>
    </div>
    <div class="modal-footer">
        <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                style="font-size: 1.2rem;">*</span>
            <strong> son obligatorios</strong>
        </p>
        <a href="{{ route('producto.index') }}" class="btn btn-outline-primary m-2">Cancelar</a>
        <button type="submit" class="btn btn-primary text-gray">Guardar</button>
    </div>
</div>
</form>

<script>
    function copiarCantidadDisponible() {
        // Obtener los campos
        const cantidadDisponible = document.getElementById('cantidadDisponibleProducto');
        const totalDescontable = document.getElementById('totalDescontable');

        // Solo copiar si hay un valor en cantidadDisponibleProducto
        if (cantidadDisponible.value.trim() !== "") {
            totalDescontable.value = cantidadDisponible.value;
        }
    }
</script>
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

@endsection

