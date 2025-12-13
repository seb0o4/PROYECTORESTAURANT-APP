<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos</title>
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

        /* HEADER CENTRADO */
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

        .historial-card {
            width: 100%;
            max-width: 1000px;
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
            padding: 45px;
            background: rgba(255,255,255,.95);
        }

        .pedido-card {
            background: rgba(255,255,255,.95);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
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
<div class="header-center">
    <div class="header-glass">
        <div class="header-left">📊 Historial de Pedidos</div>
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
    <div class="historial-card">

        <div class="historial-header">
            <h2>🕒 Historial de Pedidos</h2>
            <p class="mb-0">Revisa todos tus pedidos anteriores</p>
        </div>

        <div class="historial-body text-center">

            <!-- VACÍO -->
            <div style="font-size: 4rem; color: #bbb;">🕒</div>
            <h4>No hay pedidos en tu historial</h4>
            <p class="text-muted">Cuando realices pedidos, aparecerán aquí.</p>

            <a href="{{ route('menu') }}" class="btn btn-lg mt-3"
               style="background:#8b6b55;color:white;border-radius:30px;font-weight:800;">
                📋 Realizar Mi Primer Pedido
            </a>

            <!-- EJEMPLO -->
            <div class="mt-5 text-start">
                <h5>Ejemplo de pedidos futuros</h5>

                <div class="pedido-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <strong>Pedido #001</strong><br>
                            <small class="text-muted">Fecha: 20/10/2025 · Estado: Completado</small>
                        </div>
                        <div class="col-md-4 fw-bold">
                            Total: $25.50
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-outline-dark btn-sm">Ver</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>
