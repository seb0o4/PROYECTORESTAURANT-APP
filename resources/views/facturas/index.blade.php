<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Facturas - Pozitos Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP + ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            color: #3b2a1f;
        }

        /* VIDEO */
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

        .facturas-card {
            width: 100%;
            max-width: 1200px;
            background: rgba(190,165,130,.88);
            backdrop-filter: blur(14px);
            border-radius: 30px;
            box-shadow: 0 40px 80px rgba(0,0,0,.5);
            overflow: hidden;
        }

        .facturas-header {
            background: rgba(130,95,65,.95);
            color: #fff;
            text-align: center;
            padding: 35px;
        }

        .facturas-body {
            padding: 40px;
            background: rgba(255,255,255,.95);
        }

        /* STATS */
        .stats-card {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            transition: .3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        table th {
            font-weight: 800;
        }

        .factura-row:hover {
            background: #f6f1ea;
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
        <div class="header-left">🧾 Mis Facturas</div>
        <div class="header-right">
            <span>Hola, {{ Auth::user()->name }}</span>
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
    <div class="facturas-card">

        <div class="facturas-header">
            <h2>📄 Mis Comprobantes</h2>
            <p class="mb-0">Resumen de todas tus facturas</p>
        </div>

        <div class="facturas-body">

            <!-- ALERT -->
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- STATS -->
            <div class="row mb-4 text-center">
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div style="font-size:2rem">🧾</div>
                        <h4>{{ $totalFacturas ?? 0 }}</h4>
                        <small>Total</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div style="font-size:2rem">⏳</div>
                        <h4>{{ $facturasPendientes ?? 0 }}</h4>
                        <small>Pendientes</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div style="font-size:2rem">✅</div>
                        <h4>{{ ($totalFacturas ?? 0) - ($facturasPendientes ?? 0) }}</h4>
                        <small>Pagadas</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div style="font-size:2rem">💰</div>
                        <h4>S/ {{ number_format($totalIngresos ?? 0, 2) }}</h4>
                        <small>Total Gastado</small>
                    </div>
                </div>
            </div>

            <!-- TABLA -->
            @if(isset($facturasRecientes) && $facturasRecientes->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facturasRecientes as $factura)
                        <tr class="factura-row">
                            <td><strong>{{ $factura->numero }}</strong></td>
                            <td>{{ $factura->fecha_emision->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($factura->concepto, 30) }}</td>
                            <td><strong>S/ {{ number_format($factura->total,2) }}</strong></td>
                            <td>
                                <span class="badge 
                                    {{ $factura->estado == 'pagada' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($factura->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('facturas.detalles',$factura->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('facturas.descargar',$factura->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div style="font-size:4rem">🧾</div>
                <h4>No tienes facturas aún</h4>
                <p class="text-muted">Haz un pedido para generar tu primer comprobante</p>
                <a href="{{ route('menu') }}" class="btn btn-dark btn-lg rounded-pill">
                    🍽️ Ver Menú
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
</body>
</html>
