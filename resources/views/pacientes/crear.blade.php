@extends('layouts.app')

@section('content')
<div class="antialiased font-sans bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 lg:px-24">
        <div class="py-8">
            <h2 class="text-2xl font-semibold leading-tight">Nuevo Paciente</h2>

            @if($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('pacientes.guardar') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-500">*</span></label>
                            <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos <span class="text-red-500">*</span></label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="cedula" class="block text-sm font-medium text-gray-700">C.I. o Pasaporte <span class="text-red-500">*</span></label>
                            <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edad" class="block text-sm font-medium text-gray-700">Edad <span class="text-red-500">*</span></label>
                            <input type="number" name="edad" id="edad" value="{{ old('edad') }}" min="0" max="150" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono <span class="text-red-500">*</span></label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección <span class="text-red-500">*</span></label>
                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2 px-4 rounded">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar Paciente
                        </button>
                        <a href="{{ route('pacientes.verificar') }}" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
