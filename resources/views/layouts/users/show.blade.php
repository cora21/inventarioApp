{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Listado de los Usuarios')

@section('page')
    @php $currentPage = 'users' @endphp
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center">
    <!-- Botón alineado a la derecha -->
    <a href="{{ route('users.index') }}" type="button" class="btn btn-primary btn-lg">
        Regresar
    </a>
</div>
<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-header">Datos del Usuario {{ $user->first_name }} </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nombre:</dt>
                    <dd class="col-sm-9">{{ $user->first_name }}</dd>

                    <dt class="col-sm-3">Apellido:</dt>
                    <dd class="col-sm-9">{{ $user->last_name }}</dd>

                    <dt class="col-sm-3">Correo:</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">Telefóno:</dt>
                    <dd class="col-sm-9">{{ $user->phone_number }}</dd>

                    <dt class="col-sm-3">Fecha:</dt>
                    <dd class="col-sm-9">{{ $user->created_at }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
