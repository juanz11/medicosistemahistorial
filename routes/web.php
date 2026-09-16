<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::get('/salir', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth:web')->group(function () {
    Route::get('/', [WebController::class, 'home'])->name('home');
    Route::get('/lists/verificar-pacientes', [WebController::class, 'verificarPacientes'])->name('pacientes.verificar');
});
