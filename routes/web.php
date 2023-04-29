<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerArticulos;
use App\Http\Controllers\ControllerCompras;
use App\Http\Controllers\ControllerPrincipal;
use App\Http\Controllers\ControllerProvedores;
use App\Http\Controllers\ControllerUsuario;
use App\Http\Controllers\ControllerVentas;
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
    Route::get('Eliminar/{id}', 'eliminar');
    Route::get('BuscarArticulo/{id}','buscar_articulo');
    Route::get('ModificarArticulo/{id}','modificar_articulo');


});
Route::controller(ControllerProvedores::class)->prefix('Provedores')->group(function () {
    Route::get('Index', 'index')->name('provedores');
    Route::get('Detalle-Provedor/{id}', 'detalle_provedor');
    Route::get('Registrar-Provedor', 'registrar_provedor');

    Route::get('Modificar-Provedor/{id}', 'modificar_provedor');
    Route::get('Eliminar-Provedor/{id}', 'eliminar_provedor');
    Route::get('Generar-Codigo','generar_codigo');


});
Route::controller(ControllerCompras::class)->prefix('Compras')->group(function(){
    Route::get('Index','index')->name('compras');
    Route::get('GenerarCodigoCompra','codigo');
    Route::get('Proveedores','proveedores');
    Route::get('Productos','productos');
    Route::get('CrearCompra','create')->name('crearCompra');
    Route::get('FinalizarCompra/{id}','finalizar')->name('finalizar');
});
Route::controller(ControllerVentas::class)->prefix('Ventas')->group(function(){
    Route::get('Index','index')->name('ventas');
    Route::get('GenerarCodigoCompra','codigo');
    Route::get('Proveedores','proveedores');
    Route::get('Productos','productos');
    Route::get('CrearCompra','create')->name('crearCompra');
    Route::get('FinalizarCompra/{id}','finalizar')->name('finalizar');
});