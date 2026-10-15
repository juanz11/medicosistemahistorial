<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Consulta;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function crearPaciente()
    {
        return view('pacientes.crear');
    }

    public function guardarPaciente(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:255|unique:pacientes,cedula',
            'edad' => 'required|integer|min:0|max:150',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $paciente = new Paciente($data);
        $paciente->user_id = Auth::id();
        $paciente->save();

        return redirect()
            ->route('pacientes.historial', $paciente->id)
            ->with('success', 'Paciente registrado correctamente.');
    }

    public function verPaciente($id)
    {
        $paciente = Paciente::with('user')->findOrFail($id);
        $consultas = $paciente->consulta()->with('user')->orderByDesc('fecha')->orderByDesc('id')->get();

        return view('pacientes.historial', compact('paciente', 'consultas'));
    }

    public function guardarConsulta(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validate([
            'fecha' => 'required|date',
            'diagnostico' => 'required|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'proxima_cita' => 'nullable|date',
        ]);

        $consulta = new Consulta($data);
        $consulta->paciente_id = $paciente->id;
        $consulta->user_id = Auth::id();
        $consulta->save();

        return redirect()
            ->route('pacientes.historial', $paciente->id)
            ->with('success', 'Diagnóstico registrado correctamente.');
    }

    public function verificarPacientes(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $pacientes = Paciente::with(['ultimaConsulta', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombres', 'like', '%' . $search . '%')
                        ->orWhere('apellidos', 'like', '%' . $search . '%')
                        ->orWhere('cedula', $search);
                });
            })
            ->paginate(7)
            ->appends(['search' => $search]);

        return view('pacientes.verificar', compact('pacientes', 'search'));
    }
}
