<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">
    <title>Acceso al Sistema | Unienergia</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(160deg, #0f172a, #1e3a8a);
        }

        /* ===== PANEL IZQUIERDO ===== */
        .left-panel {
            width: 50%;
            color: #ffffff;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel img {
            width: 180px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 0 12px rgba(59,130,246,.55));
        }

        .left-panel h1 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .left-panel p {
            font-size: 1rem;
            line-height: 1.6;
            color: #c7d2fe;
            max-width: 420px;
        }

        .features {
            margin-top: 2.5rem;
        }

        .features li {
            margin-bottom: 0.8rem;
            list-style: none;
            font-size: 0.95rem;
            color: #e0e7ff;
        }

        .features li::before {
            content: "✓";
            color: #38bdf8;
            margin-right: 0.5rem;
        }

        /* ===== PANEL DERECHO ===== */
        .right-panel {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        /* ===== LIQUID GLASS LOGIN ===== */
        .login-box {
            width: 100%;
            max-width: 380px;
            padding: 2.6rem;
            border-radius: 20px;

            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, 0.35);

            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.55),
                inset 0 1px 1px rgba(255, 255, 255, 0.35);
        }

        .login-box h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #f8fafc;
            margin-bottom: 0.3rem;
        }

        .login-box span {
            font-size: 0.9rem;
            color: #cbd5f5;
        }

        label {
            display: block;
            margin-top: 1.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e5e7eb;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            margin-top: 0.3rem;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.9);
            transition: border 0.2s, box-shadow 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.45);
        }

        .options {
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #e5e7eb;
        }

        .options a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: 600;
        }

        button {
            margin-top: 1.8rem;
            width: 100%;
            padding: 0.9rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
        }

        button:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-1px);
        }

        .alert {
            margin-top: 1rem;
            padding: 0.6rem 0.8rem;
            border-radius: 10px;
            font-size: 0.8rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.3);
            color: #dcfce7;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.3);
            color: #fee2e2;
        }

        /* ===== FOOTER ===== */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 0.7rem;
            color: #cbd5f5;
            padding: 0.6rem 0;
            background: rgba(2, 6, 23, 0.85);
            backdrop-filter: blur(6px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100%;
            }

            .left-panel {
                padding: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">
        <img src="{{ asset('img/logo1.png') }}" alt="Unienergia">

        <h1>Sistema Integrado Administrativo</h1>
        <p>
            Plataforma centralizada para la gestión de trámites, documentos
            administrativos y control institucional.
        </p>

        <ul class="features">
            <li>Gestión de requerimientos</li>
            <li>Control de cartas y documentos</li>
            <li>Seguimiento administrativo</li>
            <li>Módulo logístico (próximamente)</li>
        </ul>
    </div>

    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <div class="login-box">

            <h2>Acceso al sistema</h2>
            <span>Ingrese sus credenciales</span>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left:1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>

                <div class="options">
                    <label>
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>

                <button type="submit">Ingresar</button>
            </form>

        </div>
    </div>

    <footer>
        © {{ date('Y') }} Empresa de Recursos Energéticos SAC — Todos los derechos reservados
    </footer>

</body>
</html>
<link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">