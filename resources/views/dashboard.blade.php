<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-color: #8b6848;
            --admin-color-dark: #6f533a;
            --admin-glass: rgba(139, 104, 72, 0.35);
            --admin-glass-hover: rgba(139, 104, 72, 0.55);
            --text-light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        /* VIDEO */
        .bg-video {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -3;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                rgba(0,0,0,0.45),
                rgba(0,0,0,0.75)
            );
            z-index: -2;
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
            background: var(--admin-color);
            color: white;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-admin:hover {
            background: var(--admin-color-dark);
        }

        .btn-logout {
            background: rgba(255,255,255,0.25);
            color: white;
            border-radius: 30px;
            padding: 8px 20px;
            border: none;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.4);
        }

        /* CARD CENTRAL */
        .dashboard-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--admin-glass);
            backdrop-filter: blur(18px);
            border-radius: 28px;
            padding: 55px;
            width: 90%;
            max-width: 900px;
            color: var(--text-light);
            box-shadow: 0 25px 60px rgba(0,0,0,0.55);
            text-align: center;
        }

        .dashboard-card h1 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .dashboard-card p {
            opacity: 0.9;
        }

        /* OPCIONES */
        .options {
            margin-top: 45px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 25px;
        }

        .option-card {
            background: rgba(255,255,255,0.15);
            border-radius: 22px;
            padding: 28px;
            text-align: center;
            color: white;
            text-decoration: none;
            transition: all 0.35s ease;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .option-card:hover {
            background: var(--admin-glass-hover);
            transform: translateY(-6px) scale(1.02);
        }

        .option-card span {
            font-size: 38px;
            display: block;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

<!-- VIDEO -->
<video class="bg-video" autoplay muted loop playsinline>
    <source src="{{ asset('videos/videococina.mp4') }}" type="video/mp4">
</video>

<div class="overlay"></div>

<!-- BOTONES -->
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
