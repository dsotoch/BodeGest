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
use App\Http\Controllers\ControllerWebhook;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::middleware("auth")->controller(ControllerWebhook::class)->prefix('Webhook')->group(function () {
    Route::get('verificate','CheckCancellationDate');
    Route::get('movimientos','datos_movimiento_cliente');
    Route::get('pagos','datos_pago_cliente');
    Route::get('cancel','cancelar_subscripcion')->name("cancelarSuscripcion");
    Route::get('resume','reanudar_subscripcion')->name("suscriptionResume");
    Route::get("renovacionexito","exitoRenovacion")->name("reanudarSuscripcion");
    Route::get("renovacionfallo/{token}","falloRenovacion")->name("reanudarSuscripcionFallida");



});

Route::get('/', [ControllerUsuario::class, 'login'])->name('login');
Route::middleware("auth")->controller(ControllerPagos::class)->prefix('Pagos')->group(function () {
    Route::post('CrearCargo', 'crear_cargo_plan_basico');
    Route::get('cancel', 'cancel')->name('errorbasico');
    Route::get('cancelw', 'cancelaw')->name('errorbasicowebhook');

    Route::get('success', 'success')->name('successbasico');
    Route::get('agregarTarjeta', 'asignarTarjeta');
});
Route::controller(ControllerUsuario::class)->prefix('Login')->group(function () {
    Route::get('Registrarse', 'crearUsuario');
    Route::get('confirmar-correo', 'EmailConfirmacion');
    Route::get('validarToken/{token}', 'validarToken')->name('validar-token');
    Route::get('IniciarSesion', 'IniciarSesion');
    Route::get('Logout', 'logout')->name('logout')->middleware("auth");
    Route::get('Empresa', 'empresa')->middleware("auth");
    Route::get('verEmpresa', 'verempresa')->middleware("auth");
    Route::get('Cuenta', 'cuenta')->name('micuenta')->middleware("auth");
    Route::post('ModificarCuenta', 'modificar_cuenta')->middleware("auth");
});
Route::middleware("auth")->controller(ControllerPrincipal::class)->prefix('Principal')->group(function () {
    Route::get('Dashboard', 'dashboard')->name("dashboard");
    Route::get('CompraVenta', 'compras_ventas');
    Route::get('VentasMayores', 'ventas_mayores');
});
Route::middleware("auth")->controller(ControllerHome::class)->prefix('Home')->group(function () {
    Route::get('Home', 'index')->name('home');
});
Route::middleware("auth")->controller(ControllerFinanzas::class)->prefix('Finanzas')->group(function () {
    Route::get('Finanzas', 'index')->name('finanzas');
    Route::get('Balance', 'balance');
    Route::post('SaveBalance', 'guardarbalance');
});
Route::middleware("auth")->controller(ControllerArticulos::class)->prefix('Articulos')->group(function () {
    Route::get('Index', 'index')->name('articulos');
    Route::get('Crear-Articulo', 'crear_articulo');
    Route::get('Eliminar-Todo', 'eliminar_todo');
    Route::get('Eliminar/{id}', 'eliminar');
    Route::get('BuscarArticulo/{id}', 'buscar_articulo');
    Route::get('ModificarArticulo/{id}', 'modificar_articulo');
});
Route::middleware("auth")->controller(ControllerProvedores::class)->prefix('Provedores')->group(function () {
    Route::get('Index', 'index')->name('provedores');
    Route::get('Detalle-Provedor/{id}', 'detalle_provedor');
    Route::get('Registrar-Provedor', 'registrar_provedor');

    Route::get('Modificar-Provedor/{id}', 'modificar_provedor');
    Route::get('Eliminar-Provedor/{id}', 'eliminar_provedor');
    Route::get('Generar-Codigo', 'generar_codigo');
});
Route::middleware("auth")->controller(ControllerCompras::class)->prefix('Compras')->group(function () {
    Route::get('Index', 'index')->name('compras');
    Route::get('GenerarCodigoCompra', 'codigo');
    Route::get('Proveedores', 'proveedores');
    Route::get('Productos', 'productos');
    Route::post('CrearCompra', 'create')->name('crearCompra');
    Route::get('FinalizarCompra/{id}', 'finalizar')->name('finalizar');
    Route::get('DetalleCompras', 'detallecompras')->name('detallecompras');
    Route::get('Detalles', 'detalle_compra');
});
Route::middleware("auth")->controller(ControllerVentas::class)->prefix('Ventas')->group(function () {
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

Route::middleware("auth")->controller(ControllerClientes::class)->prefix('Clientes')->group(function () {
    Route::get('Crear', 'store')->name('crea_cliente');
});
Route::middleware("auth")->controller(ControllerCuenta::class)->prefix('Cuentas')->group(function () {
    Route::get('Index', 'index')->name('cuentas');
    Route::get('Show/{id}', 'show');
    Route::post('EnviarEmail', 'email')->name('enviar_estado_de_cuenta');
    Route::get('CancelarDeuda/{dni}', 'cancelar_deuda');
    Route::get('GuardarRestante', 'guardar_restante');
    Route::get('CancelarSaldo/{dni}', 'cancelar_saldo');
});
Route::middleware("auth")->controller(ControllerAdministracion::class)->prefix('Administracion')->group(function () {
    Route::get('Index', 'index')->name('administracion');
    Route::get('Datos', 'datos');
    Route::get('ingresos_vs_egresos', 'ingresos_vs_egresos');
    Route::get('VentasSemestral', 'ventas_6_meses');
});
