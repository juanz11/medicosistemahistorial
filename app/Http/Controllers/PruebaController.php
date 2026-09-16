<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;

class PruebaController extends Controller
{
    public function crearPaciente(){
        $pacientes = Paciente::factory()->count(10)->create();
        return response()->json(['message' => 'Pacientes Creados.'], 200);
    }
}
