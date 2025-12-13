<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - Pozitos Restaurant</title>
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
        
        .factura-item {
            border-left: 4px solid #2196F3;
            transition: all 0.3s ease;
        }
        
        .factura-item:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <span style="font-size: 1.5rem;">🍽️</span> Pozitos Restaurant
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Hola, {{ Auth::user()->name }}</span>
                <a href="{{ route('facturas') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-history"></i> Historial de Comprobantes</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Información del historial -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5><i class="fas fa-list"></i> Todos mis comprobantes</h5>
                                <p class="text-muted mb-0">Mostrando {{ $facturas->total() }} comprobantes en total</p>
                            </div>
                            <a href="{{ route('facturas') }}" class="btn btn-outline-success">
                                <i class="fas fa-arrow-left"></i> Volver a Inicio
                            </a>
                        </div>

                        <!-- Lista de Comprobantes -->
                        @if($facturas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>N° Comprobante</th>
                                            <th>Fecha</th>
                                            <th>Descripción</th>
                                            <th>Subtotal</th>
                                            <th>IGV</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($facturas as $factura)
                                        <tr class="factura-item">
                                            <td>
                                                <strong>{{ $factura->numero }}</strong>
                                            </td>
                                            <td>{{ $factura->fecha_emision->format('d/m/Y') }}</td>
                                            <td>{{ Str::limit($factura->concepto, 30) }}</td>
                                            <td>S/ {{ number_format($factura->subtotal, 2) }}</td>
                                            <td>S/ {{ number_format($factura->impuestos, 2) }}</td>
                                            <td><strong>S/ {{ number_format($factura->total, 2) }}</strong></td>
                                            <td>
                                                <span class="badge 
                                                    @if($factura->estado == 'pagada') bg-success
                                                    @elseif($factura->estado == 'pendiente') bg-warning
                                                    @else bg-secondary @endif">
                                                    @if($factura->estado == 'pagada') Pagado
                                                    @elseif($factura->estado == 'pendiente') Pendiente
                                                    @else {{ ucfirst($factura->estado) }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('facturas.descargar', $factura->id) }}" 
                                                       class="btn btn-outline-primary" title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('facturas.detalles', $factura->id) }}" 
                                                       class="btn btn-outline-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($factura->estado == 'pendiente')
                                                    <form method="POST" action="{{ route('facturas.pagar', $factura->id) }}" 
                                                          class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" 
                                                                title="Pagar" 
                                                                onclick="return confirm('¿Confirmar pago de {{ $factura->numero }}?')">
                                                            <i class="fas fa-credit-card"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Mostrando {{ $facturas->firstItem() }} - {{ $facturas->lastItem() }} de {{ $facturas->total() }} comprobantes
                                </div>
                                <div>
                                    {{ $facturas->links() }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay comprobantes en el historial</h4>
                                <p class="text-muted">Aún no has generado ningún comprobante</p>
                                <div class="mt-3">
                                    <a href="{{ route('facturas') }}" class="btn btn-success me-2">
                                        <i class="fas fa-arrow-left"></i> Volver a Comprobantes
                                    </a>
                                    <a href="{{ route('menu') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-utensils"></i> Hacer un Pedido
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>