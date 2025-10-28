<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #4caf50;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
        }
        
        .factura-card {
            border-left: 4px solid #2196F3;
            transition: all 0.3s ease;
        }
        
        .factura-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .badge-estado {
            font-size: 0.75rem;
            padding: 0.4em 0.8em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <span style="font-size: 1.5rem;">🍽️</span> Restaurante App
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Hola, {{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="dashboard-card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Dashboard - Cliente</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h5>👋 Bienvenido, {{ $user->name }}!</h5>
                                <p class="text-muted">Gestiona tus pedidos, reservas y facturas desde aquí</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-success fs-6">{{ $user->role }}</span>
                            </div>
                        </div>

                        <!-- Información del usuario -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>📧 Email:</strong> {{ $user->email }}</p>
                                <p><strong>📞 Teléfono:</strong> {{ $user->phone ?? 'No registrado' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>👤 Miembro desde:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                                <p><strong>🆔 ID de Cliente:</strong> #{{ $user->id }}</p>
                            </div>
                        </div>

                        <!-- Estadísticas rápidas ACTUALIZADAS -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">🛒</div>
                                    <h4 class="text-success">{{ $pedidosActivos ?? 0 }}</h4>
                                    <small>Pedidos Activos</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">📅</div>
                                    <h4 class="text-info">{{ $reservasActivas ?? 0 }}</h4>
                                    <small>Reservas Activas</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">🧾</div>
                                    <h4 class="text-warning">{{ $facturasRecientes->count() ?? 0 }}</h4>
                                    <small>Facturas Recientes</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">💰</div>
                                    <h4 class="text-primary">${{ number_format($totalGastado ?? 0, 2) }}</h4>
                                    <small>Gasto Total</small>
                                </div>
                            </div>
                        </div>

                        <!-- SISTEMA DE FACTURACIÓN - NUEVA SECCIÓN -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>🧾 Sistema de Facturación</h5>
                                    <a href="{{ route('facturas.historial') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-history"></i> Ver Historial Completo
                                    </a>
                                </div>
                                
                                @if(isset($facturasRecientes) && $facturasRecientes->count() > 0)
                                    <div class="row">
                                        @foreach($facturasRecientes as $factura)
                                        <div class="col-md-6 mb-3">
                                            <div class="card factura-card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="card-title">Factura #{{ $factura->numero }}</h6>
                                                            <p class="card-text mb-1">
                                                                <small class="text-muted">
                                                                    Fecha: {{ $factura->created_at->format('d/m/Y') }}
                                                                </small>
                                                            </p>
                                                            <p class="card-text mb-1">
                                                                <strong>Total: ${{ number_format($factura->total, 2) }}</strong>
                                                            </p>
                                                        </div>
                                                        <span class="badge 
                                                            @if($factura->estado == 'pagada') bg-success
                                                            @elseif($factura->estado == 'pendiente') bg-warning
                                                            @elseif($factura->estado == 'cancelada') bg-danger
                                                            @else bg-secondary @endif badge-estado">
                                                            {{ ucfirst($factura->estado) }}
                                                        </span>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-sm btn-outline-primary ver-factura" 
                                                                data-factura-id="{{ $factura->id }}">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </button>
                                                        <a href="{{ route('facturas.descargar', $factura->id) }}" 
                                                           class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-download"></i> Descargar PDF
                                                        </a>
                                                        @if($factura->estado == 'pendiente')
                                                        <button class="btn btn-sm btn-outline-warning pagar-factura"
                                                                data-factura-id="{{ $factura->id }}">
                                                            <i class="fas fa-credit-card"></i> Pagar
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay facturas recientes</p>
                                        <a href="{{ route('menu') }}" class="btn btn-primary">
                                            <i class="fas fa-utensils"></i> Realizar primer pedido
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones principales ACTUALIZADAS -->
                        <div class="mt-4">
                            <h6>🚀 Acciones disponibles:</h6>
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <a href="{{ route('menu') }}" class="btn btn-primary">
                                    <i class="fas fa-utensils"></i> Ver Menú & Realizar Pedido
                                </a>
                                <a href="{{ route('reservas') }}" class="btn btn-success">
                                    <i class="fas fa-calendar-plus"></i> Hacer Reserva
                                </a>
                                <a href="{{ route('facturas') }}" class="btn btn-info">
                                    <i class="fas fa-file-invoice-dollar"></i> Mis Facturas
                                </a>
                                <a href="{{ route('pedidos.historial') }}" class="btn btn-warning">
                                    <i class="fas fa-history"></i> Historial de Pedidos
                                </a>
                            </div>
                        </div>

                        <!-- Panel de Administración (si es admin) -->
                        @if($user->role === 'admin')
                        <div class="mt-4 p-3 border rounded bg-light">
                            <h6><i class="fas fa-crown"></i> Panel de Administración</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.clientes') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-users"></i> Gestionar Clientes
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-chart-bar"></i> Dashboard Admin
                                </a>
                                <a href="{{ route('admin.facturas') }}" class="btn btn-dark btn-sm">
                                    <i class="fas fa-file-invoice"></i> Gestionar Facturas
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver factura -->
    <div class="modal fade" id="modalFactura" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de Factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="facturaDetalles">
                    <!-- Los detalles se cargarán aquí via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript para el sistema de facturación
        document.addEventListener('DOMContentLoaded', function() {
            // Ver detalles de factura
            document.querySelectorAll('.ver-factura').forEach(button => {
                button.addEventListener('click', function() {
                    const facturaId = this.getAttribute('data-factura-id');
                    cargarDetallesFactura(facturaId);
                });
            });

            // Pagar factura
            document.querySelectorAll('.pagar-factura').forEach(button => {
                button.addEventListener('click', function() {
                    const facturaId = this.getAttribute('data-factura-id');
                    pagarFactura(facturaId);
                });
            });

            function cargarDetallesFactura(facturaId) {
                // Aquí iría la llamada AJAX para cargar los detalles
                fetch(`/facturas/${facturaId}/detalles`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('facturaDetalles').innerHTML = data.html;
                        const modal = new bootstrap.Modal(document.getElementById('modalFactura'));
                        modal.show();
                    })
                    .catch(error => console.error('Error:', error));
            }

            function pagarFactura(facturaId) {
                if(confirm('¿Estás seguro de que deseas pagar esta factura?')) {
                    fetch(`/facturas/${facturaId}/pagar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            alert('Factura pagada exitosamente');
                            location.reload();
                        } else {
                            alert('Error al procesar el pago');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
    </script>
</body>
</html>