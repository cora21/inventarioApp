{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Mostrar los proveedores')

@section('contenido')
<div class="d-flex justify-content-between align-items-center">
    <!-- Botón alineado a la derecha -->
    <a href="{{ route('proveedor.index') }}" type="button" class="btn btn-primary btn-lg">
        Regresar
    </a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-center" style="color: white;">
                <h3 class="mb-0">Datos del Proveedor</h3>
            </div>
            <div class="card-body">
                <dl class="row mb-4">
                    <dt class="col-sm-4 text-dark">Nombre del Proveedor:</dt>
                    <dd class="col-sm-8 text-dark font-weight-bold">
                        {{ $proveedor->nombreProveedor }}
                    </dd>

                    <dt class="col-sm-4 text-dark">Correo Electrónico:</dt>
                    <dd class="col-sm-8 text-dark font-weight-bold">
                        {{ $proveedor->emailProveedor }}
                    </dd>

                    <dt class="col-sm-4 text-dark">Documento de Identidad:</dt>
                    <dd class="col-sm-8 text-dark font-weight-bold">
                        {{ $proveedor->nacionalidad }}.- {{ $proveedor->rif_cedula }}
                    </dd>

                    <dt class="col-sm-4 text-dark">Número de Contacto:</dt>
                    <dd class="col-sm-8 text-dark font-weight-bold">
                        {{ $proveedor->telefonoProveedor }}
                    </dd>

                    <dt class="col-sm-4 text-dark">Dirección:</dt>
                    <dd class="col-sm-8 text-dark font-weight-bold">
                        {{ $proveedor->direccionProveedor }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

@endsection
