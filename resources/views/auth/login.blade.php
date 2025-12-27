<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión - Unienergia</title>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        padding: 2.5rem;
        border-radius: 16px;
        width: 100%;
        max-width: 380px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #1e293b;
        font-size: 1.5rem;
    }

    .login-container img {
        max-width: 180px;
        margin-bottom: 1rem;
    }

    label {
        display: block;
        margin-bottom: 0.3rem;
        color: #374151;
        font-weight: 500;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        margin-bottom: 1rem;
        outline: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 6px rgba(79, 70, 229, 0.3);
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .actions label {
        color: #475569;
    }

    .actions a {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 500;
    }

    .actions a:hover {
        text-decoration: underline;
    }

    button {
        width: 100%;
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        color: white;
        padding: 0.8rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #4338ca, #2563eb);
        transform: scale(1.02);
    }

    /* Mensajes de error y éxito */
    .alert {
        padding: 0.8rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

      footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #1f2937;
        color: #e5e7eb;
        text-align: center;
        padding: 0.8rem 0;
        font-size: 0.85rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

</style>
</head>
<body>
    <div class="login-container">
        <div style="text-align: center;">
            <img src="{{ asset('img/logo1.png') }}" alt="Logo">
        </div>
        <h2>Iniciar Sesión</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:1.2rem;">
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
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </div>
     <footer>
        © {{ date('Y') }} Empresa de Recursos Energéticos SAC - Todos los derechos reservados
    </footer>
</body>
</html>
