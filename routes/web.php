<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\FacturaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (USUARIO AUTENTICADO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL (REDIRECCIONA SEGÚN ROL)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | MENÚ (CLIENTE Y ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu');
        Route::get('/{id}', [MenuController::class, 'show'])->name('menu.show');
        Route::post('/procesar-pedido', [MenuController::class, 'procesarPedido'])
            ->name('menu.procesar-pedido');
    });

    /*
    |--------------------------------------------------------------------------
    | PEDIDOS (CLIENTE)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('pedidos');
        Route::post('/', [PedidoController::class, 'store'])->name('pedidos.store');
        Route::get('/historial', [PedidoController::class, 'historial'])
            ->name('pedidos.historial');
    });

    /*
    |--------------------------------------------------------------------------
    | RESERVAS (CLIENTE)
    |--------------------------------------------------------------------------
    */
    Route::prefix('reservas')->group(function () {
        Route::get('/', [ReservaController::class, 'index'])->name('reservas');
        Route::post('/', [ReservaController::class, 'store'])->name('reservas.store');
        Route::get('/historial', [ReservaController::class, 'historial'])
            ->name('reservas.historial');
    });

    /*
    |--------------------------------------------------------------------------
    | FACTURAS (CLIENTE)
    |--------------------------------------------------------------------------
    */
    Route::prefix('facturas')->group(function () {
        Route::get('/', [FacturaController::class, 'index'])->name('facturas');
        Route::get('/historial', [FacturaController::class, 'historial'])
            ->name('facturas.historial');
        Route::get('/generar-prueba', [FacturaController::class, 'generarPrueba'])
            ->name('facturas.generar-prueba');

        Route::get('/{id}/detalles', [FacturaController::class, 'mostrarDetalles'])
            ->name('facturas.detalles');
        Route::get('/{id}/descargar', [FacturaController::class, 'descargarPDF'])
            ->name('facturas.descargar');
        Route::post('/{id}/pagar', [FacturaController::class, 'pagar'])
            ->name('facturas.pagar');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRACIÓN (SOLO ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // CLIENTES
        Route::prefix('clientes')->group(function () {
            Route::get('/', [AdminController::class, 'clientes'])
                ->name('admin.clientes');
            Route::post('/crear', [AdminController::class, 'crearCliente'])
                ->name('admin.crear-cliente');
            Route::get('/{id}', [AdminController::class, 'verCliente'])
                ->name('admin.ver-cliente');
            Route::post('/{id}/actualizar', [AdminController::class, 'actualizarCliente'])
                ->name('admin.actualizar-cliente');
            Route::delete('/{id}', [AdminController::class, 'eliminarCliente'])
                ->name('admin.eliminar-cliente');
        });

        // ADMIN VE TODO
        Route::get('/pedidos', [AdminController::class, 'pedidos'])
            ->name('admin.pedidos');
        Route::get('/reservas', [AdminController::class, 'reservas'])
            ->name('admin.reservas');
        Route::get('/facturas', [AdminController::class, 'facturas'])
            ->name('admin.facturas');
        Route::get('/reportes', [AdminController::class, 'reportes'])
            ->name('admin.reportes');
    });

    /*
    |--------------------------------------------------------------------------
    | API INTERNA (AJAX)
    |--------------------------------------------------------------------------
    */
    Route::get('/api/facturas/{id}', [FacturaController::class, 'getDetalles'])
        ->name('api.facturas.detalles');

    Route::get('/api/clientes/{id}', [AdminController::class, 'getClienteInfo'])
        ->name('api.clientes.detalles');
});
