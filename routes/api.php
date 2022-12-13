<?php

use App\Http\Controllers\AdafruitController;
use App\Http\Controllers\FunctionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("/adafruit")->group(function()
{
    Route::get("/datos/humedad",[AdafruitController::class,"humedad"]);
    Route::get("/datos/luz",[AdafruitController::class,"luz"]);
    Route::get("/datos/corrientemax",[AdafruitController::class,"corientemax"]);
    Route::get("/datos/corrientemin",[AdafruitController::class,"corientemin"]);
    Route::get("/datos/corrientewatts",[AdafruitController::class,"corientewatts"]);
    Route::get("/datos/temperatura",[AdafruitController::class,"temperatura"]);
    Route::get("/datos/magnetico",[AdafruitController::class,"magnetico"]);
    Route::get("/datos/pir",[AdafruitController::class,"pir"]);
    Route::get("/datos/gas",[AdafruitController::class,"gas"]);
    Route::post("/crear/salones",[AdafruitController::class,"crearsalones"]);
});

Route::prefix("/login")->group(function()
{
    Route::post("/make/usuario",[LoginController::class,"registrar"]);
    Route::post("/make/login",[LoginController::class,"createlogin"]);
    Route::middleware('auth:sanctum')->post("/make/logout",[LoginController::class,"logout"]);
    Route::post("/crear/feed",[AdafruitController::class,"crearsalones"]);
    Route::post("/verificar/usuariosms",[LoginController::class,"verificarSms"]);
});

Route::prefix("/function1")->group(function()
{
    Route::post("/crear/salon",[FunctionController::class,"registrarsalon"]);
});

Route::prefix("/function2")->group(function()
{
    Route::put("/modificar/usuario/{id}",[FunctionController::class,"modificarusuario"])->where('id',"[1-9]+");
    Route::put("/modificar/salon/{id}",[FunctionController::class,"modificarsalon"])->where('id',"[1-9]+");
});

Route::prefix("/function3")->group(function()
{
    Route::get("/consultar/usuario",[FunctionController::class,"consultarusuario"]);
    Route::get("/consultar/sensor",[FunctionController::class,"consultarsensor"]);
    Route::get("/consultar/salon",[FunctionController::class,"consultarsalon"]);
    Route::get("/consultar/usuariosalon/{id}",[FunctionController::class,"consultarsalonid"])->where('id',"[1-9]+");
});

Route::prefix("/function4")->group(function()
{
    Route::put("/eliminar/usuario/{id}",[FunctionController::class,"eliminarusuario"])->where('id',"[1-9]+");
    Route::put("/eliminar/sensor/{id}",[FunctionController::class,"eliminarsensor"])->where('id',"[1-9]+");
    Route::put("/eliminar/salon/{id}",[FunctionController::class,"eliminarsalon"])->where('id',"[1-9]+");
});