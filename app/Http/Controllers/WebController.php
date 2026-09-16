<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
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
