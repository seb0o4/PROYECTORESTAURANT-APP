<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: rgba(33, 37, 41, 0.9) !important;
            backdrop-filter: blur(10px);
        }
        
        .welcome-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            margin-top: 2rem;
            backdrop-filter: blur(10px);
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1b5e20, #388e3c);
        }
        
        .btn-outline-primary {
            color: #2e7d32;
            border: 2px solid #2e7d32;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: #2e7d32;
            border-color: #2e7d32;
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(46, 125, 50, 0.3);
        }
        
        .restaurant-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: block;
        }
        
        h1 {
            color: #1b5e20;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .lead {
            color: #4e4e4e;
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .feature-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .feature-item {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            padding: 15px;
            margin: 10px;
            width: 150px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }
        
        .footer {
            margin-top: 3rem;
            color: white;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="font-size: 1.5rem;">🍽️</span> Restaurante App
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="welcome-card text-center">
                    <span class="restaurant-icon">🍽️</span>
                     <h1>Bienvenidos</h1>
                    <h1>"EL RINCON QUE NO CONOCES"</h1>
                    <p class="lead">Disfruta de una experiencia culinaria única con nuestro sistema de gestión de restaurante</p>
                    
                    <div class="mt-4 mb-5">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrarse</a>
                    </div>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <span class="feature-icon">📋</span>
                            <div>Menú Digital</div>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🛒</span>
                            <div>Pedidos Online</div>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📅</span>
                            <div>Reservas</div>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🚚</span>
                            <div>Delivery</div>
                        </div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>© 2025 Sistema de Restaurante. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>