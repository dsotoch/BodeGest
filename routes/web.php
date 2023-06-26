<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerAdministracion;
use App\Http\Controllers\ControllerArticulos;
use App\Http\Controllers\ControllerClientes;
use App\Http\Controllers\ControllerCompras;
use App\Http\Controllers\ControllerCuenta;
use App\Http\Controllers\ControllerFinanzas;
use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerPagos;
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

Route::get('/', [ControllerUsuario::class, 'login'])->name('login');
Route::controller(ControllerPagos::class)->prefix('Pagos')->group(function () {

    Route::post('CrearCargo', 'crear_cargo_plan_basico');
    Route::get('cancel', 'cancel')->name('errorbasico');
    Route::get('success', 'success')->name('successbasico');
    Route::get('agregarTarjeta', 'asignarTarjeta');
});
Route::controller(ControllerUsuario::class)->prefix('Login')->group(function () {


    Route::get('Registrarse', 'crearUsuario');
    Route::get('confirmar-correo', 'EmailConfirmacion');
    Route::get('validarToken/{token}', 'validarToken')->name('validar-token');
    Route::get('IniciarSesion', 'IniciarSesion');
    Route::get('Logout', 'logout')->name('logout');
    Route::get('Empresa', 'empresa');
    Route::get('verEmpresa', 'verempresa');
    Route::get('Cuenta', 'cuenta')->name('micuenta');
    Route::post('ModificarCuenta', 'modificar_cuenta');
});
Route::controller(ControllerPrincipal::class)->prefix('Principal')->group(function () {
    Route::get('Dashboard', 'dashboard')->name("dashboard");
    Route::get('CompraVenta', 'compras_ventas');
    Route::get('VentasMayores', 'ventas_mayores');
});
Route::controller(ControllerHome::class)->prefix('Home')->group(function () {
    Route::get('Home', 'index')->name('home');
});
Route::controller(ControllerFinanzas::class)->prefix('Finanzas')->group(function () {
    Route::get('Finanzas', 'index')->name('finanzas');
    Route::get('Balance', 'balance');
    Route::post('SaveBalance', 'guardarbalance');
});
Route::controller(ControllerArticulos::class)->prefix('Articulos')->group(function () {
    Route::get('Index', 'index')->name('articulos');
    Route::get('Crear-Articulo', 'crear_articulo');
    Route::get('Eliminar-Todo', 'eliminar_todo');
    Route::get('Eliminar/{id}', 'eliminar');
    Route::get('BuscarArticulo/{id}', 'buscar_articulo');
    Route::get('ModificarArticulo/{id}', 'modificar_articulo');
});
Route::controller(ControllerProvedores::class)->prefix('Provedores')->group(function () {
    Route::get('Index', 'index')->name('provedores');
    Route::get('Detalle-Provedor/{id}', 'detalle_provedor');
    Route::get('Registrar-Provedor', 'registrar_provedor');

    Route::get('Modificar-Provedor/{id}', 'modificar_provedor');
    Route::get('Eliminar-Provedor/{id}', 'eliminar_provedor');
    Route::get('Generar-Codigo', 'generar_codigo');
});
Route::controller(ControllerCompras::class)->prefix('Compras')->group(function () {
    Route::get('Index', 'index')->name('compras');
    Route::get('GenerarCodigoCompra', 'codigo');
    Route::get('Proveedores', 'proveedores');
    Route::get('Productos', 'productos');
    Route::post('CrearCompra', 'create')->name('crearCompra');
    Route::get('FinalizarCompra/{id}', 'finalizar')->name('finalizar');
    Route::get('DetalleCompras', 'detallecompras')->name('detallecompras');
    Route::get('Detalles', 'detalle_compra');
});
Route::controller(ControllerVentas::class)->prefix('Ventas')->group(function () {
    Route::get('Index', 'index')->name('ventas');
    Route::get('GenerarCodigoCompra', 'codigo');
    Route::get('Proveedores', 'proveedores');
    Route::get('Productos', 'productos');
    Route::post('CrearVenta', 'store')->name('crearVenta');
    Route::get('Numero', 'numero_venta');
    Route::get('Detalle/{id}', 'detalle')->name('detalleVenta');
    Route::get('generarPDF', 'generar_pdf');
    Route::post('Comprobante', 'enviar_comprobante');
    Route::post('Print', 'imprimir');
    Route::get('DetalleVentas', 'detalleventas')->name('detalleventas');
    Route::get('Detalles', 'detalle_venta');
});

Route::controller(ControllerClientes::class)->prefix('Clientes')->group(function () {
    Route::get('Crear', 'store')->name('crea_cliente');
});
Route::controller(ControllerCuenta::class)->prefix('Cuentas')->group(function () {
    Route::get('Index', 'index')->name('cuentas');
    Route::get('Show/{id}', 'show');
    Route::post('EnviarEmail', 'email')->name('enviar_estado_de_cuenta');
    Route::get('CancelarDeuda/{dni}', 'cancelar_deuda');
    Route::get('GuardarRestante', 'guardar_restante');
    Route::get('CancelarSaldo/{dni}', 'cancelar_saldo');
});
Route::controller(ControllerAdministracion::class)->prefix('Administracion')->group(function () {
    Route::get('Index', 'index')->name('administracion');
    Route::get('Datos', 'datos');
    Route::get('ingresos_vs_egresos', 'ingresos_vs_egresos');
    Route::get('VentasSemestral', 'ventas_6_meses');
});
