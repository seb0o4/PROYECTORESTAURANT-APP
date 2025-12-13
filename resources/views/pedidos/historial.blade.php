<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .historial-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: none;
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
                <a href="{{ route('pedidos') }}" class="btn btn-outline-light btn-sm me-2">Pedidos Actuales</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="historial-card">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #2e7d32, #4caf50); color: white; border-radius: 20px 20px 0 0;">
                        <h2>📊 Historial de Pedidos</h2>
                        <p class="mb-0">Revisa todos tus pedidos anteriores</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: #ccc; margin: 2rem 0;">🕒</div>
                            <h4>No hay pedidos en tu historial</h4>
                            <p class="text-muted">Una vez que realices pedidos, aparecerán aquí.</p>
                            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg">
                                📋 Realizar Mi Primer Pedido
                            </a>
                        </div>
                        
                        <!-- Ejemplo de cómo se verían los pedidos en el futuro -->
                        <div class="mt-5">
                            <h5>Ejemplo de pedidos futuros:</h5>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Pedido #001</strong><br>
                                            <small class="text-muted">Fecha: 20/10/2025 - Estado: Completado</small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Total: $25.50</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-outline-primary">Ver Detalles</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>