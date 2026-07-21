<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear cuenta | Unienergia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .auth-card {
            max-width: 420px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-gray {
            color: #555;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 4px;
        }

        .input-hint {
            font-size: 12px;
            color: #888;
            margin-bottom: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #3c8dbc;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #367fa9;
        }

        .errors {
            background-color: #ffe0e0;
            border: 1px solid #f7a0a0;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="80">
            </a>
        </div>

        <div class="text-gray">
            Crea tu cuenta con tu correo institucional. Un administrador deberá asignarte un rol antes de que puedas
            acceder a los módulos del sistema.
        </div>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label class="input-label" for="name">Nombre completo</label>
                <input id="name" class="input-field" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div>
                <label class="input-label" for="email">Correo institucional</label>
                <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" placeholder="nombre.apellido@unienergia.pe" required>
                <div class="input-hint">Solo se admiten correos con dominio @unienergia.pe</div>
            </div>

            <div>
                <label class="input-label" for="password">Contraseña</label>
                <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password">
            </div>

            <div>
                <label class="input-label" for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required>
            </div>

            <div style="margin-top:12px;">
                <button type="submit" class="btn-submit">
                    Crear cuenta
                </button>
            </div>
        </form>

        <div style="text-align:center; margin-top:16px;">
            <a href="{{ route('login') }}" style="font-size:13px; color:#3c8dbc;">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>

</body>
</html>
