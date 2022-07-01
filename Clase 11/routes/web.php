<?php

use Illuminate\Support\Facades\Route;

//AGREGO MIS CONTROLADORES PARA PODER ENLAZAR LAS VISTAS.
use App\Http\controllers\EmpleadoController;

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

Route::get('/', function () {
    //return view('welcome');// se cambia para que muestre el login como inicio
    return view('auth.login');
});
/*
Route::get('/empleado', function() {
    return view('empleado.index');
});
Route::get('/empleado',[EmpleadoController::class, 'index']);
*/
//PARA ACCEDER A TODOS LOS METODOS DE UN CONTROLADOR
Route::resource('empleado', EmpleadoController::class)->middleware('auth');//se agrega ->middleware('auth');

//AGREGO MÉTODO PARA PODER BORRAR
Route::get('/empleado/borrar/{id}', [EmpleadoController::class, 'borrar'])->name('empleado.borrar');

//AGREGO USE PARA LA AUTENTICACION
use Illuminate\Support\Facades\Auth;

Auth::routes();
//si se quieren quitar opciones del login: 
//Auth::routes(['register'=>false,'reset'=>false]);

//CAMBIAR EL HOME
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [EmpleadoController::class, 'index'])->name('home')->middleware('auth');//se agrega ->middleware('auth')

//AGREGO GRUPO DE RUTAS
Route::group(["middleware" => "auth"], function () {
    
    //REDIRECCIONO AL LISTADO
    Route::get('/home', [EmpleadoController::class, 'index'])->name('home')->middleware('auth');//se agrega ->middleware('auth')
});
