<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Inicio de sesion')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Incluir SweetAlert 2 (en la cabecera de tu vista) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">



@section('contenido')
<input type="hidden" style="width: 25%" class="form-control" value="{{ $fechaActualizacion }}" />
<input type="hidden" style="width: 25%" class="form-control" value="{{ $fechaDelRegistro }}" />
    <h2 class="text-xl font-semibold mb-4">Bienvenido al sistema</h2>
    <input type="hidden" style="width: 25%" class="form-control" value="{{ $promedio }}" />
{{-- no me importa todo esta oculto --}}

@section('barraNavegacion')
@endsection
<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Ventas</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="truck"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{$cantidadProductosVendidos}}</h1>
                            <div class="mb-0">
                                <span class="text-danger">-3.65%</span>
                                <span class="text-muted">Desde la semana pasada</span>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Productos Registrados</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{$cantidadProductosPrincipal}}</h1>
                            <div class="mb-0">
                                <span class="text-success">5.25%</span>
                                <span class="text-muted">Desde la semana pasada</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Ganancias</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">$21.300</h1>
                            <div class="mb-0">
                                <span class="text-success">6.65%</span>
                                <span class="text-muted">Desde hace una semana</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Método de Pago disponibles</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{$MetodoPagoPrincipales}}</h1>
                            <div class="mb-0">
                                <span class="text-danger">-2.25%</span>
                                <span class="text-muted">Desde hace una semana</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Movimientos Recientes:</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <!-- Contenedor del gráfico -->
                    <div id="movimientosSemanales"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{-- script para las estadisticas de ventas --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Función para obtener y mostrar los datos en el gráfico
        function obtenerDatos() {
            fetch('/api/movimientos-semanales')
                .then(response => response.json())
                .then(data => {
                    // Extraer las fechas y ventas de los datos recibidos
                    const fechas = data.map(item => item.fecha); // Fechas del rango dinámico
                    const ventas = data.map(item => item.ventas); // Ventas por día

                    // Configuración del gráfico
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        series: [{
                            name: 'Ventas',
                            data: ventas
                        }],
                        xaxis: {
                            categories: fechas, // Fechas dinámicas en el eje X
                            labels: {
                                style: {
                                    colors: '#6e6e6e',
                                    fontSize: '12px'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (val) {
                                    return `${val}`; // Mostrar valor sin formato
                                },
                                style: {
                                    colors: '#6e6e6e',
                                    fontSize: '12px'
                                }
                            }
                        },
                        colors: ['#28a745'], // Cambia el color de las barras
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return `${val} ventas`;
                                }
                            }
                        },
                        grid: {
                            borderColor: 'rgba(0,0,0,0.1)',
                        }
                    };

                    // Renderizar o actualizar el gráfico
                    if (window.chart) {
                        window.chart.updateOptions(options);  // Actualiza el gráfico si ya existe
                    } else {
                        window.chart = new ApexCharts(document.querySelector("#movimientosSemanales"), options);
                        window.chart.render();  // Renderiza el gráfico si es la primera vez
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                });
        }

        // Llamar a la función al cargar la página
        obtenerDatos();

        // Actualización periódica cada 60 segundos (60000 ms)
        setInterval(obtenerDatos, 60000);
    });
</script>




