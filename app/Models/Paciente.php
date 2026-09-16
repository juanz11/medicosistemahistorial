<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    
    protected $table = 'pacientes';

    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'nacimiento_fecha',
        'sexo',
        'nacimiento_lugar',
        'nacionalidad',
        'cedula',
        'edad',
        'telefono',
        'ciudad',
        'estado',
        'direccion',
        'familiar_nombre',
        'familiar_parentesco',
        'familiar_telefono',
        'familiar_direccion',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function consulta(){
        return $this->hasMany(Consulta::class);
    }
    public function ultimaConsulta(){
        return $this->hasMany(VistaUltimaConsulta::class);
    }
}
