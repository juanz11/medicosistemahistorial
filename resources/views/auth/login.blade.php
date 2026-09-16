<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>SISMED - SISTEMA DE HISTORIAS CLÍNICAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#00318c">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="antialiased font-sans bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-700 px-6 py-8 text-center">
                <img src="{{ asset('assets/logo.svg') }}" alt="Logo SISMED" width="60" class="mx-auto mb-3">
                <h1 class="text-2xl font-semibold text-white">SISMED</h1>
                <p class="text-blue-100 text-sm">Sistema de Historias Clínicas</p>
            </div>
            <form method="POST" action="{{ route('login.attempt') }}" class="px-6 py-6">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Correo electrónico</label>
                    <div class="relative">
                        <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                            <i class="fa-solid fa-envelope h-6 w-6 flex items-center justify-center text-gray-500"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="appearance-none rounded-md border border-gray-400 block pl-8 pr-3 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:text-gray-700 focus:outline-none">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Contraseña</label>
                    <div class="relative">
                        <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                            <i class="fa-solid fa-lock h-6 w-6 flex items-center justify-center text-gray-500"></i>
                        </span>
                        <input id="password" type="password" name="password" required
                               class="appearance-none rounded-md border border-gray-400 block pl-8 pr-3 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:text-gray-700 focus:outline-none">
                    </div>
                </div>
                @if($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif
                <button type="submit"
                        class="w-full text-sm bg-gradient-to-r from-blue-600 to-sky-700 hover:from-blue-700 hover:to-sky-800 text-white font-semibold py-2 px-4 rounded-md">
                    Iniciar Sesión
                </button>
            </form>
        </div>
        <p class="text-center text-xs text-gray-500 mt-4">Copyright © {{ date('Y') }} - <b class="font-semibold">SNC PHARMA, C.A.</b></p>
    </div>
</body>
</html>
