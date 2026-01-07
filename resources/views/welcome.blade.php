<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-image: url('{{ asset('images/fondo.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="relative min-h-screen">
        
        <div class="flex flex-col items-center justify-center h-screen text-center px-6">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800 md:text-5xl">Bienvenidos a Zprontr</h1>
                <p class="mt-4 text-lg text-gray-600">Sistema de generación de números para la gestión documental interna y externa</p>
            </div>

            <div class="w-full max-w-3xl mb-8">
                <img src=" {{ asset('images/zprontr.webp')}} " alt="Imagen principal" class="w-full h-auto rounded-lg shadow-lg">
            </div>

            <div class="space-x-4">
                @if (Route::has('login'))
                    <nav class="flex space-x-4">
                        @auth
                            @if (auth()->user()->role === 'ADMIN')
                                <a href="{{ url('/dashboard-admin') }}" class="rounded-md px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 shadow-md">
                                    Dashboard
                                </a>
                            @elseif (auth()->user()->role === 'USER')
                                <a href="{{ url('/dashboard-user') }}" class="rounded-md px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 shadow-md">
                                    Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 shadow-md">
                                Iniciar Sesión
                            </a>

                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
