@extends('layouts.app')

@section('title', 'Configuraciones del sistema')
@section('contenido')
<style>
    .card-hover-scale:hover {
        transform: scale(1.07); /* o el valor que desees */
        transition: transform 0.3s ease;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">



<div class="row">
    <div class="col-md-3">
        <div class="card shadow card-hover-scale" style="width: 170px; text-align: center; transition: transform 0.3s ease;">
            <div class="card-body">
                <button type="button" id="btnConfigurarColores" data-bs-toggle="modal" data-bs-target="#exampleModalConfiColors" style="background: none; border: none; padding: 0;">
                    <img src="{{ asset('imagenes/ruedaColorImagen.png') }}" alt="Configurar Colores" style="width: 120px; height: 120px;">
                </button>
                <p class="card-text mt-2"><h5>Configura colores para los productos</h5></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        {{-- para que las card se agranden debemos colocarle esto class="card shadow card-hover-scale" --}}
        <div class="card shadow card-hover-scale" style="width: 180px; text-align: center; transition: transform 0.3s ease;">
            <div class="card-body">
                <button type="button" id="btnConfigurarMarcas" data-bs-toggle="modal" data-bs-target="#exampleModalParaMarcas" style="background: none; border: none; padding: 0;">
                    <img src="{{ asset('imagenes/marcaConfiguracion.png') }}" alt="Configurar Marcas" style="width: 120px; height: 120px;">
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
            <h1 class="modal-title fs-5" id="exampleModalConfiColorsLabel">Guarda un nuevo color:</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                + Registra un nuevo color
                            </button>
                            </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="{{ route('configuracion.colores.store') }}" method="POST">
                                            @csrf
                                            {{-- Input color --}}
                                            <div class="mb-3">
                                                <label for="selectorColor" class="form-label">Selecciona un color:</label>
                                                <input type="color" name="selectorColor" id="selectorColor" class="form-control form-control-color" value="#000000" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nombreColor" class="form-label">Nombre del color:</label>
                                                    <input type="text" name="nombreColor" id="nombreColor" class="form-control" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="codigoHexa" class="form-label">Código hexadecimal:</label>
                                                    <input type="text" name="codigoHexa" id="codigoHexa" class="form-control" readonly>
                                                </div>
                                            </div>
                                            {{-- Vista previa del color seleccionado --}}
                                            <div class="mb-3">
                                                <label class="form-label">Vista previa del color:</label>
                                                <div id="previewColor" style="width: 100%; height: 50px; border: 1px solid #ccc;"></div>
                                                <br>
                                                 {{-- Botón submit --}}
                                                <button type="submit" class="btn btn-primary" style="float: right;">Registrar color</button>
                                                <br>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                + Eliminar Colores
                            </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <form id="eliminarColorForm" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        {{-- Select de colores --}}
                                        <div class="mb-3 d-flex align-items-center gap-3">
                                            <label for="colorSelect" class="form-label mb-0">Selecciona un color:</label>
                                            <select id="colorSelect" class="form-select" style="width: 300px;">
                                                <option value="">-- Elige un color --</option>
                                                @foreach($colores as $color)
                                                    <option value="{{ $color->id }}"
                                                            data-nombre="{{ $color->nombreColor }}"
                                                            data-codigo="{{ $color->codigoHexa }}">
                                                        {{ $color->nombreColor }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            {{-- Circulo de color --}}
                                            <div id="colorPreviewCircle" style="width: 25px; height: 25px; border-radius: 50%; border: 1px solid #ccc;"></div>
                                        </div>

                                        {{-- Inputs visibles al seleccionar --}}
                                        <div id="colorDetails" style="display: none;">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="nombreColorSeleccionado" class="form-label">Nombre del color:</label>
                                                    <input type="text" class="form-control" id="nombreColorSeleccionado" disabled>
                                                </div>
                                                    <div class="col-md-4">
                                                        <label for="referenciaColor" class="form-label">Referencia del color:</label>
                                                        <input type="text" class="form-control" id="referenciaColor" disabled>

                                                    </div>
                                                <div class="col-md-4">
                                                    <label for="hexadecimalColor" class="form-label">Código hexadecimal:</label>
                                                    <input type="text" class="form-control" id="hexadecimalColor" disabled>
                                                </div>
                                            </div>

                                            {{-- Botón de eliminar --}}
                                            <button type="button" class="btn btn-danger" id="eliminarColorBtn">
                                                <i class="bi bi-trash3"></i> Eliminar color
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            {{-- <button type="submit" class="btn btn-primary">Registrar color</button> --}}
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




{{-- Script para actualizar preview y campo hexadecimal --}}
<script>
    const selectorColor = document.getElementById('selectorColor');
    const codigoHexa = document.getElementById('codigoHexa');
    const previewColor = document.getElementById('previewColor');

    function actualizarColor() {
        const color = selectorColor.value;
        previewColor.style.backgroundColor = color;
        codigoHexa.value = color;
    }

    selectorColor.addEventListener('input', actualizarColor);
    actualizarColor(); // inicializa con color por defecto
</script>
<script>
    const colorSelect = document.getElementById('colorSelect');
    const colorPreview = document.getElementById('colorPreviewCircle');
    const colorDetails = document.getElementById('colorDetails');
    const nombreColor = document.getElementById('nombreColorSeleccionado');
    const referenciaColor = document.getElementById('referenciaColor');
    const hexadecimalColor = document.getElementById('hexadecimalColor');
    const eliminarBtn = document.getElementById('eliminarColorBtn');
    const eliminarForm = document.getElementById('eliminarColorForm');

    let selectedColorId = null;

    colorSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value === "") {
            colorDetails.style.display = "none";
            colorPreview.style.backgroundColor = "transparent";
            selectedColorId = null;
            return;
        }

        const nombre = selectedOption.dataset.nombre;
        const codigo = selectedOption.dataset.codigo;

        nombreColor.value = nombre;
        hexadecimalColor.value = codigo;
        colorPreview.style.backgroundColor = codigo;
        referenciaColor.value = "";
        colorDetails.style.display = "block";
        selectedColorId = this.value;
    });

    eliminarBtn.addEventListener('click', function () {
        if (!selectedColorId) return;

        if (confirm("⚠️ Los productos con este color asignado perderán su color. ¿Está de acuerdo?")) {
            eliminarForm.action = `/configuracion/colores/${selectedColorId}`;
            eliminarForm.submit();
        }
    });
</script>

@endsection