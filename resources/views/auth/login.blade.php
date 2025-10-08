<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tienda Virtual</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 420px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #444;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .input-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            user-select: none;
            color: #666;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-check input {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
                border-radius: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">{{ __('Dirección de Correo Electrónico') }}</label>
            <div class="input-group">
                <input id="email" type="email"
                    class="@error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <label for="password">{{ __('Contraseña') }}</label>
            <div class="input-group">
                <input id="password" type="password"
                    class="@error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Recordarme') }}
                </label>
            </div>

            <button type="submit" class="btn-primary">
                {{ __('Iniciar Sesión') }}
            </button>

            @if (Route::has('password.request'))
            <a class="btn-link" href="{{ route('password.request') }}">
                {{ __('Se olvidó su contraseña?') }}
            </a>
            @endif
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</body>

</html>