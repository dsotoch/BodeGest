<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerArticulos;
use App\Http\Controllers\ControllerPrincipal;
use App\Http\Controllers\ControllerUsuario;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('login');

Route::controller(ControllerUsuario::class)->prefix('Login')->group(function () {
    Route::get('Registrarse', 'crearUsuario');
    Route::get('confirmar-correo', 'EmailConfirmacion');
    Route::get('validarToken/{token}', 'validarToken')->name('validar-token');
    Route::get('IniciarSesion', 'IniciarSesion');
});
Route::controller(ControllerPrincipal::class)->prefix('Principal')->group(function () {
    Route::get('Dashboard', 'dashboard');
});
Route::controller(ControllerArticulos::class)->prefix('Articulos')->group(function () {
    Route::get('Index', 'index')->name('articulos');
    Route::get('Crear-Articulo', 'crear_articulo');
    Route::get('Eliminar-Todo', 'eliminar_todo');

});
