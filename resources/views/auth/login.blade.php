<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #444;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .actions label {
            font-size: 0.9rem;
        }

        .actions a {
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        button {
            width: 100%;
            background-color: #4f46e5;
            color: white;
            padding: 0.7rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div style="text-align: center; margin-bottom: 1rem;">
        <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="max-width: 100px;">
    </div>
        <h2>Iniciar sesión</h2>

        @if (session('status'))
            <div style="color: green; margin-bottom: 1rem;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <div class="actions">
                <label><input type="checkbox" name="remember"> Recordarme</label>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
