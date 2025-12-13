<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        /* VIDEO FONDO */
        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                rgba(0, 0, 0, 0.35),
                rgba(0, 0, 0, 0.65)
            );
            z-index: -1;
        }

        /* BOTONES SUPERIORES */
        .top-buttons {
            position: fixed;
            top: 25px;
            right: 35px;
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .btn-admin {
            background: linear-gradient(135deg, #f9a825, #ffb300);
            color: white;
            border-radius: 25px;
            padding: 8px 18px;
            font-weight: bold;
            border: none;
        }

        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            border-radius: 25px;
            padding: 8px 18px;
            border: none;
        }

        /* TARJETA CENTRAL */
        .dashboard-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.20);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 50px;
            width: 90%;
            max-width: 900px;
            color: white;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        .dashboard-card h1 {
            font-weight: 700;
            text-align: center;
        }

        .dashboard-card p {
            text-align: center;
            opacity: 0.85;
        }

        /* OPCIONES */
        .options {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 25px;
        }

        .option-card {
            background: rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            color: white;
            transition: 0.3s;
            text-decoration: none;
        }

        .option-card:hover {
            transform: translateY(-6px);
            background: rgba(255,255,255,0.35);
        }

        .option-card span {
            font-size: 36px;
            display: block;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

<!-- VIDEO -->
<video autoplay muted loop playsinline class="bg-video">
    <source src="/videos/videococina.mp4" type="video/mp4">
</video>
<div class="overlay"></div>

<!-- BOTONES ARRIBA -->
<div class="top-buttons">
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn-admin">⚙ Admin</a>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-logout">Salir</button>
    </form>
</div>

<!-- DASHBOARD -->
<div class="dashboard-card">
    <h1>Welcome, {{ auth()->user()->name }} 👋</h1>
    <p>Manage your restaurant experience from one elegant place</p>

    <div class="options">
        <a href="{{ route('menu') }}" class="option-card">
            <span>🍽</span>
            Order Food
        </a>

        <a href="{{ route('reservas') }}" class="option-card">
            <span>🪑</span>
            Reserve Table
        </a>

        <a href="{{ route('facturas') }}" class="option-card">
            <span>📄</span>
            Invoices
        </a>

        <a href="{{ route('pedidos.historial') }}" class="option-card">
            <span>⏳</span>
            History
        </a>
    </div>
</div>
</body>
</html>
