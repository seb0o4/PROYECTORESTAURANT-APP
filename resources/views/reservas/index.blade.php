<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - Restaurante</title>
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

        /* HEADER GLASS */
        .header-center {
            display: flex;
            justify-content: center;
            margin-top: 35px;
        }

        .header-glass {
            width: 92%;
            max-width: 1100px;
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

        .reserva-card {
            width: 100%;
            max-width: 900px;
            background: rgba(190,165,130,.88);
            backdrop-filter: blur(14px);
            border-radius: 30px;
            box-shadow: 0 40px 80px rgba(0,0,0,.5);
            overflow: hidden;
        }

        .reserva-header {
            background: rgba(130,95,65,.95);
            color: #fff;
            text-align: center;
            padding: 35px;
        }

        .reserva-body {
            padding: 45px;
            background: rgba(255,255,255,.95);
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 15px;
            padding: 12px;
        }

        .btn-main {
            background: #8b6b55;
            color: #fff;
            border-radius: 30px;
            font-weight: 800;
            padding: 12px 30px;
            border: none;
        }

        .btn-main:hover {
            background: #725643;
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
        <div class="header-left">📅 Reservas</div>
        <div class="header-right">
            <span>Hola, {{ $user->name }}</span>
            <a href="{{ route('menu') }}" class="btn-header">Menú</a>
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
    <div class="reserva-card">

        <div class="reserva-header">
            <h2>📅 Realizar Reserva</h2>
            <p class="mb-0">Reserva tu mesa en nuestro restaurante</p>
        </div>

        <div class="reserva-body">
            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hora</label>
                        <select class="form-select" name="hora" required>
                            <option value="">Seleccionar</option>
                            <option>12:00</option>
                            <option>13:00</option>
                            <option>14:00</option>
                            <option>19:00</option>
                            <option>20:00</option>
                            <option>21:00</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Personas</label>
                        <select class="form-select" name="personas" required>
                            <option value="">Seleccionar</option>
                            @for($i=1;$i<=20;$i++)
                                <option value="{{ $i }}">{{ $i }} persona{{ $i>1?'s':'' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono" value="{{ $user->phone }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" name="notas" rows="3" placeholder="Alergias o requerimientos especiales"></textarea>
                </div>

                <div class="d-flex gap-3">
                    <button class="btn-main">📅 Confirmar Reserva</button>
                    <a href="{{ route('reservas.historial') }}" class="btn btn-outline-dark btn-lg rounded-pill">
                        📊 Historial
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>
