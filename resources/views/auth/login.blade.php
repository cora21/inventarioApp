<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body style="background-color: #1f2937;" class="h-screen flex items-center justify-center">

    <section class="w-full h-full">
        <div class="container mx-auto py-5 h-full flex items-center justify-center">
            <!-- aqui si quiero cambiar el color del fondo blanco de la tarjeta  style="background-color: #424242;" -->
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden" >
                <div class="flex flex-wrap">
                    <!-- Columna Izquierda: Imagen -->
                    <div class="w-full md:w-1/2 hidden md:block">
                        <img src="https://www.captia.es/assets/img/web/Captia-Blog-Sistema-Inventario-Automatizado.jpg"
                             alt="Formulario de Inicio de Sesión"
                             class="object-cover w-full h-full rounded-l-lg">
                    </div>

                    <!-- Columna Derecha: Formulario -->
                    <div class="w-full md:w-1/2 flex items-center p-8 md:p-12 lg:p-16">
                        <div class="w-full">
                            <div class="flex items-center mb-6">
                                <i class="fas fa-cubes fa-2x mr-3 text-orange-500"></i>
                                <span class="text-2xl font-bold text-gray-700">Logo</span>
                            </div>

                            <h5 class="text-lg font-normal mb-6 text-gray-600 tracking-wide">Inicia sesión en el sistema</h5>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Campo de correo electrónico -->
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-600">Correo Electrónico</label>
                                    <input type="email" id="email" name="email" required
                                           class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none" />
                                </div>

                                <!-- Campo de contraseña -->
                                <div class="mb-4">
                                    <label for="password" class="block text-gray-600">Contraseña</label>
                                    <input type="password" id="password" name="password" required
                                           class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none" />
                                </div>

                                <!-- Botón de acceso -->
                                <div class="mb-4">
                                    <button type="submit"
                                            class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition duration-200">
                                        Iniciar Sesión
                                    </button>
                                </div>

                                <!-- Enlaces de ayuda -->
                                <div class="text-sm text-gray-600 text-center">
                                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">¿Olvidaste tu Contraseña?</a>
                                </div>
                                <p class="mt-5 text-sm text-center text-gray-600">
                                    ¿No tienes una cuenta?
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate aquí</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
