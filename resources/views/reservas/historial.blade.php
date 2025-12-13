<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Reservas - Restaurante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            color: #3b2a1f;
        }

        /* VIDEO FONDO */
        .video-bg {
            position: fixed;
            inset: 0;
            z-index: -2;
        }

        .video-bg video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(.45);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: -1;
        }

        /* HEADER */
        .header-center {
            display: flex;
            justify-content: center;
            margin-top: 35px;
        }

        .header-glass {
            width: 92%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(20,20,20,.65);
            backdrop-filter: blur(18px);
            padding: 18px 30px;
            border-radius: 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,.6);
        }

        .header-left {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-right span {
            color: #ddd;
            font-weight: 600;
        }

        .btn-header {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 700;
            text-decoration: none;
            transition: .3s;
        }

        .btn-header:hover {
            background: rgba(255,255,255,.2);
            transform: translateY(-2px);
        }

        .btn-header.logout {
            background: rgba(200,60,60,.7);
        }

        /* CONTENIDO */
        .content-wrapper {
            display: flex;
            justify-content: center;
            margin: 70px 15px 120px;
        }

        .historial-card {
            width: 100%;
            max-width: 1200px;
            background: rgba(190,165,130,.88);
            backdrop-filter: blur(14px);
            border-radius: 30px;
            box-shadow: 0 40px 80px rgba(0,0,0,.5);
            overflow: hidden;
        }

        .historial-header {
            background: rgba(130,95,65,.95);
            color: #fff;
            text-align: center;
            padding: 35px;
        }

        .historial-body {
            padding: 40px;
            background: rgba(255,255,255,.95);
        }

        /* ESTADOS */
        .estado {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 700;
        }

        .pendiente { background: #fff3cd; color: #856404; }
        .confirmada { background: #d1edff; color: #0c5460; }
        .cancelada { background: #f8d7da; color: #721c24; }

        table th {
            font-weight: 800;
        }
    </style>
</head>

<body>

<!-- VIDEO -->
<div class="video-bg">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('videos/videocosina.mp4') }}" type="video/mp4">
    </video>
</div>

<!-- HEADER -->
<div class="header-center">
    <div class="header-glass">
        <div class="header-left">📊 Historial de Reservas</div>
        <div class="header-right">
            <span>Hola, {{ $user->name }}</span>
            <a href="{{ route('reservas') }}" class="btn-header">Nueva Reserva</a>
            <a href="{{ route('dashboard') }}" class="btn-header">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-header logout">Salir</button>
            </form>
        </div>
    </div>
</div>

<!-- CONTENIDO -->
<div class="content-wrapper">
    <div class="historial-card">

        <div class="historial-header">
            <h2>📅 Tus Reservas</h2>
            <p class="mb-0">Todas tus reservas en un solo lugar</p>
        </div>

        <div class="historial-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($reservas->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Personas</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->fecha->format('d/m/Y') }}</td>
                            <td>{{ $reserva->hora }}</td>
                            <td>{{ $reserva->personas }}</td>
                            <td>{{ $reserva->telefono }}</td>
                            <td>
                                @if($reserva->estado == 'pendiente')
                                    <span class="estado pendiente">⏳ Pendiente</span>
                                @elseif($reserva->estado == 'confirmada')
                                    <span class="estado confirmada">✅ Confirmada</span>
                                @else
                                    <span class="estado cancelada">❌ Cancelada</span>
                                @endif
                            </td>
                            <td>{{ $reserva->notas ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- STATS -->
            <div class="row mt-4 text-center">
                <div class="col-md-3"><strong>{{ $reservas->where('estado','pendiente')->count() }}</strong><br><small>Pendientes</small></div>
                <div class="col-md-3"><strong>{{ $reservas->where('estado','confirmada')->count() }}</strong><br><small>Confirmadas</small></div>
                <div class="col-md-3"><strong>{{ $reservas->where('estado','cancelada')->count() }}</strong><br><small>Canceladas</small></div>
                <div class="col-md-3"><strong>{{ $reservas->count() }}</strong><br><small>Total</small></div>
            </div>

            @else
            <div class="text-center py-5">
                <div style="font-size:4rem;">📅</div>
                <h4>No tienes reservas aún</h4>
                <p class="text-muted">Empieza haciendo tu primera reserva</p>
                <a href="{{ route('reservas') }}" class="btn btn-dark btn-lg rounded-pill">
                    📅 Reservar Ahora
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
</body>
</html>
