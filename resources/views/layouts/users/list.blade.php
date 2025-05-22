{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Perfil de usuario')

@section('contenido')
    <h1>estoy dentro del perfil del usuario</h1>

    <main class="m-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Perfil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane"
                    aria-selected="false">Configuración</button>
            </li>
        </ul>
        {{-- da inicio a la nav para navegar por los datos de los usuarios --}}
        <div class="tab-content" id="myTabContent">
            {{-- nav que contiene formulario de datos de la empresa --}}
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <h3>Configuración del perfil</h3>
                            <div class="row">
                                <!-- Nombre Comercial -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Nombre:</label>
                                    <input type="text" name="first_name" class="form-control"
                                    value="{{ auth()->user()->first_name }}" required>
                                        required>
                                    <small class="form-text text-muted">Ingrese el nombre con el que se identifica la
                                        empresa.</small>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>

                                <!-- RIF/Cédula -->
                                <div class="col-md-6">
                                    <label for="rif_cedulaEmpresa" class="form-label">RIF/Cédula:</label>
                                    <input type="text" name="rif_cedulaEmpresa" class="form-control"
                                    value="{{ auth()->user()->email }}" required>
                                    <small class="form-text text-muted">Ingrese el RIF o cédula jurídica de la
                                        empresa.</small>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Correo Electrónico -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico:</label>
                                    <input type="email" name="email" class="form-control"
                                    value="{{ auth()->user()->email }}" required>
                                    <small class="form-text text-muted">Ingrese el correo electrónico oficial de la
                                        empresa.</small>
                                    <div class="invalid-feedback">Ingrese un correo válido.</div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Guardar Perfil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- fin de nav datos de la empresa --}}

            {{-- nav de claves y usuario de la empresa --}}
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <br>
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h2>Configuración del inicio de sesión</h2>
                            <input type="hidden" name="email" class="form-control" value="{{ auth()->user()->id }}">
                            {{-- <form action="{{ route('perfilUsuario.update') }}" method="POST" class="needs-validation" novalidate> --}}
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ auth()->user()->first_name }}" required>
                                    <small class="form-text text-muted">Ingrese su nombre completo.</small>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ auth()->user()->email }}" required>
                                    <small class="form-text text-muted">Ingrese su dirección de correo válida.</small>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Nueva Contraseña -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="********">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="password">
                                            👁️
                                        </button>
                                    </div>
                                    <small class="form-text text-muted">Dejar en blanco para no cambiar.</small>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="********">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="password_confirmation">
                                            👁️
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Las contraseñas deben coincidir.</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- nav fin de claves y datos de la empresa --}}
        </div>


    </main>






    <script>
        // Bootstrap validación frontend
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const telefonoInput = document.getElementById("telefonoEmpresa");

            telefonoInput.addEventListener("input", function() {
                let value = telefonoInput.value.replace(/\D/g, ""); // Eliminar todo lo que no sea número
                if (value.length > 11) value = value.substring(0, 11); // Limitar a 11 dígitos

                let formattedValue = "";
                if (value.length >= 4) {
                    formattedValue = `(${value.substring(0, 4)}) `;
                    if (value.length >= 7) {
                        formattedValue += `${value.substring(4, 7)}-`;
                        if (value.length > 7) {
                            formattedValue += `${value.substring(7, 9)}-`;
                            if (value.length > 9) {
                                formattedValue += `${value.substring(9, 11)}`;
                            }
                        }
                    } else {
                        formattedValue += value.substring(4);
                    }
                } else {
                    formattedValue = value;
                }

                telefonoInput.value = formattedValue;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('.needs-validation');
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("password_confirmation");
            const togglePasswordButtons = document.querySelectorAll(".toggle-password");

            // Mostrar/Ocultar contraseñas
            togglePasswordButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const targetInput = document.getElementById(targetId);

                    if (targetInput.type === "password") {
                        targetInput.type = "text";
                        this.textContent = "🙈";
                    } else {
                        targetInput.type = "password";
                        this.textContent = "👁️";
                    }
                });
            });

            // Validar que las contraseñas coincidan
            confirmPasswordInput.addEventListener("input", function() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity("Las contraseñas no coinciden.");
                } else {
                    confirmPasswordInput.setCustomValidity("");
                }
            });

            // Validación Bootstrap
            form.addEventListener("submit", function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>

@endsection
