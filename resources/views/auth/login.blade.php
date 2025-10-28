<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
        }
        
        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: none;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 1.5rem;
            text-align: center;
        }
        
        .card-header h4 {
            margin: 0;
            font-weight: 700;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
            width: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1b5e20, #388e3c);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #424242;
            margin-bottom: 8px;
        }
        
        .invalid-feedback {
            font-weight: 500;
        }
        
        .login-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .register-link {
            color: #2e7d32;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link:hover {
            color: #1b5e20;
            text-decoration: underline;
        }
        
        .navbar {
            background-color: rgba(33, 37, 41, 0.9) !important;
            backdrop-filter: blur(10px);
            position: absolute;
            top: 0;
            width: 100%;
        }
        
        .form-section {
            padding: 2rem;
        }
        
        .form-check-input:checked {
            background-color: #4caf50;
            border-color: #4caf50;
        }
        
        .form-check-label {
            color: #424242;
            font-weight: 500;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="card-header">
                        <span class="login-icon">🔐</span>
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="form-section">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="ejemplo@correo.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 password-toggle">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       placeholder="Ingresa tu contraseña" required>
                                <span class="password-toggle-icon" onclick="togglePassword()">👁️</span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Recordar sesión</label>
                                </div>
                                <a href="#" class="register-link" style="font-size: 0.9rem;">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                <span style="font-size: 1.1rem; margin-right: 8px;">→</span>
                                Iniciar Sesión
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('register') }}" class="register-link">
                                <span style="margin-right: 5px;">📝</span>
                                ¿No tienes cuenta? Regístrate aquí
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <small style="color: white;">
                        © 2025 Sistema de Restaurante. Todos los derechos reservados.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
        
        // Efecto de carga suave
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>