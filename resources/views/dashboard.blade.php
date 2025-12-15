<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Restaurante Gourmet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
            --card-bg: rgba(255, 255, 255, 0.95);
            --shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* Navbar Moderna */
        .navbar-modern {
            background: var(--dark-color);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Cards Modernas */
        .card-modern {
            background: var(--card-bg);
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        /* Stats Cards */
        .stat-card {
            padding: 1.5rem;
            border-radius: 15px;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 140px;
            transition: var(--transition);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            opacity: 0.9;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0 5px 0;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Factura Cards */
        .invoice-card {
            border: none;
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            border-left: 4px solid transparent;
        }

        .invoice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-left-color: #667eea;
        }

        /* Quick Actions */
        .quick-action {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            border: 2px solid transparent;
            height: 100%;
        }

        .quick-action:hover {
            border-color: #667eea;
            transform: translateY(-5px);
        }

        .quick-action-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* User Info Panel */
        .user-panel {
            background: var(--dark-color);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .user-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Scroll Personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        /* Badges Modernos */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Progress Bar Moderna */
        .progress-modern {
            height: 10px;
            border-radius: 10px;
            background: rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .progress-modern .progress-bar {
            border-radius: 10px;
            background: var(--primary-gradient);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i>GourmetExpress
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link text-white dropdown-toggle d-flex align-items-center" 
                            type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="me-3 text-end">
                            <div class="fw-bold">{{ $user->name }}</div>
                            <small class="text-white-50">{{ $user->role }}</small>
                        </div>
                        <div class="rounded-circle bg-white p-2">
                            <i class="fas fa-user text-dark"></i>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Principal -->
    <div class="container py-4">
        <div class="row g-4">
            <!-- Columna Izquierda - Estadísticas -->
            <div class="col-lg-8">
                <!-- Bienvenida -->
                <div class="card-modern p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">👋 ¡Bienvenido de nuevo, {{ explode(' ', $user->name)[0] }}!</h2>
                            <p class="text-muted mb-0">Aquí tienes un resumen de tu actividad en el restaurante</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge-modern" style="background: var(--primary-gradient); color: white;">
                                <i class="fas fa-crown me-1"></i> {{ $user->role }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas Rápidas -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: var(--success-gradient);">
                            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                            <div class="stat-value">{{ $pedidosActivos ?? 0 }}</div>
                            <div class="stat-label">Pedidos Activos</div>
                            <div class="progress-modern mt-2">
                                <div class="progress-bar" style="width: {{ min(($pedidosActivos ?? 0) * 20, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: var(--info-gradient);">
                            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                            <div class="stat-value">{{ $reservasActivas ?? 0 }}</div>
                            <div class="stat-label">Reservas Activas</div>
                            <div class="progress-modern mt-2">
                                <div class="progress-bar" style="width: {{ min(($reservasActivas ?? 0) * 25, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: var(--warning-gradient);">
                            <div class="stat-icon floating"><i class="fas fa-file-invoice-dollar"></i></div>
                            <div class="stat-value">{{ $facturasRecientes->count() ?? 0 }}</div>
                            <div class="stat-label">Facturas Recientes</div>
                            <div class="progress-modern mt-2">
                                <div class="progress-bar" style="width: {{ min(($facturasRecientes->count() ?? 0) * 10, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                            <div class="stat-value">${{ number_format($totalGastado ?? 0, 0) }}</div>
                            <div class="stat-label">Gasto Total</div>
                            <div class="progress-modern mt-2">
                                <div class="progress-bar" style="width: {{ min(($totalGastado ?? 0) / 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facturas Recientes -->
                <div class="card-modern p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold m-0"><i class="fas fa-receipt me-2"></i>Facturas Recientes</h4>
                        <a href="{{ route('facturas.historial') }}" class="btn btn-sm" 
                           style="background: var(--primary-gradient); color: white;">
                           Ver Todas <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    
                    @if(isset($facturasRecientes) && $facturasRecientes->count() > 0)
                        <div class="row g-3">
                            @foreach($facturasRecientes as $factura)
                            <div class="col-md-6">
                                <div class="invoice-card p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">Factura #{{ $factura->numero }}</h6>
                                            <small class="text-muted">
                                                {{ $factura->created_at->format('d M Y · h:i A') }}
                                            </small>
                                        </div>
                                        <span class="badge-modern 
                                            @if($factura->estado == 'pagada') 
                                                bg-success
                                            @elseif($factura->estado == 'pendiente') 
                                                bg-warning text-dark
                                            @elseif($factura->estado == 'cancelada') 
                                                bg-danger
                                            @else 
                                                bg-secondary 
                                            @endif">
                                            {{ ucfirst($factura->estado) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="fw-bold m-0">${{ number_format($factura->total, 2) }}</h5>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('facturas.descargar', $factura->id) }}" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if($factura->estado == 'pendiente')
                                            <button class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-receipt fa-4x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted mb-3">No hay facturas recientes</h5>
                            <a href="{{ route('menu') }}" class="btn" 
                               style="background: var(--primary-gradient); color: white;">
                                <i class="fas fa-utensils me-2"></i>Realizar Primer Pedido
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Columna Derecha - Acciones y Info -->
            <div class="col-lg-4">
                <!-- Información del Usuario -->
                <div class="user-panel mb-4">
                    <div class="position-relative z-1">
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-white p-3 d-inline-block mb-2">
                                <i class="fas fa-user fa-2x" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <p class="text-white-50 mb-3">Cliente #{{ $user->id }}</p>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="mb-2">
                                    <i class="fas fa-envelope mb-1"></i>
                                    <div class="small">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <i class="fas fa-phone mb-1"></i>
                                    <div class="small">{{ $user->phone ?? 'Sin teléfono' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-white-50">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Miembro desde {{ $user->created_at->format('M Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card-modern p-4 mb-4">
                    <h5 class="fw-bold mb-4">⚡ Acciones Rápidas</h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('menu') }}" class="quick-action text-decoration-none">
                                <div class="quick-action-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <h6 class="fw-bold">Ver Menú</h6>
                                <small class="text-muted">Ordenar comida</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('reservas') }}" class="quick-action text-decoration-none">
                                <div class="quick-action-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <h6 class="fw-bold">Reservar</h6>
                                <small class="text-muted">Mesa o evento</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('facturas') }}" class="quick-action text-decoration-none">
                                <div class="quick-action-icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <h6 class="fw-bold">Facturas</h6>
                                <small class="text-muted">Ver y pagar</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('pedidos.historial') }}" class="quick-action text-decoration-none">
                                <div class="quick-action-icon">
                                    <i class="fas fa-history"></i>
                                </div>
                                <h6 class="fw-bold">Historial</h6>
                                <small class="text-muted">Pedidos pasados</small>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Panel Admin (si aplica) -->
                @if($user->role === 'admin')
                <div class="card-modern p-4" style="border-left: 4px solid #667eea;">
                    <h5 class="fw-bold mb-3"><i class="fas fa-crown me-2"></i>Panel Admin</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">
                            <i class="fas fa-chart-bar me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.clientes') }}" class="btn btn-outline-dark">
                            <i class="fas fa-users me-2"></i>Clientes
                        </a>
                        <a href="{{ route('admin.facturas') }}" class="btn btn-outline-dark">
                            <i class="fas fa-file-invoice me-2"></i>Facturas
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted">
        <div class="container">
            <p class="mb-0">© 2024 GourmetExpress · Sistema de Gestión de Restaurantes</p>
            <small>Diseñado con <i class="fas fa-heart text-danger"></i> para la mejor experiencia gastronómica</small>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animaciones interactivas
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de aparición suave
            const cards = document.querySelectorAll('.card-modern, .stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Tooltips para botones
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Efecto hover en facturas
            const invoiceCards = document.querySelectorAll('.invoice-card');
            invoiceCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Contador animado para estadísticas
            const statValues = document.querySelectorAll('.stat-value');
            statValues.forEach(stat => {
                const finalValue = parseFloat(stat.textContent.replace(/[^0-9.-]+/g, ""));
                if (!isNaN(finalValue)) {
                    let startValue = 0;
                    const duration = 2000;
                    const startTime = Date.now();
                    
                    const updateCounter = () => {
                        const currentTime = Date.now();
                        const progress = Math.min((currentTime - startTime) / duration, 1);
                        const currentValue = Math.floor(progress * finalValue);
                        
                        if (stat.textContent.includes('$')) {
                            stat.textContent = '$' + currentValue.toLocaleString();
                        } else {
                            stat.textContent = currentValue;
                        }
                        
                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            if (stat.textContent.includes('$')) {
                                stat.textContent = '$' + finalValue.toLocaleString();
                            } else {
                                stat.textContent = finalValue;
                            }
                        }
                    };
                    
                    setTimeout(updateCounter, 500);
                }
            });
        });

        // Simulación de carga de facturas (reemplazar con AJAX real)
        function verDetallesFactura(id) {
            alert(`Mostrando detalles de factura #${id}\nEsta función se conectaría a tu backend.`);
        }

        function pagarFactura(id) {
            if(confirm('¿Confirmar pago de esta factura?')) {
                alert(`Pago procesado para factura #${id}\nRedirigiendo a pasarela de pago...`);
                // Aquí iría la integración con pasarela de pago
            }
        }
    </script>
</body>
</html>