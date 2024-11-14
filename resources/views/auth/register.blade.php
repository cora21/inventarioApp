<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body style="background-color: #9A616D;" class="h-screen flex items-center justify-center">

    <section class="w-full h-full">
        <div class="container mx-auto py-5 h-full flex items-center justify-center">
            <!-- Cambié el max-w-4xl a max-w-lg para hacer la tarjeta más pequeña -->
            <div class="w-full max-w-lg bg-white items-center rounded-lg shadow-lg overflow-hidden" >
                <div class="flex flex-wrap justify-center">
                    <!-- Columna Derecha: Formulario -->
                    <div class="w-full flex items-center justify-center p-8">
                        <div class="w-full">
                            <h4 class="text-lg font-normal mb-6 text-gray-600 tracking-wide text-center"><strong>Registrate en el sistema</strong></h4>

                            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                                @csrf
                                <!-- Campo de registrar nombre -->
                                <div class="mb-4">
                                    <label for="first_name" :value="{{ __('First name') }}" class="block text-gray-600 ">Nombre:</label>

                                    <input id="first_name" class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="name" />
                                </div>

                                <!-- Campo de registrar segundo nombre -->
                                <div class="mb-4">
                                    <label for="last_name" :value="__('Last name')" class="block text-gray-600 ">Apellido:</label>

                                    <input id="last_name" class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                                </div>

                                <!-- Campo de registrar email -->
                                <div class="mb-4">
                                    <label for="email" value="{{ __('Email') }}" class="block text-gray-600 ">Correo Electrónico:</label>
                                    <input type="email" id="email" name="email" :value="old('email')" required autocomplete="username"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none " />
                                </div>

                                <!-- Campo de contraseña -->
                                <div class="mb-4">
                                    <label for="password" value="{{ __('Password') }}" class="block text-gray-600">Contraseña:</label>
                                    <input type="password" id="password" name="password" required autocomplete="new-password"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none " />
                                </div>

                                <!-- Campo de confirmación de la contraseña -->
                                <div class="mb-4">
                                    <label for="password_confirmation" value="{{ __('Confirm Password') }}" class="block text-gray-600">Confirma la Contraseña:</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none " />
                                </div>
                                <!-- Botón de registro -->
                                <div class="mb-4">
                                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition duration-200">
                                        Registrate
                                    </button>
                                </div>

                                <!-- Enlace de iniciar sesión -->
                                <div class="text-center">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                        ¿Ya posees una cuenta?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>

