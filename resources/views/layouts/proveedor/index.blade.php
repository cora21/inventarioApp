@extends('layouts.app')




@section('title', 'Registro de proveedores')


@section('contenido')
    <h1>este es el modulo de proveedores</h1>
    <div class="d-flex justify-content-between align-items-center">
        <!-- Botón alineado a la derecha -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistroAlmacen">
            + Nuevo almacén
        </button>
    </div>




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

                            <div class="card-body">
                                <div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <label for=""><strong>Nombre de la empresa:</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input type="text" class="form-control mb-3 input-progreso" value="">
                                        </div>
                                        <div class="col">
                                            <label for=""><strong>Correo Electronico:</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input type="email" class="form-control mb-3 input-progreso" value="">
                                        </div>
                                        <div class="col">
                                            <label for=""><strong>Número Telf.</strong></label>
                                        </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                                            <input type="text" class="form-control mb-3 input-progreso" value="">
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
                                                <select class="form-control" name="documento" id="documento" style="width: auto;">
                                                    <option value="V">V.-</option>
                                                    <option value="E">E.-</option>
                                                    <option value="J">J.-</option>
                                                    <option value="G">G.-</option>
                                                </select>
                                                <input type="text" id="numero-documento" name="numero-documento" placeholder="Número de documento" class="form-control input-progreso" style="width: 70%;">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="telefono"><strong>Dirección Corta:</strong></label>
                                            <input type="text" id="telefono" name="telefono" class="form-control input-progreso">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="progress" style="height: 15px;">
                        <div id="progress-bar" class="progress-bar progress-bar-striped bg-success py-5" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            0%
                        </div>
                    </div>
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
