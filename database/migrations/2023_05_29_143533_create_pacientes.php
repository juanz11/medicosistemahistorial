<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nacimiento_fecha');
            $table->integer('sexo');
            $table->string('nacimiento_lugar');
            $table->integer('nacionalidad');
            $table->string('cedula')->unique('ci');
            $table->integer('edad');
            $table->string('telefono');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('direccion');
            $table->string('familiar_nombre');
            $table->string('familiar_parentesco');
            $table->string('familiar_telefono');
            $table->string('familiar_direccion');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}

// php artisan migrate --path=/database/migrations/2023_05_29_143533_create_pacientes.php