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

// ==================== RUTAS PÚBLICAS ====================
Route::get('/', function () {
    return view('auth.login');
});

// ==================== AUTENTICACIÓN ====================
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==================== RUTAS DE PRUEBA ====================
Route::get('/admin-test', [AdminController::class, 'index']);
Route::get('/test-facturas', [FacturaController::class, 'index']);
Route::get('/facturas-test', [FacturaController::class, 'index']);

// ==================== RUTAS PROTEGIDAS (AUTENTICACIÓN REQUERIDA) ====================
Route::middleware(['auth'])->group(function () {
    
    // ========== DASHBOARD PRINCIPAL ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ========== MENÚ ==========
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu');
        Route::get('/{id}', [MenuController::class, 'show'])->name('menu.show');
        Route::post('/procesar-pedido', [MenuController::class, 'procesarPedido'])->name('menu.procesar-pedido');
    });
    
    // ========== PEDIDOS ==========
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('pedidos');
        Route::post('/', [PedidoController::class, 'store'])->name('pedidos.store');
        Route::get('/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');
    });
    
    // ========== RESERVAS ==========
    Route::prefix('reservas')->group(function () {
        Route::get('/', [ReservaController::class, 'index'])->name('reservas');
        Route::post('/', [ReservaController::class, 'store'])->name('reservas.store');
        Route::get('/historial', [ReservaController::class, 'historial'])->name('reservas.historial');
    });
    
    // ========== FACTURACIÓN ==========
    Route::prefix('facturas')->group(function () {
        // Rutas fijas (sin parámetros) - PRIMERO
        Route::get('/', [FacturaController::class, 'index'])->name('facturas');
        Route::get('/historial', [FacturaController::class, 'historial'])->name('facturas.historial');
        Route::get('/generar-prueba', [FacturaController::class, 'generarPrueba'])->name('facturas.generar-prueba');
        
        // Rutas con parámetros {id} - DESPUÉS
        Route::get('/{id}/detalles', [FacturaController::class, 'mostrarDetalles'])->name('facturas.detalles');
        Route::get('/{id}/descargar', [FacturaController::class, 'descargarPDF'])->name('facturas.descargar');
        Route::post('/{id}/pagar', [FacturaController::class, 'pagar'])->name('facturas.pagar');
        Route::get('/{id}/get-detalles', [FacturaController::class, 'getDetalles'])->name('facturas.get-detalles');
    });
    
    // ========== ADMINISTRACIÓN ==========
    Route::prefix('admin')->group(function () {
        // Dashboard y gestión principal
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gestión de clientes
        Route::prefix('clientes')->group(function () {
            Route::get('/', [AdminController::class, 'clientes'])->name('admin.clientes');
            Route::post('/crear', [AdminController::class, 'crearCliente'])->name('admin.crear-cliente');
            Route::get('/{id}', [AdminController::class, 'verCliente'])->name('admin.ver-cliente');
            Route::post('/{id}/actualizar', [AdminController::class, 'actualizarCliente'])->name('admin.actualizar-cliente');
            Route::delete('/{id}', [AdminController::class, 'eliminarCliente'])->name('admin.eliminar-cliente');
        });
        
        // Gestión de facturas (admin)
        Route::get('/facturas', [AdminController::class, 'facturas'])->name('admin.facturas');
        
        // Gestión de pedidos (admin)
        Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
        
        // Gestión de reservas (admin)
        Route::get('/reservas', [AdminController::class, 'reservas'])->name('admin.reservas');
        
        // Reportes y estadísticas
        Route::get('/reportes', [AdminController::class, 'reportes'])->name('admin.reportes');
    });
});

// ==================== RUTAS DE API/RECURSOS ====================
Route::middleware(['auth'])->group(function () {
    // Rutas para AJAX o API interna
    Route::get('/api/facturas/{id}', [FacturaController::class, 'getDetalles']);
    Route::get('/api/clientes/{id}', [AdminController::class, 'getClienteInfo']);
});