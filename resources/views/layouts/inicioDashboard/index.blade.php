<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Inicio de sesion')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Incluir SweetAlert 2 (en la cabecera de tu vista) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@section('contenido')
<input type="hidden" style="width: 25%" class="form-control" value="{{ $fechaActualizacion }}" />
<input type="hidden" style="width: 25%" class="form-control" value="{{ $fechaDelRegistro }}" />
    <h2 class="text-xl font-semibold mb-4">Bienvenido al sistema</h2>
    <input type="hidden" style="width: 25%" class="form-control" value="{{ $promedio }}" />
{{-- no me importa todo esta oculto --}}


<div class="container mt-4">
    <!-- Contenedor con flexbox -->
    <div class="d-flex justify-content-between align-items-center">
        <!-- Título a la izquierda -->
        <p class="h3 mb-0">
            Precio del Dólar BCV:
            <strong>{{ number_format($dolarDesdeBase, 2) }}</strong>
        </p>
        <!-- Botones alineados a la derecha -->
        <div>
            <input type="radio" class="btn-check" name="moneda" id="usd-radio" autocomplete="off" value="USD"
                onclick="updateBaseMoneda('USD')" <?php echo isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'USD' ? 'checked' : ''; ?>>
            <label class="btn btn-outline-success btn-lg me-2" for="usd-radio">Dólares</label>

            <input type="radio" class="btn-check" name="moneda" id="ves-radio" autocomplete="off" value="VES"
                onclick="updateBaseMoneda('VES')" <?php echo isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'VES' ? 'checked' : ''; ?>>
            <label class="btn btn-outline-success btn-lg" for="ves-radio">Bolivares</label>
        </div>
    </div>
</div>



    <br><br><br>

@if($vesBaseMoneda === 1)
        <div class="bg-primary" style="height: 100%">
            soy el puto amo
        </div>
@else
    <p>La moneda VES está en <strong>{{$vesBaseMoneda}}</strong>.</p>
@endif





















    {{-- compara las fechas, abre el sweet alert, y actualiza dolar desde el api --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Convertir las fechas que pasamos del servidor a objetos Date de JavaScript
            const fechaActualizacion = new Date("{{ $fechaActualizacion }}");
            const fechaDelRegistro = new Date("{{ $fechaDelRegistro }}");

            // Comparar las fechas, si la fecha de actualización es más reciente
            if (fechaActualizacion > fechaDelRegistro) {
                Swal.fire({
                    title: '¿Quieres actualizar la tasa de cambio?',
                    text: "La fecha de actualización es más reciente que la registrada.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar la solicitud para actualizar el registro con el ID 2
                        fetch('/actualizar-tasa-cambio', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    id: 2,
                                    valorMoneda: "{{ $promedio }}", // El valor de la tasa de cambio
                                    created_at: "{{ $fechaActualizacion }}" // La nueva fecha de actualización
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Actualizado',
                                        'La tasa de cambio se ha actualizado correctamente.',
                                        'success'
                                    ).then(() => {
                                        // Recargar la página después de que el usuario haga clic en "Aceptar"
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'No se pudo actualizar la tasa de cambio.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error',
                                    'Ocurrió un error al procesar la solicitud: ' + error.message,
                                    'error'
                                );
                            });
                    }
                });
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateBaseMoneda(moneda) {
            // Establecer la cookie para recordar la selección de la moneda
            document.cookie = "baseMoneda=" + moneda + ";path=/;max-age=31536000"; // cookie de 1 año

            // Enviar la solicitud AJAX
            $.ajax({
                url: "{{ route('updateBaseMoneda') }}", // Ruta que manejará la actualización en el backend
                method: "POST",
                data: {
                    moneda: moneda,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Cuando la respuesta sea exitosa, actualizar la interfaz
                    if (response.success) {
                        // Deseleccionar todos los radios
                        $('input[name="moneda"]').prop('checked', false);
                        // Marcar el radio correspondiente
                        $('#' + moneda.toLowerCase() + '-radio').prop('checked', true);

                        // Alerta con SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'La moneda base ha sido actualizada a ' + moneda,
                            showConfirmButton: true,
                        }).then(() => {
                            // Recargar la página después de que el usuario haga clic en "Aceptar"
                            location.reload();
                        });
                    } else {
                        // Mostrar el mensaje de error si la respuesta no fue exitosa
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Hubo un problema al actualizar la moneda base.',
                            showConfirmButton: true,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Si hay un error en la solicitud, mostrar el mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema con la solicitud: ' + error,
                        showConfirmButton: true,
                    });
                }
            });
        }
    </script>

@endsection
