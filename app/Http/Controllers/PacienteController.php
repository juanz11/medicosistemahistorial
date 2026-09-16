<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PacienteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $pacientes = Paciente::with('ultimaConsulta')->whereHas('user', function($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->paginate(7);

        if ($pacientes->isEmpty()) {
            return response()->json(['message' => 'No existen registros.'], 404);
        }
        
        return $pacientes;

    }

    public function indexVerify()
    {
        $pacientes = Paciente::with('ultimaConsulta')->paginate(7);

        if ($pacientes->isEmpty()) {
            return response()->json(['message' => 'No existen registros.'], 404);
        }
        
        return $pacientes;

    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'formPaciente.nombres' => 'required',
            'formPaciente.apellidos' => 'required',
            'formPaciente.nacimiento_fecha' => 'required',
            'formPaciente.sexo' => 'required',
            'formPaciente.nacimiento_lugar' => 'required',
            'formPaciente.nacionalidad' => 'required',
            'formPaciente.cedula' => ['required', Rule::unique('pacientes', 'cedula')],
            'formPaciente.edad' => 'required',
            'formPaciente.telefono' => 'required',
            'formPaciente.ciudad' => 'required',
            'formPaciente.estado' => 'required',
            'formPaciente.direccion' => 'required',
            'formPaciente.familiar_nombre' => 'required',
            'formPaciente.familiar_parentesco' => 'required',
            'formPaciente.familiar_telefono' => 'required',
            'formPaciente.familiar_direccion' => 'required',
        ]);

        $paciente = new Paciente($request->formPaciente);
        $paciente->user_id = $user->id;

        try {
            $paciente->save();
            return response()->json(['message' => 'Paciente registrado correctamente'], 200);
        } catch (ValidationException $exception) {
            $errors = $exception->validator->errors()->getMessages();
            return response()->json(['message' => $errors], 200);
        }
    }

    public function show($id)
    {
        $paciente = Paciente::find($id);

        if ($paciente) {
            return response()->json($paciente, 200);
        } else {
            return response()->json(['message' => 'No existe este paciente.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);
        $paciente->update($request->formPaciente);
        
        if ($paciente) {
            return response()->json(['message' => 'Paciente editado correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se pudo editar este paciente.'], 500);
        }
    
    }

    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        $paciente->delete();
        if ($paciente) {
            return response()->json(['message' => 'Paciente eliminado correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se pudo eliminar este paciente.'], 500);
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $user_id = Auth::id();

        $results = Paciente::where('user_id', $user_id)
        ->where(function ($query) use ($searchTerm) {
            $query->where('nombres', 'like', '%'.$searchTerm.'%')
                ->orWhere('apellidos', 'like', '%'.$searchTerm.'%')
                ->orWhere('cedula', $searchTerm);
        })
        ->paginate(7);

            if ($results->isEmpty()) {
                return response()->json(['message' => 'No existe este paciente.'], 404);
            }

        return response()->json($results);
    }

    public function searchVerify(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $results = Paciente::where(function ($query) use ($searchTerm) {
            $query->where('nombres', 'like', '%'.$searchTerm.'%')
                ->orWhere('apellidos', 'like', '%'.$searchTerm.'%')
                ->orWhere('cedula', $searchTerm);
        })
        ->paginate(7);

            if ($results->isEmpty()) {
                return response()->json(['message' => 'No existe este paciente.'], 404);
            }

        return response()->json($results);
    }
}
