<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;
use App\PDF\PDFGenerator;

class ConsultaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $consultas = Consulta::with('paciente')->whereHas('user', function($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->paginate(7);

        if ($consultas->isEmpty()) {
            return response()->json(['message' => 'No existen registros.'], 404);
        }
        
        return $consultas;
    }

    public function store(Request $request)
    {
        $user = \Auth::user();

        $request->validate([
            'formConsulta.paciente_id' => 'required',
            'formConsulta.fecha' => 'required',
            'formConsulta.motivo' => 'required',
            'formConsulta.enfermedad' => 'required',
            'formConsulta.antecedentes' => 'required',
            'formConsulta.neuro' => 'required',
            'formConsulta.diagnostico' => 'required',
            'formConsulta.tratamiento' => 'required',
        ]);

        $consulta = new Consulta($request->formConsulta);
        $consulta->user_id = $user->id;
        $consulta->save();

        // Retornar una respuesta JSON
        if ($consulta) {
            return response()->json(['message' => 'Consulta registrada correctamente'], 201);
        } else {
            return response()->json(['message' => 'Error al registrar. Por favor, inténtalo nuevamente'], 500);
        }
    }

    public function show($id)
    {
        $consulta = Consulta::find($id);

        if ($consulta) {
            return response()->json($consulta, 200);
        } else {
            return response()->json(['message' => 'No existe esta consulta.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $consulta = Consulta::find($id);
        $consulta->update($request->formConsulta);
        
        if ($consulta) {
            return response()->json(['message' => 'Consulta editada correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se pudo editar esta consulta.'], 500);
        }
    }

    public function destroy($id)
    {
        $consulta = Consulta::find($id);
        $consulta->delete();
        if ($consulta) {
            return response()->json(['message' => 'Consulta eliminada correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se pudo eliminar esta consulta.'], 500);
        }
    }

    public function indexHistorial($paciente_id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $consultas = Consulta::with('paciente')->whereHas('user', function($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->where('paciente_id', $paciente_id)->get();

        if ($consultas->isEmpty()) {
            return response()->json(['message' => 'No se encuentran registros.'], 404);
        }
        
        return $consultas;
    }

    public function generarInforme($id)
    {
        $consulta = Consulta::with('paciente', 'user')->find($id);

        if (!$consulta) {
            return response()->json(['message' => 'No existe esta consulta.'], 404);
        }
        
        return response()->json($consulta, 200);
    }
}
