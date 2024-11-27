@extends('layouts.app')




@section('title', 'Registro de proveedores')


@section('contenido')
    <h1>este es el modulo de proveedores</h1>
    <div class="d-flex justify-content-between align-items-center">
        <!-- Botón alineado a la derecha -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistroAlmacen">
            + Nuevo Proveedor
        </button>
    </div>
    <br><br>
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr style="background-color: rgb(212, 212, 212); ">
            <th scope="col" style="border-radius: 15px 0px 0px 0px;">Nombre: </th>
            <th scope="col">Documento:</th>
            <th scope="col">Correo Electronico:</th>
            <th scope="col">Telf:</th>
            <th scope="col">Dirección:</th>
            <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
             @foreach ($proveedor as $row)
          <tr>
            <td>{{$row->nombreProveedor}}</td>
            <td>{{$row->nacionalidad}}.- {{$row->rif_cedula}}</td>
            <td>{{$row->emailProveedor}}</td>
            <td>{{$row->telefonoProveedor}}</td>
            <td>{{$row->direccionProveedor}}</td>
            <td>
                <a class="btn btn-primary dropdown-toggle d-none d-sm-inline-block"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="text-light">Acciones</span>
                </a>
                <div class="dropdown-menu dropdown-menu-tod">
                    <div class="dropdown-item text-center">
                        <a href="{{ route('proveedor.show', $row->id) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i data-feather="eye" class="me-2"></i> <span>Ver</span>
                        </a>
                    </div>
                    @can('users.show')
                        <div class="dropdown-item text-center">
                             <a href="{{ route('proveedor.edit', $row->id) }}"
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



    <!-- Modal para registrar el almacen -->
    <div class="modal fade" id="modalRegistroAlmacen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h1 class="modal-title fs-1 text-blue-200" id="exampleModalLabel">Registro de un nuevo Proveedor</h1>
                </div>
                <div class="modal-body">
                    <div class="mx-auto">
                        <div class="card">
                            <!-- Barra de progreso -->
                            <div class="progress" style="height: 15px;">
                                <div id="progress-bar" class="progress-bar progress-bar-striped bg-success py-5" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    0%
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('proveedor.store') }}" method="POST">
                                @csrf
                                <div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <label for=""><strong>Nombre de la empresa:</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input name="nombreProveedor" type="text" class="form-control mb-3 input-progreso @error('nombreProveedor') is-invalid @enderror" value="{{ old('nombreProveedor') }}">
                                            @error('nombreProveedor')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div>
                                                <small style="color: white"> hola </small>
                                            </div>

                                        </div>

                                        <div class="col">
                                            <label for=""><strong>Correo Electronico:</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input name="emailProveedor" type="email" class="form-control mb-3 input-progreso @error('emailProveedor') is-invalid @enderror" value="{{ old('emailProveedor') }}">
                                            <div>
                                                <small style="color: rgb(197, 194, 194)">ejemplo@ejemplo.com</small>
                                            </div>
                                            @error('emailProveedor')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for=""><strong>Número Telf.</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input name="telefonoProveedor" type="text" class="form-control mb-3 input-progreso @error('telefonoProveedor') is-invalid @enderror" placeholder="(0000)-000-00-00" value="{{ old('telefonoProveedor') }}">
                                            <div>
                                                <small style="color: rgb(197, 194, 194)">Favor ingrese un número de teléfono valido </small>
                                            </div>
                                            @error('telefonoProveedor')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <label for="documento"><strong>Documento de identidad:</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control" name="nacionalidad" id="documento" style="width: auto;">
                                                    <option value="V">V.-</option>
                                                    <option value="E">E.-</option>
                                                    <option value="J">J.-</option>
                                                    <option value="G">G.-</option>
                                                </select>
                                                <input type="text" id="rif_cedula" name="rif_cedula" placeholder="Número de documento" class="form-control input-progreso @error('rif_cedula') is-invalid @enderror" style="width: 70%;" value="{{ old('rif_cedula') }}" >
                                                <div>
                                                    <small style="color: rgb(197, 194, 194)">Si es una empresa ingrese RIF</small>
                                                </div>
                                                @error('rif_cedula')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for=""><strong>Dirección Corta:</strong></label>
                                            <input type="text" id="" name="direccionProveedor" class="form-control input-progreso" value="{{ old('direccionProveedor') }}">
                                            <div>
                                                <small style="color: rgb(255, 255, 255)">RIF</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                    {{-- el script que permite que el modal se abra exitosamente --}}
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                        const inputs = document.querySelectorAll(".input-progreso");
                        const progressBar = document.getElementById("progress-bar");
                        // Función para actualizar la barra de progreso
                        const updateProgressBar = () => {
                            let filledFields = 0;
                            // Cuenta los campos llenos
                            inputs.forEach(input => {
                                if (input.value.trim() !== "") {
                                    filledFields++;
                                }
                            });
                            // Calcula el porcentaje llenado
                            const progress = (filledFields / inputs.length) * 100;
                            progressBar.style.width = `${progress}%`;
                            progressBar.setAttribute("aria-valuenow", progress);
                            progressBar.textContent = `${Math.round(progress)}%`;
                            // Cambia el color según el progreso
                            if (progress === 100) {
                                progressBar.classList.remove("bg-success");
                                progressBar.classList.add("bg-primary");
                            } else {
                                progressBar.classList.add("bg-success");
                                progressBar.classList.remove("bg-primary");
                            }
                        };
                        // Escucha cambios en cada input
                        inputs.forEach(input => {
                            input.addEventListener("input", updateProgressBar);
                        });
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
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
                    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                            style="font-size: 1.2rem;">*</span>
                        <strong> son obligatorios</strong>
                    </p>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-gray">Guardar</button>
                </div>
                </form>

            </div>
        </div>
    </div>

@endsection
