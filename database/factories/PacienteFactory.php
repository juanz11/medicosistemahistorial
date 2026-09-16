<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;
// use Faker\Factory as Faker;

// $faker = Faker::create();

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'nombres' => $this->faker->name,
            'apellidos' => $this->faker->name,
            'nacimiento_fecha' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'sexo' => 1,
            'nacimiento_lugar' => 'Valencia',
            'nacionalidad' => 1,
            'cedula' => '28036233',
            'edad' => 20,
            'telefono' => '04144855786',
            'ciudad' => 'Valencia',
            'estado' => 'Carabobo',
            'direccion' => 'Prueba',
            'familiar_nombre' => $this->faker->name,
            'familiar_parentesco' => 'prueba',
            'familiar_telefono' => '04144855786',
            'familiar_direccion' => 'prueba',

        ];
    }
}
