@extends('layouts.app')

@section('title', 'Generación de factura')

<style>
.borderCard {
  border-radius: 20px;
}

/* Definir el estilo del div en estado normal */
.hover-effect {
    transition: background-color 0.3s, transform 0.3s; /* Añadimos transición suave */
}

/* Definir el estilo cuando el div esté en estado hover */
.hover-effect:hover {
    background-color: #c51e1e; /* Cambia el color de fondo al pasar el mouse */
    transform: scale(1.03); /* Agranda un poco el div */
}


</style>
@section('contenido')
    <div class="d-flex" style="height: 100vh;">
        <div class="flex-grow-1" style="background-color: #ffffff; height: 800px; width: 200px;">

            @foreach ($producto as $producto)
            <form action="{{ route('factura.agregar') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                <div class="hover-effect border-bottom border-3 p-2"
                    style="width: 100%; height: 7%; background-color: rgb(241, 241, 241);"
                    onclick="this.closest('form').submit();">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <strong>Factura: {{ $producto->id }}</strong>
                            <br>
                            {{ \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y g:i a') }}
                        </span>
                        <span class="text-end">
                            ${{ number_format($producto->precioUnitarioProducto, 2) }}
                        </span>
                    </div>
                </div>
            </form>
        @endforeach
        </div>









        <div class="flex-grow-1 p-4" style="background-color: #e0e0e0; height: 800px; width: 600px;" >
            <div class="card borderCard shadow-lg">
                <div class="card-body">
                    @if (session('productos_seleccionados'))
                        @foreach (session('productos_seleccionados') as $producto_id)
                            @php
                                // Obtener el producto usando el id de la sesión
                                $producto = \App\Models\Producto::find($producto_id);
                            @endphp

                            @if ($producto)
                                <div class="producto-agregado">
                                    <p><strong>Producto: </strong>{{ $producto->nombreProducto }}</p>
                                    <p><strong>Precio: </strong>${{ number_format($producto->precioUnitarioProducto, 2) }}</p>
                                    <p><strong>Fecha de creación: </strong>{{ \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y g:i a') }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>



    </div>

@endsection
