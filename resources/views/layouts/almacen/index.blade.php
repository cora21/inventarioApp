@extends('layouts.app')

@section('title', 'Registro de Almacen')

@section('contenido')


    <h2 class="title-1 m-b-25">Lista de los Almacenes</h2>
    {{-- boton del nuevo almacen --}}
        @if(session('success'))
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
    <div class="d-flex justify-content-between align-items-center">
        <!-- Select alineado a la izquierda -->
        <select class="form-select form-select-lg me-2" aria-label="Large select example"
            style="max-width: 300px; height: auto;">
            @foreach ($almacen as $row)
            <option value="{{ $row->nombre }}">{{ $row->nombre }}</option>
            @endforeach
        </select>
        <!-- Botón alineado a la derecha -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistroAlmacen">
           + Nuevo almacén
        </button>
    </div>
    <br><br>
    <div class="container center">



        <div class="card">
            <div class="card-body">
                        <table class="table table-hover response">
                            <thead>
                                {{-- si funciona --}}
                                <tr style="background-color: rgb(212, 212, 212); ">
                                    <th scope="col" style="border-radius: 15px 0px 0px 0px;">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                                </tr>
                            </thead>
                            @foreach ($almacen as $row)
                                <tbody class="table-group-divider">

                                    <tr>
                                        <th  class="border">{{ $row->id }}</th>
                                        <td class="border">{{ $row->nombre }}</td>
                                        <td class="border">{{ $row->direccion }}</td>
                                        <td class="border">{{ $row->observaciones }}</td>
                                        <td class="border">
                                            <a class="btn btn-primary dropdown-toggle d-none d-sm-inline-block"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="text-light">Acciones</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-tod">
                                                <div class="dropdown-item text-center">
                                                    <a href="{{ route('almacen.show', $row->id) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                                        <i data-feather="eye" class="me-2"></i> <span>Ver</span>
                                                    </a>
                                                </div>
                                                @can('users.show')
                                                    <div class="dropdown-item text-center">
                                                        <a href="{{ route('almacen.edit', $row->id) }}"
                                                            class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                                            <i data-feather="edit-2" class="me-2"></i> <span>Editar</span>
                                                        </a>
                                                    </div>
                                                @endcan
                                                <div class="dropdown-item text-center">
                                                    @can('users.show')
                                                        <a
                                                            class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                                                            <i data-feather="trash" class="me-2"></i> <span>Eliminar</span>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
            </div>
        </div>

        <!-- Modal para registrar el almacen -->
        <div class="modal fade" id="modalRegistroAlmacen" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header no-border">
                        <h1 class="modal-title fs-1 text-blue-200" id="exampleModalLabel">Nuevo Almacén</h1>
                    </div>

                    <div class="modal-body">
                        <p class="card-text fs-4 text-dark">Aqui puedes registras los diferentes almacenes de tu empresa</p>
                        <div class="mx-auto" style="width: 70%;">
                            <div class="card">
                                <div class="card-body rounded shadow-lg">
                                    <form action="{{ route('almacen.store') }}" method="POST">
                                        <div class="container">
                                            <div class="row">
                                                @csrf
                                                <!-- Columna para los inputs -->
                                                <div class="col-md-6">
                                                    <label for="basic-url" class="text-dark" style="font-size: 1rem;"><strong>Nombre:
                                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                                        <div class="input-group mb-4">
                                                            <div class="input-group input-group-lg">
                                                                {{-- como puedo ver este lo uso de referencia para aplicar los estilos que necesito de las validaciones --}}
                                                                <input type="text"
                                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                                        aria-label="Sizing example input"
                                                                        aria-describedby="inputGroup-sizing-lg"
                                                                        name="nombre"
                                                                        value="{{ old('nombre') }}">

                                                        {{-- este mensaje de error es que hace que aparezcan el mensaje abajo asi que pendiente, entre comillas simples va la variable  --}}
                                                        {{-- usamos el value="{{ old('nombre') }}" para que las variables se mantengan asi el modal se cierre --}}
                                                                @error('nombre')
                                                                    <div class="invalid-feedback">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                    <div class="input-group mb-4">
                                                        <label for="basic-url"
                                                            class="text-dark" style="font-size: 1rem;"><strong>Dirección:</strong></label>
                                                        <div class="input-group input-group-lg">
                                                            <input type="text" class="form-control"
                                                                aria-label="Sizing example input"
                                                                aria-describedby="inputGroup-sizing-lg" name="direccion" value="{{ old('direccion') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Columna para el textarea -->
                                                <div class="col-md-6">
                                                    <label for="basic-url"
                                                    class="text-dark rounded" style="font-size: 1rem;"><strong>Observaciones:</strong></label>
                                                    <div class="input-group h-100">
                                                        <textarea name="observaciones" class="form-control" aria-label="With textarea" style="height: 90%; resize: none;">{{ old('observaciones') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                        {{-- dan inicio los scripts --}}
                        {{-- el script que permite que el modal se abra exitosamente --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                            // Revisa si hay errores de validación
                            @if ($errors->any())
                                // Selecciona el modal por su ID
                                const modal = new bootstrap.Modal(document.getElementById('modalRegistroAlmacen'));
                                // Muestra el modal
                                modal.show();
                            @endif
                        });
                        </script>

                    </div>
                    <div class="modal-footer">
                        <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger" style="font-size: 1.2rem;">*</span>
                            <strong> son obligatorios</strong>
                        </p>
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary text-gray">Guardar</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
