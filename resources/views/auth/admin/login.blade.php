<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Iniciar Sesión</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login.auth') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="current-password">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Recordarme</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">¿Olvidaste tu
                                    contraseña?</a>
                            @endif
                        </form>
                        @if (session('error'))
                            <div class="alert alert-danger mt-4">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('mensaje-logout'))
                            <div class="alert alert-danger mt-4">
                                {{ session('mensaje-logout') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
