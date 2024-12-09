@extends('layouts.app')


@section('estilos')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Limitar el tamaño máximo de las imágenes */
        .img-fluid {
            max-height: 80px;
        }

        /* Efecto hover para las tarjetas (opcional) */
        .bg-light:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        @endsection

@section('title', 'Nuevo Metodo de pago')

@section('contenido')
    @if (session('success'))
        <script>
            Swal.fire({
                title: '¡Registrado con éxito!',
                text: '{{ session('success') }}',
                icon: "success",
                confirmButtonText: "Aceptar",
                timer: 1500, // Desaparece después de 3 segundos
            });
        </script>
    @endif
    <h2 class="title-1 m-b-25">Métodos de Pago</h2>
    {{-- boton del nuevo almacen --}}
    <div style="display: flex; justify-content: flex-end;">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            data-bs-target="#exampleModalRegistroMetodo">
            <i class="align-middle" data-feather="plus"></i> Nuevo Método de Pago
        </button>
    </div>
    <br>
    <div class="container">
        <div class="row">
            @foreach ($metPago as $row)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="bg-light border rounded shadow-sm p-3 text-center">
                    <h5 class="fw-bold text-secondary mb-2">{{ $row->nombreMetPago }}</h5>
                    <p class="text-muted small">{{ $row->observacionesMetPago }}</p>
                    <div class="mb-3">
                        @if ($row->imagenMetPago)
                            <a href="{{ $row->imagenMetPago }}" target="_blank">
                                <img src="{{ $row->imagenMetPago }}" alt="Imagen del método" class="img-fluid rounded" style="max-width: 80px;">
                            </a>
                        @else
                            <!-- Ícono de banco cuando no hay imagen -->
                            <div class="text-muted">
                                <i class="bi bi-bank" style="font-size: 3rem;"></i>
                                <p class="small mt-1">No hay imagen disponible</p>
                            </div>
                        @endif
                    </div>
                    <a class="btn btn-primary dropdown-toggle d-none d-sm-inline-block" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="text-light">Acciones</span>
                </a>
                <div class="dropdown-menu dropdown-menu-tod">
                    <div class="dropdown-item text-center">
                        <a href="{{ route('metodo.show', $row->id) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i data-feather="eye" class="me-2"></i> <span>Ver</span>
                        <a/>
                    </div>
                    <div class="dropdown-item text-center">
                    @can('users.show')
                        <a href="{{ route('metodoPago.edit', $row->id) }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                            <i data-feather="edit-2" class="me-2"></i> <span>Editar</span>
                        </a>
                    @endcan
                </div>
                    <div class="dropdown-item text-center">
                        @can('users.show')
                            <a class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                                <i data-feather="trash" class="me-2"></i> <span>Eliminar</span>
                            </a>
                        @endcan
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    















    <!-- Modal que da incio al registro de un nuevo metodo de pago -->
    <div class="modal fade" id="exampleModalRegistroMetodo" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Nuevo Metodo de Pago</h1>
                </div>
                <div class="modal-body" style="background-color: rgb(236, 236, 236)">
                    {{-- aqui comienza el modal del registro de los metodos de pago --}}
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('metodo.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nombreMetPago" class="text-dark" style="font-size: 1.2rem;">
                                            Método de Pago: <span class="text-danger" style="font-size: 1.2rem;">*
                                            </span></label>
                                        <input type="text" name="nombreMetPago" id="nombreMetPago" maxlength="50"
                                            class="form-control" placeholder="">
                                        @error('nombreMetPago')
                                            <small> <span class="text-danger">{{ $message }}</span></small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="imageMetodo" class="text-dark" style="font-size: 1.2rem;">Selecciona una
                                            imagen: </label>
                                        <input type="file" name="imageMetodo" id="imageMetodo" class="form-control"
                                            accept="image/*">
                                        @error('imageMetodo')
                                            <small> <span class="text-danger">{{ $message }}</span></small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="observacionesMetPago" class="text-dark"
                                            style="font-size: 1.2rem;">Observaciones:</label>
                                        <textarea name="observacionesMetPago" id="observacionesMetPago" class="form-control" aria-label="With textarea"
                                            style="height: 100%; resize: none;"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-6 d-flex align-items-start">
                                        <div>
                                            <label for="previewImage" class="text-dark"
                                                style="font-size: 1.2rem;">Previsualización:</label>
                                            <img id="previewImage" src="" alt="Previsualización de la imagen"
                                                style="max-width: 150px; height: auto; display: none; border: 1px solid #ccc; padding: 5px; margin-top: 8px;">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <script>
                            const imageInput = document.getElementById('imageMetodo');
                            const previewImage = document.getElementById('previewImage');

                            imageInput.addEventListener('change', function(event) {
                                const file = event.target.files[0];

                                if (file) {
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        previewImage.src = e.target.result;
                                        previewImage.style.display = 'block'; // Muestra la imagen
                                    };

                                    reader.readAsDataURL(file); // Lee el archivo y genera una URL base64
                                } else {
                                    previewImage.style.display = 'none'; // Oculta la imagen si no hay archivo seleccionado
                                }
                            });
                        </script>
                        <br><br>
                    </div>
                </div>

                {{-- de aqui para arriba es el final del modal registro-metodos --}}
                <div class="modal-footer">
                    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                            style="font-size: 1.7rem;">* </span>
                        <strong> son obligatorios</strong>
                    </p>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-gray">Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection


{{-- utilidades
    plus<i class="align-middle" data-feather="grid"></i>

    --}}


{{-- AREAS DE  SCRIPT --}}
