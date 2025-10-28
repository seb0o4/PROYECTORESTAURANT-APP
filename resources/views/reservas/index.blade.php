<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .reservas-card {
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
                <a href="{{ route('menu') }}" class="btn btn-outline-light btn-sm me-2">Menú</a>
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
                <div class="reservas-card">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #2e7d32, #4caf50); color: white; border-radius: 20px 20px 0 0;">
                        <h2>📅 Realizar Reserva</h2>
                        <p class="mb-0">Reserva tu mesa en nuestro restaurante</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('reservas.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha de Reserva</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <select class="form-select" id="hora" name="hora" required>
                                        <option value="">Seleccionar hora</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="19:00">7:00 PM</option>
                                        <option value="20:00">8:00 PM</option>
                                        <option value="21:00">9:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="personas" class="form-label">Número de Personas</label>
                                    <select class="form-select" id="personas" name="personas" required>
                                        <option value="">Seleccionar</option>
                                        @for($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}">{{ $i }} persona{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono de Contacto</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ $user->phone }}" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notas" class="form-label">Notas Especiales (opcional)</label>
                                <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Alergias, requerimientos especiales, etc."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-lg">
                                📅 Confirmar Reserva
                            </button>
                            <a href="{{ route('reservas.historial') }}" class="btn btn-outline-primary btn-lg ms-2">
                                📊 Ver Historial
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fecha').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    ✅ {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif