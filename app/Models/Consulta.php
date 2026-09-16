<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'user_id',
        'paciente_id',
        'fecha',
        'motivo',
        'enfermedad',
        'antecedentes',
        'neuro',
        'neuro_superior',
        'neuro_pares',
        'neuro_sistema',
        'neuro_sensibilidad',
        'neuro_taxia',
        'neuro_praxia',
        'laboratorio_basico',
        'laboratorio_complementario',
        'diagnostico',
        'tratamiento',
        'observaciones',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
