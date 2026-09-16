<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'admin' => '0',
            'tipo' => '1',
            'nombres' => 'Celen S.',
            'apellidos' => 'Zerouni M.',
            'especialidad' => 'Médico Psiquiatra',
            'mpps' => '54933',
            'cm' => '6653',
            'cedula' => '7.079.411',
            'rif' => 'V-07079411-3',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 2, consultorio 2-07, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 824 2649',
            'movil' => '(0424) 414 1566',
            'rrss' => null,
            'email' => 'czerouni@sncpharma.com',
            'password' => Hash::make('7079411'),
        ],
        [
            'admin' => '0',
            'tipo' => '1',
            'nombres' => 'María R.',
            'apellidos' => 'Rodriguez',
            'especialidad' => 'Médico Psiquiatra',
            'mpps' => '54932',
            'cm' => '6654',
            'cedula' => '7.087.764',
            'rif' => 'V-07087764-0',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 3, consultorio 3-01, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 826 8097',
            'movil' => '(0414) 419 3476',
            'rrss' => null,
            'email' => 'mraquelrodriguez18@gmail.com',
            'password' => Hash::make('7087764'),
        ],
        [
            'admin' => '0',
            'tipo' => '1',
            'nombres' => 'Adriana',
            'apellidos' => 'Mijares',
            'especialidad' => 'Médico Psiquiatra',
            'mpps' => '116602',
            'cm' => '12690',
            'cedula' => '20.512.867',
            'rif' => 'V-20512867-7',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 3, consultorio 3-01, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 826 8097',
            'movil' => '(0424) 423 3191',
            'rrss' => null,
            'email' => 'adrianapatriciamaestre@gmail.com',
            'password' => Hash::make('20512867'),
        ],
        [
            'admin' => '0',
            'tipo' => '0',
            'nombres' => 'William',
            'apellidos' => 'Moreno',
            'especialidad' => 'Médico Psiquiatra',
            'mpps' => '43245',
            'cm' => '6843',
            'cedula' => '6.867.198',
            'rif' => 'V-06867198-8',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 3, consultorio 3-01, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 826 8097',
            'movil' => '(0414) 940 6075',
            'rrss' => null,
            'email' => 'willmor1307@gmail.com',
            'password' => Hash::make('6867198'),
        ],
        [
            'admin' => '0',
            'tipo' => '0',
            'nombres' => 'Ulises A.',
            'apellidos' => 'Leal H.',
            'especialidad' => 'Médico Internista',
            'mpps' => '56237',
            'cm' => '6891',
            'cedula' => '11.347.804',
            'rif' => 'V-11347804-3',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 3, consultorio 3-01, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 826 8097',
            'movil' => '(0412) 741 8703',
            'rrss' => null,
            'email' => 'ulilealh@gmail.com',
            'password' => Hash::make('11347804'),
        ],
        [
            'admin' => '1',
            'tipo' => '0',
            'nombres' => 'Maryflor',
            'apellidos' => 'Wiedemann.',
            'especialidad' => 'Secretaria',
            'mpps' => '999999',
            'cm' => '999999',
            'cedula' => '9.999.999',
            'rif' => 'V-99999999-9',
            'direccion' => 'Urb. Prebo, Av. Andrés Eloy Blanco, C.P. Prebo, piso 3, consultorio 3-01, Valencia, Edo. Carabobo.',
            'fijo' => '(0241) 824 2649',
            'movil' => '(0000) 000 0000',
            'email' => 'mwiedemann@sncpharma.com',
            'password' => Hash::make('mw2023snc'),
        ]);
    }
}
