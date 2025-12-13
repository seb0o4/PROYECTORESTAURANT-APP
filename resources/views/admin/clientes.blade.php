<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Pozitos Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
        }
        
        .cliente-item {
            border-left: 4px solid #28a745;
            transition: all 0.3s ease;
        }
        
        .cliente-item:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin">
                <span style="font-size: 1.5rem;">🍽️</span> Pozitos Restaurant - Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Hola, {{ Auth::user()->name }}</span>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Dashboard
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
                        <h4 class="mb-0"><i class="fas fa-users"></i> Gestión de Clientes</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Estadísticas -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">👥</div>
                                    <h4 class="text-primary">{{ $totalClientes ?? 0 }}</h4>
                                    <small>Total Clientes</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">✅</div>
                                    <h4 class="text-success">{{ $clientesActivos ?? 0 }}</h4>
                                    <small>Clientes Activos</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stats-card">
                                    <div style="font-size: 2rem;">💰</div>
                                    <h4 class="text-info">{{ ($totalClientes ?? 0) - ($clientesActivos ?? 0) }}</h4>
                                    <small>Clientes Inactivos</small>
                                </div>
                            </div>
                        </div>

                        <!-- AQUÍ VA TU CÓDIGO -->
                        <!-- Acciones -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5><i class="fas fa-list"></i> Lista de Clientes</h5>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearClienteModal">
                                <i class="fas fa-plus"></i> Nuevo Cliente
                            </button>
                        </div>

                        <!-- Lista de Clientes -->
                        @if($clientes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Fecha Registro</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clientes as $cliente)
                                        <tr class="cliente-item">
                                            <td><strong>#{{ $cliente->id }}</strong></td>
                                            <td>{{ $cliente->name }}</td>
                                            <td>{{ $cliente->email }}</td>
                                            <td>{{ $cliente->phone ?? 'No registrado' }}</td>
                                            <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($cliente->estado == 'activo') bg-success
                                                    @elseif($cliente->estado == 'inactivo') bg-danger
                                                    @else bg-secondary @endif">
                                                    {{ $cliente->estado ?? 'Activo' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.ver-cliente', $cliente->id) }}" 
                                                       class="btn btn-outline-info" title="Ver Detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editarClienteModal{{ $cliente->id }}"
                                                            title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.eliminar-cliente', $cliente->id) }}" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                title="Eliminar" 
                                                                onclick="return confirm('¿Estás seguro de eliminar a {{ $cliente->name }}?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $clientes->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">No hay clientes registrados</h4>
                                <p class="text-muted">Aún no hay clientes en el sistema</p>
                                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#crearClienteModal">
                                    <i class="fas fa-plus"></i> Agregar Primer Cliente
                                </button>
                            </div>
                        @endif
                        <!-- FIN DE TU CÓDIGO -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Cliente -->
    <div class="modal fade" id="crearClienteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Nuevo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.crear-cliente') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Crear Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>