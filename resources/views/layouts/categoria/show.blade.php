{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Mostrar las Categorias')

@section('contenido')
<div class="d-flex justify-content-between align-items-center">
    <!-- Botón alineado a la derecha -->
    <a href="{{ route('categoria.index') }}" type="button" class="btn btn-primary btn-lg">
        Regresar
    </a>

</div>
<br><br>
<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card shadow-lg">
            <div class="card-header">Mostrar la Categoria: {{ $categoria->nombre }}</div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nombre:</dt>
                    <dd class="col-sm-9">{{ $categoria->nombre }}</dd>

                    <dt class="col-sm-3">Dirección:</dt>
                    <dd class="col-sm-9">{{ $categoria->descripcion }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
