<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos - Restaurante</title>
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
        .header-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 35px;
        }

        .header-glass {
            width: 92%;
            max-width: 1100px;
            background: rgba(20,20,20,.65);
            backdrop-filter: blur(18px);
            border-radius: 40px;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 25px 60px rgba(0,0,0,.6);
        }

        .header-title {
            color: white;
            font-weight: 900;
            font-size: 1.2rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-actions span {
            color: #ddd;
            font-weight: 600;
        }

        .btn-header {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 700;
            text-decoration: none;
            transition: .3s;
        }

        .btn-header:hover {
            background: rgba(255,255,255,.25);
            transform: translateY(-2px);
        }

        .btn-header.logout {
            background: rgba(200,60,60,.75);
        }

        /* CONTENIDO */
        .content-wrapper {
            display: flex;
            justify-content: center;
            margin: 80px 15px 120px;
        }

        .historial-card {
            width: 100%;
            max-width: 1100px;
            background: rgba(190,165,130,.88);
            backdrop-filter: blur(14px);
            border-radius: 30px;
            box-shadow: 0 40px 80px rgba(0,0,0,.5);
            overflow: hidden;
        }

        .historial-header {
            background: rgba(130,95,65,.95);
            color: white;
            text-align: center;
            padding: 35px;
        }

        .historial-body {
            background: rgba(255,255,255,.95);
            padding: 50px;
            text-align: center;
        }

        .icon-big {
            font-size: 4rem;
            opacity: .4;
            margin-bottom: 20px;
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
<div class="header-wrapper">
    <div class="header-glass">
        <div class="header-title">📦 Historial de Pedidos</div>
        <div class="header-actions">
            <span>Hola, {{ $user->name }}</span>
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
            <h2>📊 Historial de Pedidos</h2>
            <p class="mb-0">Aquí podrás ver todos tus pedidos realizados</p>
        </div>

        <div class="historial-body">

            <div class="icon-big">🕒</div>
            <h4>No hay pedidos en tu historial</h4>
            <p class="text-muted mb-4">
                Una vez que realices un pedido, aparecerá aquí automáticamente.
            </p>

            <a href="{{ route('menu') }}" class="btn btn-dark btn-lg rounded-pill px-4">
                🍽️ Realizar mi primer pedido
            </a>

            <!-- EJEMPLO -->
            <div class="mt-5 text-start">
                <h5>Ejemplo de pedidos futuros</h5>
                <div class="card mt-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <strong>Pedido #001</strong><br>
                                <small class="text-muted">
                                    Fecha: 20/10/2025 · Estado: Completado
                                </small>
                            </div>
                            <div class="col-md-4">
                                <strong>Total: S/ 25.50</strong>
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-sm btn-outline-primary rounded-pill">
                                    Ver
                                </button>
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
