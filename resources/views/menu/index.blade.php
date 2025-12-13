<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restaurante App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP + ICONOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

        /* CONTENEDOR MENU */
        .menu-wrapper {
            display: flex;
            justify-content: center;
            margin: 70px 15px 120px;
        }

        .menu-card {
            width: 100%;
            max-width: 1200px;
            background: rgba(180,155,120,.85);
            backdrop-filter: blur(14px);
            border-radius: 30px;
            padding-bottom: 40px;
            box-shadow: 0 40px 80px rgba(0,0,0,.5);
        }

        .menu-header {
            text-align: center;
            padding: 40px;
            color: #fff;
            background: rgba(130,95,65,.9);
            border-radius: 30px 30px 0 0;
        }

        .menu-header h2 {
            font-weight: 900;
        }

        /* CATEGORIA */
        .categoria {
            padding: 40px;
        }

        .categoria h3 {
            font-weight: 900;
            margin-bottom: 30px;
        }

        /* PRODUCTOS */
        .producto {
            background: rgba(255,255,255,.92);
            border-radius: 25px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,.2);
            transition: .3s;
        }

        .producto:hover {
            transform: translateY(-8px);
        }

        .producto .icono {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .precio {
            font-weight: 900;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .contador {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 15px 0;
        }

        .contador button {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            font-weight: 900;
        }

        .btn-agregar {
            background: #8b6b55;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 30px;
            font-weight: 800;
            width: 100%;
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
        <div class="header-left">🍽️ Restaurante App</div>
        <div class="header-right">
            <span>Hola, {{ Auth::user()->name }}</span>
            <a href="{{ route('pedidos') }}" class="btn-header">Pedidos</a>
            <a href="{{ route('facturas') }}" class="btn-header">Facturas</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-header logout">Salir</button>
            </form>
        </div>
    </div>
</div>

<!-- MENU -->
<div class="menu-wrapper">
    <div class="menu-card">
        <div class="menu-header">
            <h2>🍽️ Nuestro Menú</h2>
            <p>Selecciona los platos para tu pedido</p>
        </div>

        @foreach($categorias as $categoria)
        <div class="categoria">
            <h3>{{ $categoria['nombre'] }}</h3>

            <div class="row g-4">
                @foreach($categoria['productos'] as $producto)
                <div class="col-md-4">
                    <div class="producto">
                        <div class="icono">{{ $producto['imagen'] }}</div>
                        <h5>{{ $producto['nombre'] }}</h5>
                        <p class="text-muted small">{{ $producto['descripcion'] }}</p>
                        <div class="precio">S/ {{ number_format($producto['precio'],2) }}</div>

                        <div class="contador">
                            <button>-</button>
                            <span>0</span>
                            <button>+</button>
                        </div>

                        <button class="btn-agregar">
                            <i class="fas fa-cart-plus"></i> Agregar al Pedido
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>
</div>

</body>
</html>
