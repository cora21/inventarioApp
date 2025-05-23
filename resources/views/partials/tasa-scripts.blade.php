{{-- tasa-scripts.blade.php --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaActualizacion = new Date("{{ $fechaActualizacion }}");
        const fechaDelRegistro = new Date("{{ $fechaDelRegistro }}");

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
                    fetch('/actualizar-tasa-cambio', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: 2,
                            valorMoneda: "{{ $promedio }}",
                            created_at: "{{ $fechaActualizacion }}"
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Actualizado', 'Tasa de cambio actualizada correctamente.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'No se pudo actualizar la tasa de cambio.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Error al procesar la solicitud: ' + error.message, 'error');
                    });
                }
            });
        }
    });

    function updateBaseMoneda(moneda) {
        document.cookie = "baseMoneda=" + moneda + ";path=/;max-age=31536000";

        $.ajax({
            url: "{{ route('updateBaseMoneda') }}",
            method: "POST",
            data: {
                moneda: moneda,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire('¡Éxito!', 'Moneda base actualizada a ' + moneda, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', response.message || 'Error al actualizar.', 'error');
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'Error con la solicitud: ' + error, 'error');
            }
        });
    }

    function updateBaseMonedaAndUI(moneda) {
        updateBaseMoneda(moneda);
        document.getElementById('activeSymbol').textContent = (moneda === 'USD') ? '$' : 'Bs';
        const usdLabel = document.getElementById('label-usd');
        const vesLabel = document.getElementById('label-ves');

        if (moneda === 'USD') {
            usdLabel.classList.add('btn-success', 'active');
            usdLabel.classList.remove('btn-outline-success');
            vesLabel.classList.add('btn-outline-success');
            vesLabel.classList.remove('btn-success', 'active');
        } else {
            vesLabel.classList.add('btn-success', 'active');
            vesLabel.classList.remove('btn-outline-success');
            usdLabel.classList.add('btn-outline-success');
            usdLabel.classList.remove('btn-success', 'active');
        }

        const currencyLabel = document.getElementById('currencyLabel');
        if (moneda === 'USD') {
            currencyLabel.textContent = '$ 1.00';
        } else {
            currencyLabel.textContent = 'Bs. ' + parseFloat({{ $dolarDesdeBase }}).toFixed(2);
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
