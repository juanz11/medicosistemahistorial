<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => ['jwt.auth']], function(){
    Route::resource('paciente', PacienteController::class);
    Route::resource('consulta', ConsultaController::class);

    Route::get('historial-consultas/{id}', "ConsultaController@indexHistorial");
    Route::get('generar-informe/{id}', "ConsultaController@generarInforme");

    Route::prefix('verificar')->group(function () {
        Route::get('paciente', "PacienteController@indexVerify");
    });

    Route::prefix('search')->group(function () {
        Route::post('paciente', "PacienteController@search");
        Route::post('paciente-verify', "PacienteController@searchVerify");
//         Route::get('{id}',"CalculosController@show");
    });
});
