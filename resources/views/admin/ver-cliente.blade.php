<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Cliente - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); min-height: 100vh;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">👑 Panel Admin</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('admin.clientes') }}" class="btn btn-outline-light btn-sm me-2">← Volver</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Sitio Principal</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>👤 Detalles del Cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> #{{ $cliente->id }}</p>
                                <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                                <p><strong>Email:</strong> {{ $cliente->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Teléfono:</strong> {{ $cliente->phone ?? 'No registrado' }}</p>
                                <p><strong>Rol:</strong> <span class="badge bg-success">{{ $cliente->role }}</span></p>
                                <p><strong>Registrado:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.clientes') }}" class="btn btn-secondary">← Volver a la lista</a>
                            <form action="{{ route('admin.eliminar-cliente', $cliente->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('¿Estás seguro de eliminar a {{ $cliente->name }}?')">
                                    🗑️ Eliminar Cliente
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>