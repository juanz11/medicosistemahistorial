<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaUltimaConsulta extends Model
{
    use HasFactory;

    protected $table = 'vista_ultima_consulta';

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
