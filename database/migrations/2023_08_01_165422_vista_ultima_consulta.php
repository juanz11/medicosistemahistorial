<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class VistaUltimaConsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView(){
        return <<<SQL
        CREATE VIEW `vista_ultima_consulta`  AS
        SELECT `p`.`id` AS `paciente_id`, `p`.`cedula` AS `cedula_paciente`, `c`.`fecha` AS `fecha_consulta` FROM (`pacientes` `p` left join `consultas` `c` on((`p`.`id` = `c`.`paciente_id`))) WHERE (`c`.`fecha` = (select max(`consultas`.`fecha`) from `consultas` where (`consultas`.`paciente_id` = `p`.`id`))) ;
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `vista_ultima_consulta`;
            SQL;
    }
}
