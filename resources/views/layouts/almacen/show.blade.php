{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Mostrar los almacenes')

@section('contenido')
<div class="d-flex justify-content-between align-items-center">
    <!-- Botón alineado a la derecha -->
    <a href="{{ route('almacen.index') }}" type="button" class="btn btn-primary btn-lg">
        Regresar
    </a>
</div>
<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">Mostrar</div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nombre:</dt>
                    <dd class="col-sm-9">{{ $almacen->nombre }}</dd>

                    <dt class="col-sm-3">Dirección:</dt>
                    <dd class="col-sm-9">{{ $almacen->direccion }}</dd>

                    <dt class="col-sm-3">Observa:</dt>
                    <dd class="col-sm-9">{{ $almacen->observaciones }}</dd>

                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
