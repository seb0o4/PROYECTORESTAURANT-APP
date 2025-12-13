<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Restaurante</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        /* LADO IZQUIERDO */
        .image-side {
            background: linear-gradient(
                135deg,
                #f9a825 0%,
                #f57f17 45%,
                #fbc02d 100%
            );
            position: relative;
        }

        .image-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
        }

        .image-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 3rem;
        }

        .image-content h1 {
            font-size: 3rem;
            font-weight: 800;
        }

        .image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* LADO DERECHO */
        .login-container {
            background: #fffaf2;
            height: 100vh;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
        }

        .login-card h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
        }

        .btn-login {
            background: #7cb342;
            color: white;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #558b2f;
        }

        .social-btn {
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .social-btn:hover {
            background: #f1f1f1;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: '';
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #ddd;
            vertical-align: middle;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        .forgot {
            font-size: 0.9rem;
            color: #7cb342;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- IZQUIERDA -->
        <div class="col-md-6 d-none d-md-flex align-items-center image-side">
            <div class="image-content">
                <h1>BINE AI REVENIT!</h1>
                <p>Disfruta de la mejor experiencia gastronómica desde nuestra plataforma.</p>
            </div>
        </div>

        <!-- DERECHA -->
        <div class="col-md-6 d-flex align-items-center justify-content-center login-container">
            <div class="login-card">

                <h2 class="text-center">Iniciar Sesión</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="E-mail"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Contraseña"
                               required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mb-3">
                        <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Login
                    </button>
                </form>

                <div class="divider">Sau</div>

                <div class="d-grid gap-2">
                    <button class="social-btn">🔵 Facebook</button>
                    <button class="social-btn">🟥 Google</button>
                </div>

                <div class="text-center mt-4">
                    <small>
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="forgot">Inscríbete</a>
                    </small>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
