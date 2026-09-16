@extends('layouts.app')

@section('content')
<div class="antialiased font-sans bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 lg:px-24">
        <div class="py-8">
            <h2 class="text-2xl font-semibold leading-tight">Inicio</h2>
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <p class="text-gray-700">
                    Bienvenido a <b class="font-semibold">SISMED</b>, {{ Auth::guard('web')->user()->nombres }} {{ Auth::guard('web')->user()->apellidos }}.
                </p>
                <p class="text-gray-500 text-sm mt-1">Sistema de Historias Clínicas - SNC PHARMA, C.A.</p>
            </div>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('pacientes.verificar') }}" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <i class="fa-solid fa-address-book text-3xl text-blue-700"></i>
                    <h3 class="mt-3 font-semibold text-gray-800">Verificar Pacientes</h3>
                    <p class="text-sm text-gray-500 mt-1">Consulte el listado de pacientes registrados en el sistema.</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
