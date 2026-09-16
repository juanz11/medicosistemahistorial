<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('paciente_id');
            $table->string('fecha');
            $table->string('motivo');
            $table->string('enfermedad');
            $table->string('antecedentes');
            $table->string('neuro');
            $table->string('neuro_superior')->nullable()->default(null);
            $table->string('neuro_pares')->nullable()->default(null);
            $table->string('neuro_sistema')->nullable()->default(null);
            $table->string('neuro_sensibilidad')->nullable()->default(null);
            $table->string('neuro_taxia')->nullable()->default(null);
            $table->string('neuro_praxia')->nullable()->default(null);
            $table->string('laboratorio_basico')->nullable()->default(null);
            $table->string('laboratorio_complementario')->nullable()->default(null);
            $table->string('diagnostico');
            $table->string('tratamiento');
            $table->string('observaciones')->nullable()->default(null);
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
        Schema::dropIfExists('consultas');
    }
}
// php artisan migrate --path=/database/migrations/2023_06_08_123409_create_consultas.php