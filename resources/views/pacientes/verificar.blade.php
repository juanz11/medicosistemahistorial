@extends('layouts.app')

@section('content')
<div class="antialiased font-sans bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 lg:px-24">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">Pacientes</h2>
            </div>
            <div class="my-2 flex sm:flex-row flex-col justify-between gap-2">
                <form method="GET" action="{{ route('pacientes.verificar') }}" class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <i class="fa-solid fa-magnifying-glass h-6 w-6 flex items-center justify-center text-gray-500"></i>
                    </span>
                    <input name="search" value="{{ $search }}" placeholder="Buscar"
                           class="appearance-none rounded-md border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                </form>
                <a href="{{ route('pacientes.crear') }}" class="text-sm bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded text-center">
                    <i class="fa-solid fa-user-plus mr-1"></i> Nuevo Paciente
                </a>
            </div>
            <div class="sm:-mx-8 px-0 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> ID </th>
                                <th class="px-2 py-2 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <span class="hidden md:block">Nombre y Apellido</span>
                                    <span class="block md:hidden">Nombres</span>
                                </th>
                                <th class="px-2 py-2 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <span class="hidden md:block">Cédula de Identidad</span>
                                    <span class="block md:hidden">Cédula</span>
                                </th>
                                <th class="hidden md:table-cell px-2 py-2 border-b-2 border-gray-300 bg-gray-200 text-center md:text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Última Visita </th>
                                <th class="px-2 py-2 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <span class="hidden md:block">Médico Tratante</span>
                                    <span class="block md:hidden">Médico</span>
                                </th>
                                <th class="px-2 py-2 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Historial</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pacientes as $paciente)
                                @php
                                    $medico = $paciente->user;
                                    $prefijo = $medico && $medico->tipo == 1 ? 'Dra.' : 'Dr.';
                                    $ultima = $paciente->ultimaConsulta->first();
                                    $cedulaNumeros = preg_replace('/\D/', '', $paciente->cedula);
                                    $cedulaFormato = strlen($cedulaNumeros) > 3
                                        ? number_format((float) $cedulaNumeros, 0, ',', '.')
                                        : $paciente->cedula;
                                @endphp
                                <tr class="hover:bg-stone-100 bg-white">
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="text-gray-900 whitespace-no-wrap"> P0{{ $paciente->id }} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 border-b border-gray-200 text-sm">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="hidden md:block text-gray-900 whitespace-no-wrap"> {{ $paciente->nombres }} {{ $paciente->apellidos }} </p>
                                                <p class="block md:hidden text-gray-900 whitespace-no-wrap"> {{ $paciente->nombres }} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $cedulaFormato }}</p>
                                    </td>
                                    <td class="hidden md:table-cell px-2 py-2 border-b border-gray-200 text-left">
                                        @if($ultima && $ultima->fecha_consulta)
                                            <p class="text-gray-900 whitespace-no-wrap"> {{ \Carbon\Carbon::parse($ultima->fecha_consulta)->format('d/m/Y') }} </p>
                                        @else
                                            <p class="text-gray-900 whitespace-no-wrap"> Sin visitas </p>
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell px-2 py-2 border-b border-gray-200 text-left">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            @if($medico) {{ $prefijo }} {{ $medico->nombres }} {{ $medico->apellidos }} @endif
                                        </p>
                                    </td>
                                    <td class="table-cell md:hidden px-2 py-2 border-b border-gray-200 text-left">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            @if($medico) {{ $prefijo }} {{ $medico->nombres }} @endif
                                        </p>
                                    </td>
                                    <td class="px-2 py-2 border-b border-gray-200 text-sm">
                                        <a href="{{ route('pacientes.historial', $paciente->id) }}" class="text-blue-700 hover:text-blue-900 font-semibold whitespace-no-wrap">
                                            <i class="fa-solid fa-file-medical mr-1"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white">
                                    <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center">
                                        <p class="text-gray-900">No existen registros.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <span class="text-xs xs:text-sm text-gray-900">
                            Mostrando {{ $pacientes->count() }} resultados de {{ $pacientes->total() }}
                        </span>
                        <div class="inline-flex mt-2 xs:mt-0">
                            @if($pacientes->onFirstPage())
                                <button class="disabled:opacity-50 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l" disabled> Anterior </button>
                            @else
                                <a href="{{ $pacientes->previousPageUrl() }}" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l"> Anterior </a>
                            @endif
                            <span class="text-sm bg-gray-200 text-gray-800 font-semibold py-2 px-4"> {{ $pacientes->currentPage() }} </span>
                            @if($pacientes->hasMorePages())
                                <a href="{{ $pacientes->nextPageUrl() }}" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r"> Siguiente </a>
                            @else
                                <button class="disabled:opacity-50 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r" disabled> Siguiente </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
