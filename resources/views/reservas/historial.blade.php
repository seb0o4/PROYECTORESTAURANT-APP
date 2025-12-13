<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservas - Restaurante</title>
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
        
        .estado-pendiente {
            background-color: #fff3cd;
            color: #856404;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .estado-confirmada {
            background-color: #d1edff;
            color: #0c5460;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .estado-cancelada {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .reserva-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .reserva-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
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
                <a href="{{ route('reservas') }}" class="btn btn-outline-light btn-sm me-2">Nueva Reserva</a>
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
                        <h2>📊 Historial de Reservas</h2>
                        <p class="mb-0">Todas tus reservas en un solo lugar</p>
                    </div>
                    <div class="card-body p-4">
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if($reservas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Personas</th>
                                            <th>Teléfono</th>
                                            <th>Estado</th>
                                            <th>Notas</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservas as $reserva)
                                        <tr>
                                            <td>{{ $reserva->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $reserva->hora }}</td>
                                            <td>{{ $reserva->personas }} personas</td>
                                            <td>{{ $reserva->telefono }}</td>
                                            <td>
                                                @if($reserva->estado == 'pendiente')
                                                    <span class="estado-pendiente">⏳ Pendiente</span>
                                                @elseif($reserva->estado == 'confirmada')
                                                    <span class="estado-confirmada">✅ Confirmada</span>
                                                @else
                                                    <span class="estado-cancelada">❌ Cancelada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reserva->notas)
                                                    <small class="text-muted">{{ Str::limit($reserva->notas, 30) }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Ver</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;">📅</div>
                                <h4>No hay reservas en tu historial</h4>
                                <p class="text-muted">Realiza tu primera reserva para comenzar.</p>
                                <a href="{{ route('reservas') }}" class="btn btn-primary btn-lg">
                                    📅 Hacer Mi Primera Reserva
                                </a>
                            </div>
                        @endif

                        <!-- Estadísticas -->
                        @if($reservas->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="text-primary">{{ $reservas->where('estado', 'pendiente')->count() }}</h5>
                                        <small>Pendientes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="text-success">{{ $reservas->where('estado', 'confirmada')->count() }}</h5>
                                        <small>Confirmadas</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="text-danger">{{ $reservas->where('estado', 'cancelada')->count() }}</h5>
                                        <small>Canceladas</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="text-info">{{ $reservas->count() }}</h5>
                                        <small>Total</small>
                                    </div>
                                </div>
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