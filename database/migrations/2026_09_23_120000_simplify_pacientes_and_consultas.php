<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SimplifyPacientesAndConsultas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `pacientes`
            MODIFY `nacimiento_fecha` VARCHAR(255) NULL,
            MODIFY `sexo` INT NULL,
            MODIFY `nacimiento_lugar` VARCHAR(255) NULL,
            MODIFY `nacionalidad` INT NULL,
            MODIFY `ciudad` VARCHAR(255) NULL,
            MODIFY `estado` VARCHAR(255) NULL,
            MODIFY `familiar_nombre` VARCHAR(255) NULL,
            MODIFY `familiar_parentesco` VARCHAR(255) NULL,
            MODIFY `familiar_telefono` VARCHAR(255) NULL,
            MODIFY `familiar_direccion` VARCHAR(255) NULL");

        Schema::table('consultas', function (Blueprint $table) {
            $table->string('proxima_cita')->nullable()->default(null)->after('observaciones');
        });

        DB::statement("ALTER TABLE `consultas`
            MODIFY `motivo` TEXT NULL,
            MODIFY `enfermedad` TEXT NULL,
            MODIFY `antecedentes` TEXT NULL,
            MODIFY `neuro` TEXT NULL,
            MODIFY `diagnostico` TEXT NOT NULL,
            MODIFY `tratamiento` TEXT NULL,
            MODIFY `observaciones` TEXT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('proxima_cita');
        });
    }
}
