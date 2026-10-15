@extends('layouts.app')

@section('content')
<div class="antialiased font-sans bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 lg:px-24">
        <div class="py-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold leading-tight">Historial de Diagnósticos</h2>
                <a href="{{ route('pacientes.verificar') }}" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Datos del paciente --}}
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 text-lg">{{ $paciente->nombres }} {{ $paciente->apellidos }}</h3>
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm text-gray-700">
                    <p><span class="font-semibold">C.I. / Pasaporte:</span> {{ $paciente->cedula }}</p>
                    <p><span class="font-semibold">Edad:</span> {{ $paciente->edad }} años</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $paciente->telefono }}</p>
                    <p><span class="font-semibold">Dirección:</span> {{ $paciente->direccion }}</p>
                </div>
            </div>

            {{-- Nuevo diagnóstico --}}
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800">Registrar Diagnóstico</h3>
                <form method="POST" action="{{ route('consultas.guardar', $paciente->id) }}" class="mt-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de la consulta <span class="text-red-500">*</span></label>
                            <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label for="proxima_cita" class="block text-sm font-medium text-gray-700">Próxima cita</label>
                            <input type="date" name="proxima_cita" id="proxima_cita" value="{{ old('proxima_cita') }}"
                                   class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico / Detalles <span class="text-red-500">*</span></label>
                            <textarea name="diagnostico" id="diagnostico" rows="3" required
                                      class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">{{ old('diagnostico') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label for="tratamiento" class="block text-sm font-medium text-gray-700">Tratamiento</label>
                            <textarea name="tratamiento" id="tratamiento" rows="2"
                                      class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">{{ old('tratamiento') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="2"
                                      class="mt-1 block w-full rounded-md border border-gray-400 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2 px-4 rounded">
                            <i class="fa-solid fa-plus mr-1"></i> Agregar Diagnóstico
                        </button>
                    </div>
                </form>
            </div>

            {{-- Historial --}}
            <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                            <th class="px-5 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diagnóstico</th>
                            <th class="px-5 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Próxima Cita</th>
                            <th class="px-5 py-3 border-b-2 border-gray-300 bg-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Atendido por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            @php
                                $medico = $consulta->user;
                                $prefijo = $medico && $medico->tipo == 1 ? 'Dra.' : 'Dr.';
                            @endphp
                            <tr class="hover:bg-stone-100 bg-white">
                                <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 whitespace-no-wrap">
                                    {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900">
                                    <p class="whitespace-pre-line">{{ $consulta->diagnostico }}</p>
                                    @if($consulta->tratamiento)
                                        <p class="text-xs text-gray-500 mt-1"><span class="font-semibold">Tratamiento:</span> {{ $consulta->tratamiento }}</p>
                                    @endif
                                    @if($consulta->observaciones)
                                        <p class="text-xs text-gray-500 mt-1"><span class="font-semibold">Observaciones:</span> {{ $consulta->observaciones }}</p>
                                    @endif
                                    @php
                                        $detalles = [
                                            'Motivo' => $consulta->motivo,
                                            'Enfermedad actual' => $consulta->enfermedad,
                                            'Antecedentes' => $consulta->antecedentes,
                                            'Neuro' => $consulta->neuro,
                                            'Neuro superior' => $consulta->neuro_superior,
                                            'Neuro pares' => $consulta->neuro_pares,
                                            'Neuro sistema' => $consulta->neuro_sistema,
                                            'Neuro sensibilidad' => $consulta->neuro_sensibilidad,
                                            'Neuro taxia' => $consulta->neuro_taxia,
                                            'Neuro praxia' => $consulta->neuro_praxia,
                                            'Lab. básico' => $consulta->laboratorio_basico,
                                            'Lab. complementario' => $consulta->laboratorio_complementario,
                                        ];
                                    @endphp
                                    <details class="mt-2">
                                        <summary class="text-xs text-blue-700 cursor-pointer hover:underline">Ver detalles de la consulta</summary>
                                        <div class="mt-1 text-xs text-gray-600 space-y-1">
                                            @foreach($detalles as $label => $valor)
                                                <p><span class="font-semibold">{{ $label }}:</span> {{ ($valor !== null && trim((string)$valor) !== '') ? $valor : '—' }}</p>
                                            @endforeach
                                        </div>
                                    </details>
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 whitespace-no-wrap">
                                    {{ $consulta->proxima_cita ? \Carbon\Carbon::parse($consulta->proxima_cita)->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 whitespace-no-wrap">
                                    @if($medico) {{ $prefijo }} {{ $medico->nombres }} {{ $medico->apellidos }} @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="4" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-900">
                                    Este paciente aún no tiene diagnósticos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
