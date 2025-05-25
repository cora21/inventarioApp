<!DOCTYPE html>
<html lang="es">

<head>
    @yield('estilos')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
  
    <style>
    /* Colores principales */
    .sidebar {
        background-color: #284B26; /* Verde oscuro combinado con tu logo */
    }

    .sidebar .sidebar-brand {
        color: #ffffff;
    }

    .sidebar .sidebar-nav .sidebar-item:hover > .sidebar-link,
    .sidebar .sidebar-nav .sidebar-item.active > .sidebar-link {
        background-color: #3A6B3A;
        color: #fff !important;
        border-left: 4px solid #FFD700; /* Borde amarillo dorado */
    }

    .sidebar .sidebar-link {
        color: #f8f9fa;
        transition: all 0.3s ease-in-out;
        border-radius: 5px;
    }

    .sidebar .sidebar-link i {
        color: #dcdcdc;
    }

    .sidebar .logout-btn {
        width: 100%;
        margin-top: auto;
        border-radius: 5px;
        background-color: #4B7447;
    }

    .sidebar .logout-btn:hover {
        background-color: #3A6B3A;
    }
    </style>

    <!-- Fuente y Favicon -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- URL canónica (no es necesaria con Laravel) -->
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>@yield('title')</title>

    <!-- Archivo CSS principal de la plantilla Adminkit -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <!-- Fuente de Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"> --}}
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar {{ request()->routeIs('venta.index') ? 'collapsed' : '' }}">
        {{-- <nav id="sidebar" class="sidebar js-sidebar"> --}}
            <div class="sidebar-content js-simplebar">
                <div class="sidebar-brand d-flex align-items-center justify-content-center py-3">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="img-fluid me-2" style="max-height: 40px;">
                <span class="align-middle fw-bold text-white fs-5">Inversiones MP</span>
            </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Panel de control
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="align-middle" data-feather="power"></i> <span class="align-middle">Principal</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('venta.index') }}">
                            <i class="align-middle" data-feather="shopping-cart"></i> <span
                                class="align-middle">Ventas</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('producto.index') }}">
                            <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Productos</span>
                        </a>
                    </li>

                     <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('categoria.index') }}">
                            <i class="align-middle" data-feather="grid"></i> <span
                                class="align-middle">Categorias</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('almacen.index') }}">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Almacenes</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('proveedor.index') }}">
                            <i class="align-middle" data-feather="users"></i> <span
                                class="align-middle">Proveedores</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('metodoPago.index') }}">
                            <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Métodos
                                de Pago</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a data-bs-toggle="collapse" href="#reportesMenu" class="sidebar-link collapsed" aria-expanded="false">
                            <i class="align-middle" data-feather="trending-up"></i> 
                            <span class="align-middle">Reportes</span>
                        </a>
                        <ul id="reportesMenu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('factura.index') }}">
                                    <i class="align-middle" data-feather="grid"></i> Transacciones
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('reporte.ventas.index') }}">
                                    <i class="align-middle" data-feather="bar-chart-2"></i> Reportes de ventas
                                </a>
                            </li>
                        </ul>
                    </li>                    

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('users.index') }}">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Perfil de Usuario</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('configuracion.index') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Configuraciones</span>
                        </a>
                    </li>
                </ul>
				<div class="text-center d-flex justify-content-center align-items-center" style="height: 100px;"> 
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<button type="submit" class="btn btn-secondary logout-btn">
							<i class="align-middle" data-feather="power"></i> 
							<span class="align-middle">Cerrar Sesión</span>
						</button>
					</form>
				</div>
				
				<style>
					.logout-btn {
						font-size: 16px; /* Tamaño de texto */
						padding: 10px 20px; /* Espaciado dentro del botón */
						transition: background-color 0.3s ease, color 0.3s ease; /* Transiciones suaves */
					}
				
					.logout-btn:hover {
						background-color: #c82333; /* Fondo más oscuro en hover */
						color: #fff; /* Color blanco en hover */
					}
				</style>
				
				
				
				
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <h2>@yield('nombreBarra')</h2>
                <div class="nav-item dropdown text-start" style="font-size: 15px;" id="moneda-dropdown-container"  @yield('barraNavegacion')>
                    <!-- Línea superior con símbolo y valor de referencia -->
                    <div class="d-flex align-items-center ms-4">
                        <span>
                            Ref.1 =
                            <span id="currencyLabel">
                                @php $bsValue = number_format($dolarDesdeBase, 2); @endphp
                                Bs. {{ $bsValue }}
                            </span>
                        </span>
                    </div>
                    <!-- Botón para abrir el dropdown -->
                    <a class="dropdown-toggle text-primary ms-4" href="#" id="currencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                        <span id="activeSymbol">{{ (isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'USD') ? '$' : 'Bs.' }}</span> Ref.
                    </a>
                    <!-- Dropdown -->
                    <div class="dropdown-menu p-3" aria-labelledby="currencyDropdown" style="min-width: 200px;">
                        <input type="radio" class="btn-check" name="moneda" id="dropdown-usd-radio" autocomplete="off" value="USD"
                            onclick="updateBaseMonedaAndUI('USD')" {{ (isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'USD') ? 'checked' : '' }}>
                        <label class="btn w-100 mb-2 {{ (isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'USD') ? 'btn-success active' : 'btn-outline-success' }}" for="dropdown-usd-radio" id="label-usd">
                            Dólares
                        </label>
                
                        <input type="radio" class="btn-check" name="moneda" id="dropdown-ves-radio" autocomplete="off" value="VES"
                            onclick="updateBaseMonedaAndUI('VES')" {{ (isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'VES') ? 'checked' : '' }}>
                        <label class="btn w-100 {{ (isset($_COOKIE['baseMoneda']) && $_COOKIE['baseMoneda'] == 'VES') ? 'btn-success active' : 'btn-outline-success' }}" for="dropdown-ves-radio" id="label-ves">
                            Bolívares
                        </label>
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">21</span>
                                </div>
                            </a>
                        </li>



                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                {{-- por si acaso en el futuro quiero colocarle alguna imagen al inicio de sesion  --}}
                                {{-- <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="" /> --}}

                                <span class="text-dark">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item logout-link" href="#">
                                        <i class="align-middle" data-feather="power"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">


                    {{-- aqui es el medio donde esta la tarjeta --}}
                    @yield('contenido')

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="" target="_blank">Soporte</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="" target="_blank">Centro de ayuda</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="" target="_blank">Privacidad</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="" target="_blank">Terminos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- <script src="{{ asset('js/app.js') }}"> </script> --}}

    {{-- ojito con esto ya que sdi lo activo el log out no abre esta loco --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}

    <script src="{{ asset('adminkit/js/app.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 225);
            gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
            // Line chart
            new Chart(document.getElementById("chartjs-dashboard-line"), {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                        "Dec"
                    ],
                    datasets: [{
                        label: "Sales ($)",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.primary,
                        data: [
                            2115,
                            1562,
                            1584,
                            1892,
                            1587,
                            1923,
                            2566,
                            2448,
                            2805,
                            3438,
                            2917,
                            3327
                        ]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        intersect: false
                    },
                    hover: {
                        intersect: true
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            reverse: true,
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 1000
                            },
                            display: true,
                            borderDash: [3, 3],
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pie chart
            new Chart(document.getElementById("chartjs-dashboard-pie"), {
                type: "pie",
                data: {
                    labels: ["Chrome", "Firefox", "IE"],
                    datasets: [{
                        data: [4306, 3801, 1689],
                        backgroundColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger
                        ],
                        borderWidth: 5
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Bar chart
            new Chart(document.getElementById("chartjs-dashboard-bar"), {
                type: "bar",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                        "Dec"
                    ],
                    datasets: [{
                        label: "This year",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                        barPercentage: .75,
                        categoryPercentage: .5
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false
                            },
                            stacked: false,
                            ticks: {
                                stepSize: 20
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var markers = [{
                    coords: [31.230391, 121.473701],
                    name: "Shanghai"
                },
                {
                    coords: [28.704060, 77.102493],
                    name: "Delhi"
                },
                {
                    coords: [6.524379, 3.379206],
                    name: "Lagos"
                },
                {
                    coords: [35.689487, 139.691711],
                    name: "Tokyo"
                },
                {
                    coords: [23.129110, 113.264381],
                    name: "Guangzhou"
                },
                {
                    coords: [40.7127837, -74.0059413],
                    name: "New York"
                },
                {
                    coords: [34.052235, -118.243683],
                    name: "Los Angeles"
                },
                {
                    coords: [41.878113, -87.629799],
                    name: "Chicago"
                },
                {
                    coords: [51.507351, -0.127758],
                    name: "London"
                },
                {
                    coords: [40.416775, -3.703790],
                    name: "Madrid "
                }
            ];
            var map = new jsVectorMap({
                map: "world",
                selector: "#world_map",
                zoomButtons: true,
                markers: markers,
                markerStyle: {
                    initial: {
                        r: 9,
                        strokeWidth: 7,
                        stokeOpacity: .4,
                        fill: window.theme.primary
                    },
                    hover: {
                        fill: window.theme.primary,
                        stroke: window.theme.primary
                    }
                },
                zoomOnScroll: false
            });
            window.addEventListener("resize", () => {
                map.updateSize();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
            var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
            document.getElementById("datetimepicker-dashboard").flatpickr({
                inline: true,
                prevArrow: "<span title=\"Previous month\">&laquo;</span>",
                nextArrow: "<span title=\"Next month\">&raquo;</span>",
                defaultDate: defaultDate
            });
        });
    </script>
    <script src="https://unpkg.com/feather-icons "></script>
    <script>
        feather.replace();
    </script>
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
<script>
    function updateBaseMonedaAndUI(moneda) {
        // Llama tu función original
        updateBaseMoneda(moneda);

        // Actualiza símbolo arriba
        document.getElementById('activeSymbol').textContent = (moneda === 'USD') ? '$' : 'Bs';

        // Actualiza color de botones
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

        // Opcional: también puedes actualizar el texto de referencia si deseas
        const currencyLabel = document.getElementById('currencyLabel');
        if (moneda === 'USD') {
            currencyLabel.textContent = '$ 1.00';
        } else {
            currencyLabel.textContent = 'Bs. ' + parseFloat({{ $dolarDesdeBase }}).toFixed(2);
        }
    }
</script>

</body>

</html>
