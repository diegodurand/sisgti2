<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo-vt.svg') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SISGTI Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('{{ asset('images/fondo.jpeg') }}');
            background-size: cover; /* La imagen cubrirá todo el fondo */
            background-position: center; /* La imagen se centrará en la pantalla */
            background-repeat: no-repeat; /* Evitará que la imagen se repita */
            background-attachment: fixed; /* Hace que la imagen de fondo permanezca fija mientras se desplaza */
        }
        .login-container {
            width: 25rem;
        }
        .login-logo {
            height: 7rem;
        }
        .input-icon {
            height: 1rem;
        }
        .btn-login {
            width: 100%;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="login-container bg-white p-5 rounded-5 text-secondary shadow">
            <div class="d-flex justify-content-center">
                <img
                    src="{{ asset('images/logosalle1.png') }}"
                    alt="login-icon"
                    class="login-logo"
                />
            </div>
            <!-- Usuario -->
            <div class="input-group mt-4">
                <div class="input-group-text bg-info">
                    <i class="bi bi-person text-white"></i>
                </div>
                <input
                    id="email"
                    class="form-control bg-light"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Usuario"
                />
            </div>
            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
            
            <!-- Contraseña -->
            <div class="input-group mt-3">
                <div class="input-group-text bg-info">
                    <i class="bi bi-key text-white"></i>
                </div>
                <input
                    id="password"
                    class="form-control bg-light"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Contraseña"
                />
            </div>
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            <!-- Botón de Login -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-info text-white btn-login">
                    Login
                </button>
            </div>
        </div>
    </form>
</body>
</html>
