<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // [user_id, nombres, apellidos, cedula, edad, fecha_ultima_consulta]
        $pacientes = [
            [1, 'Andry', 'Pérez', '28036233', 29, '2023-08-02'],
            [4, 'Ilse Marlene', 'Bolivar Landaeta', '3581789', 64, null],
            [4, 'Mileny', 'Andueza Hernandez', '28022620', 30, null],
            [3, 'JOSÉ', 'AVANCINES', '1', 50, '2023-12-08'],
            [1, 'Ruth Clarisa', 'Hernandez Zerpa', '14874463', 45, '2024-09-03'],
            [3, 'MERY', 'DA PONTE', '6087563', 60, '2023-08-14'],
            [1, 'Maritza Gregoria', 'Rios Laya', '5982018', 61, '2023-08-14'],
            [1, 'Luis Alberto', 'García Torres', '10234567', 38, '2024-01-15'],
            [3, 'Carmen Elena', 'Rojas Paredes', '8765432', 52, null],
            [4, 'José Gregorio', 'Martínez Silva', '12345678', 41, '2024-02-20'],
            [1, 'Ana María', 'Castillo Flores', '15456789', 33, '2024-03-10'],
            [3, 'Pedro Pablo', 'Sánchez León', '19876543', 27, null],
            [4, 'Luisa Fernanda', 'Morales Díaz', '21345678', 24, '2024-05-05'],
            [1, 'Carlos Eduardo', 'Vargas Ruiz', '6543210', 58, '2024-06-12'],
            [3, 'María José', 'Fernández Gil', '17654321', 36, null],
            [4, 'Ricardo', 'González Pérez', '14567890', 44, '2024-07-01'],
        ];

        foreach ($pacientes as $p) {
            $pacienteId = DB::table('pacientes')->insertGetId([
                'user_id' => $p[0],
                'nombres' => $p[1],
                'apellidos' => $p[2],
                'nacimiento_fecha' => '1990-01-01',
                'sexo' => 1,
                'nacimiento_lugar' => 'Valencia',
                'nacionalidad' => 1,
                'cedula' => $p[3],
                'edad' => $p[4],
                'telefono' => '04140000000',
                'ciudad' => 'Valencia',
                'estado' => 'Carabobo',
                'direccion' => 'Valencia, Edo. Carabobo',
                'familiar_nombre' => 'Familiar',
                'familiar_parentesco' => 'Familiar',
                'familiar_telefono' => '04140000000',
                'familiar_direccion' => 'Valencia, Edo. Carabobo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($p[5]) {
                DB::table('consultas')->insert([
                    'user_id' => $p[0],
                    'paciente_id' => $pacienteId,
                    'fecha' => $p[5],
                    'motivo' => 'Consulta de control',
                    'enfermedad' => 'N/A',
                    'antecedentes' => 'N/A',
                    'neuro' => 'N/A',
                    'diagnostico' => 'N/A',
                    'tratamiento' => 'N/A',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