{{-- segunda parte para el calendario --}}
<div class="row">


    <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Productos Más Vendidos desde hace una semana:</h5>
            </div>
            <div class="card-body d-flex">
                <div class="align-self-center w-100">
                    <div class="py-3">
                        <!-- Contenedor del gráfico circular -->
                        <div class="chart chart-xs">
                            <svg id="productosMasVendidos" width="200" height="200" viewBox="0 0 200 200" style="display: block; margin: 0 auto;"></svg>
                        </div>
                    </div>

                    <!-- Tabla de productos -->
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td id="producto1Nombre">Producto 1</td>
                                <td class="text-end" id="producto1Count">0</td>
                            </tr>
                            <tr>
                                <td id="producto2Nombre">Producto 2</td>
                                <td class="text-end" id="producto2Count">0</td>
                            </tr>
                            <tr>
                                <td id="producto3Nombre">Producto 3</td>
                                <td class="text-end" id="producto3Count">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            async function obtenerProductosVentas() {
                try {
                    const response = await fetch('/api/productos-ventas'); // Ruta de tu API
                    const data = await response.json(); // Los datos en formato JSON

                    // Tomar solo los 3 productos más vendidos
                    const topProductos = data.slice(0, 3);

                    // Actualizar la tabla con los datos
                    actualizarTabla(topProductos);

                    // Dibujar el gráfico circular con animación
                    drawPieChart(topProductos);
                } catch (error) {
                    console.error('Error al obtener los productos:', error);
                }
            }

            function actualizarTabla(data) {
                data.forEach((producto, index) => {
                    document.getElementById(`producto${index + 1}Nombre`).innerText = producto.nombre_producto;
                    document.getElementById(`producto${index + 1}Count`).innerText = producto.total_ventas;
                });
            }

            function drawPieChart(data) {
                const svg = document.getElementById('productosMasVendidos');
                svg.innerHTML = ''; // Limpia el contenido previo del SVG

                const total = data.reduce((sum, producto) => sum + parseInt(producto.total_ventas, 10), 0); // Suma total de ventas
                const radius = 100;
                const center = { x: radius, y: radius };
                const colors = ['#FF6384', '#36A2EB', '#FFCE56']; // Colores para los segmentos

                let cumulativePercentage = 0;

                const tooltip = document.createElement('div');
                tooltip.style.position = 'absolute';
                tooltip.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                tooltip.style.color = '#fff';
                tooltip.style.padding = '5px 10px';
                tooltip.style.borderRadius = '5px';
                tooltip.style.fontSize = '12px';
                tooltip.style.display = 'none';
                tooltip.style.pointerEvents = 'none';
                document.body.appendChild(tooltip);

                data.forEach((producto, index) => {
                    const percentage = parseInt(producto.total_ventas, 10) / total;
                    const startAngle = cumulativePercentage * 2 * Math.PI;
                    cumulativePercentage += percentage;
                    const endAngle = cumulativePercentage * 2 * Math.PI;

                    const x1 = center.x + radius * Math.sin(startAngle);
                    const y1 = center.y - radius * Math.cos(startAngle);
                    const x2 = center.x + radius * Math.sin(endAngle);
                    const y2 = center.y - radius * Math.cos(endAngle);

                    const largeArcFlag = percentage > 0.5 ? 1 : 0;

                    const pathData = `
                        M ${center.x} ${center.y}
                        L ${x1} ${y1}
                        A ${radius} ${radius} 0 ${largeArcFlag} 1 ${x2} ${y2}
                        Z
                    `;

                    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', pathData);
                    path.setAttribute('fill', colors[index % colors.length]);
                    path.style.transformOrigin = `${center.x}px ${center.y}px`;
                    path.style.transform = 'scale(0)';
                    path.style.transition = `transform 0.5s ease ${index * 0.2}s`;

                    // Mostrar tooltip al pasar el ratón
                    path.addEventListener('mousemove', (e) => {
                        tooltip.style.display = 'block';
                        tooltip.style.left = `${e.pageX + 10}px`;
                        tooltip.style.top = `${e.pageY + 10}px`;
                        tooltip.textContent = `${producto.nombre_producto}: ${producto.total_ventas} (${(percentage * 100).toFixed(1)}%)`;
                    });

                    // Ocultar tooltip al salir
                    path.addEventListener('mouseout', () => {
                        tooltip.style.display = 'none';
                    });

                    svg.appendChild(path);

                    // Aplicar animación después de agregar el elemento
                    setTimeout(() => {
                        path.style.transform = 'scale(1)';
                    }, 50);
                });
            }

            obtenerProductosVentas();
        </script>
    </div>









    <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Calendario</h5>
            </div>
            <div class="card-body d-flex">
                <div class="align-self-center w-100">
                    <div class="chart">
                        <!-- Aquí se renderiza el calendario -->
                        <div id="calendarioNuevo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
































{{-- es el scripts del navegador --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["tu casa", "Firefox", "IE"],
                datasets: [{
                    data: [3600, 3801, 1689],
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

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Script para Configurar el Calendario -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var calendarEl = document.getElementById('calendarioNuevo');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Vista inicial (mes)
            locale: 'es',                // Idioma en español
            buttonText: {               // Textos personalizados
                today: 'Hoy',
            },
            events: [                   // Ejemplo de eventos
                {
                    title: 'Evento 1',
                    start: '2024-01-10'
                },
                {
                    title: 'Evento 2',
                    start: '2024-01-15',
                    end: '2024-01-17'
                },
                {
                    title: 'Evento 3',
                    start: '2024-01-20T10:30:00',
                    allDay: false // No ocupa todo el día
                }
            ]
        });
        calendar.render(); // Renderiza el calendario
    });
</script>


@endsection
