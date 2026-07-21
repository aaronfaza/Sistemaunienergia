<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .auth-card {
            max-width: 400px;
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
            margin-bottom: 16px;
            letter-spacing: normal;
        }

        .input-codigo {
            text-align: center;
            font-size: 22px;
            letter-spacing: 8px;
            font-weight: bold;
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

        .status, .errors {
            background-color: #e0f3ff;
            border: 1px solid #a0d4f7;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 4px;
            font-size: 14px;
        }

        .errors {
            background-color: #ffe0e0;
            border-color: #f7a0a0;
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
            Ingresa el código de 6 dígitos que enviamos a tu correo de recuperación, junto con tu nueva contraseña.
        </div>

        @if (session('status'))
            <div class="status">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div>
                <label class="input-label" for="email">Correo institucional</label>
                <input id="email" class="input-field" type="email" name="email" value="{{ old('email', $email) }}" required autofocus>
            </div>

            <div>
                <label class="input-label" for="codigo">Código de 6 dígitos</label>
                <input id="codigo" class="input-field input-codigo" type="text" name="codigo" inputmode="numeric" maxlength="6" pattern="\d{6}" value="{{ old('codigo') }}" required>
            </div>

            <div>
                <label class="input-label" for="password">Nueva contraseña</label>
                <input id="password" class="input-field" type="password" name="password" required>
            </div>

            <div>
                <label class="input-label" for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required>
            </div>

            <div>
                <button type="submit" class="btn-submit">
                    Restablecer contraseña
                </button>
            </div>
        </form>

        <div style="text-align:center; margin-top:16px;">
            <a href="{{ route('password.request') }}" style="font-size:13px; color:#3c8dbc;">¿No recibiste el código? Solicitar de nuevo</a>
        </div>
    </div>

</body>
</html>
