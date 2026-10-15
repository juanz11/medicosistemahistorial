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
    <style>
        .texto-activado { color: #fff !important; }
        .sidebar { transition: width .5s ease; }
        .footer2 { left: 0; bottom: 0; width: 100%; text-align: center; }
        .bg-person { background-color: #c9c9c944; }
    </style>
</head>
<body>
<div class="min-h-screen flex flex-col flex-auto flex-shrink-0">

    {{-- Sidebar --}}
    <div class="fixed flex flex-col left-0 sidebar min-h-screen w-[3.35rem] overflow-hidden border-r hover:w-56 bg-white hover:shadow-lg z-10">
        <div class="flex h-screen flex-col justify-between pt-2 pb-6 flex-grow">
            <div>
                <div class="w-max p-2.5 flex">
                    <img src="{{ asset('assets/logo.svg') }}" alt="Logo SISMED" width="35">
                    <span class="pl-2.5 pt-1.5 font-medium">SISMED</span>
                </div>
                <ul class="mt-1 space-y-2 tracking-wide">
                    <hr>
                    <li class="min-w-max">
                        <a href="{{ route('home') }}" class="group flex items-center space-x-4 px-4 py-3 text-gray-600 {{ request()->routeIs('home') ? 'bg-gray-200' : '' }}">
                            <i class="fa-solid fa-house h-6 w-6 flex items-center justify-center text-gray-700 group-hover:text-blue-900"></i>
                            <span class="mr-1 font-medium">INICIO</span>
                        </a>
                    </li>
                    <hr>
                    <li class="min-w-max">
                        <a href="{{ route('pacientes.verificar') }}" class="group flex items-center space-x-4 px-4 py-3 {{ request()->routeIs('pacientes.verificar') ? 'bg-gradient-to-r from-blue-600 to-sky-700 texto-activado' : 'text-gray-600' }}">
                            <i class="fa-solid fa-address-book h-6 w-6 flex items-center justify-center {{ request()->routeIs('pacientes.verificar') ? 'texto-activado' : 'text-gray-700' }} group-hover:text-blue-900"></i>
                            <span class="group-hover:text-gray-700">Verificar Pacientes</span>
                        </a>
                    </li>
                    <hr>
                    <li class="min-w-max">
                        <a href="{{ route('pacientes.crear') }}" class="group flex items-center space-x-4 px-4 py-3 {{ request()->routeIs('pacientes.crear') ? 'bg-gradient-to-r from-blue-600 to-sky-700 texto-activado' : 'text-gray-600' }}">
                            <i class="fa-solid fa-user-plus h-6 w-6 flex items-center justify-center {{ request()->routeIs('pacientes.crear') ? 'texto-activado' : 'text-gray-700' }} group-hover:text-blue-900"></i>
                            <span class="group-hover:text-gray-700">Nuevo Paciente</span>
                        </a>
                    </li>
                    <hr>
                </ul>
            </div>
            <div class="w-max -mb-3">
                <a href="{{ route('logout') }}" class="group flex items-center space-x-4 px-4 py-3 text-gray-600">
                    <i class="fa-solid fa-right-from-bracket h-6 w-6 flex items-center justify-center text-gray-700 group-hover:text-blue-900"></i>
                    <span class="group-hover:text-gray-700">Salir</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="h-full ml-14 ml-[3.4rem]">
        @yield('content')

        <footer class="footer footer2 footer-center w-full p-4 bg-person text-gray-800">
            <div class="text-center ml-[-3.6rem]">
                <p>Copyright © {{ date('Y') }} - <b class="font-semibold">SNC PHARMA, C.A.</b> - v1.0.6</p>
            </div>
        </footer>
    </div>
</div>
</body>
</html>
