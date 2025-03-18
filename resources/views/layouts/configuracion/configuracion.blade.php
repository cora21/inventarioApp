@extends('layouts.app')

@section('title', 'Configuraciones del sistema')
@section('contenido')
<style>
    .card:hover {
        transform: scale(1.07); /* Aumenta el tamaño en un 5% al pasar el mouse */
    }
</style>

<div class="row">
    <div class="col-md-3">
        <div class="card shadow" style="width: 170px; text-align: center; transition: transform 0.3s ease;">
            <div class="card-body">
                <button type="button" id="btnConfigurarColores" data-bs-toggle="modal" data-bs-target="#exampleModalConfiColors" style="background: none; border: none; padding: 0;">
                    <img src="{{ asset('storage/ruedaColorImagen.png') }}" alt="Configurar Colores" style="width: 120px; height: 120px;">
                </button>
                <p class="card-text mt-2"><h5>Configura colores para los productos</h5></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow" style="width: 180px; text-align: center; transition: transform 0.3s ease;">
            <div class="card-body">
                <button type="button" id="btnConfigurarMarcas" data-bs-toggle="modal" data-bs-target="#exampleModalParaMarcas" style="background: none; border: none; padding: 0;">
                    <img src="{{ asset('storage/marcaConfiguracion.png') }}" alt="Configurar Marcas" style="width: 120px; height: 120px;">
                </button>
                <p class="card-text mt-2"><h5>Configura las marcas para los productos</h5></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agreegar colores -->
<div class="modal fade" id="exampleModalConfiColors" tabindex="-1" aria-labelledby="exampleModalConfiColorsLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalConfiColorsLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        ...
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
    </div>
</div>
</div>

<!-- Modal para configurar las marcas -->
<div class="modal fade" id="exampleModalParaMarcas" tabindex="-1" aria-labelledby="exampleModalParaMarcasLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalParaMarcasLabel">Marcas Configuración</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        ...
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
    </div>
</div>
</div>
@endsection