<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">
    <title>Acceso al Sistema | Unienergia</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        html, body {
            margin: 0;
            height: 100%;
            overflow-x: hidden;
        }

        body {
            min-height: 100vh;
            display: flex;
            position: relative;
            background: #0f172a;
        }

        /* ===================================================
           ESCENA DE FONDO: CAMPO PETROLERO (a pantalla completa)
           =================================================== */
        .oilfield-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;

            /* Valores por defecto (medianoche); el script los recalcula según la hora real */
            --sky-top: rgb(11,17,32);
            --sky-mid: rgb(22,38,79);
            --sky-bottom: rgb(30,58,138);
            --sun-op: 0;
            --moon-op: 1;
            --stars-op: .9;
            --horizon-color: 251,146,60;
            --horizon-op: .18;

            background: linear-gradient(160deg, var(--sky-top) 0%, var(--sky-mid) 45%, var(--sky-bottom) 100%);
            background-size: 140% 140%;
            animation: skyDrift 18s ease-in-out infinite;
            transition: background 4s linear;
        }

        @keyframes skyDrift {
            0%, 100% { background-position: 0% 0%; }
            50%      { background-position: 60% 40%; }
        }

        .oilfield-scene .stars-wrap {
            position: absolute;
            inset: 0;
            opacity: var(--stars-op);
            transition: opacity 4s linear;
        }

        .oilfield-scene .stars {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1.6px 1.6px at 8% 18%, rgba(255,255,255,.7), transparent),
                radial-gradient(1.2px 1.2px at 18% 32%, rgba(255,255,255,.45), transparent),
                radial-gradient(1.4px 1.4px at 27% 12%, rgba(255,255,255,.55), transparent),
                radial-gradient(1px 1px at 38% 26%, rgba(255,255,255,.4), transparent),
                radial-gradient(1.6px 1.6px at 47% 8%, rgba(255,255,255,.6), transparent),
                radial-gradient(1px 1px at 58% 20%, rgba(255,255,255,.35), transparent),
                radial-gradient(1.4px 1.4px at 68% 14%, rgba(255,255,255,.55), transparent),
                radial-gradient(1px 1px at 77% 30%, rgba(255,255,255,.4), transparent),
                radial-gradient(1.6px 1.6px at 86% 10%, rgba(255,255,255,.6), transparent),
                radial-gradient(1.2px 1.2px at 93% 22%, rgba(255,255,255,.45), transparent);
            background-repeat: no-repeat;
            animation: twinkle 4s ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: .55; }
            50%      { opacity: 1; }
        }

        .oilfield-scene .moon {
            position: absolute;
            top: 8%;
            right: 12%;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #fef9c3, #fde68a 55%, rgba(253,230,138,.15) 75%);
            box-shadow: 0 0 60px 18px rgba(253,230,138,.35);
            opacity: var(--moon-op);
            animation: moonGlow 6s ease-in-out infinite;
            transition: opacity 4s linear;
        }

        @keyframes moonGlow {
            0%, 100% { box-shadow: 0 0 60px 18px rgba(253,230,138,.30); }
            50%      { box-shadow: 0 0 80px 26px rgba(253,230,138,.5); }
        }

        .oilfield-scene .sun {
            position: absolute;
            top: 8%;
            right: 12%;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #fffbeb, #fde047 55%, rgba(250,204,21,.2) 78%);
            box-shadow: 0 0 70px 22px rgba(250,204,21,.45);
            opacity: var(--sun-op);
            animation: sunGlow 5s ease-in-out infinite;
            transition: opacity 4s linear;
        }

        @keyframes sunGlow {
            0%, 100% { box-shadow: 0 0 70px 22px rgba(250,204,21,.4); }
            50%      { box-shadow: 0 0 95px 30px rgba(250,204,21,.65); }
        }

        .oilfield-scene .cloud {
            position: absolute;
            background: rgba(203,213,245,.14);
            border-radius: 999px;
            filter: blur(1px);
        }

        .cloud-1 { width: 220px; height: 46px; top: 14%; left: -260px; animation: driftCloud 38s linear infinite; }
        .cloud-2 { width: 160px; height: 34px; top: 24%; left: -220px; animation: driftCloud 52s linear infinite; animation-delay: -14s; opacity:.7; }
        .cloud-3 { width: 260px; height: 50px; top: 8%;  left: -300px; animation: driftCloud 65s linear infinite; animation-delay: -30s; opacity:.55; }

        @keyframes driftCloud {
            from { transform: translateX(0); }
            to   { transform: translateX(calc(100vw + 320px)); }
        }

        .oilfield-scene .horizon-glow {
            position: absolute;
            left: 0; right: 0;
            bottom: 18vh;
            height: 34vh;
            background: radial-gradient(60% 100% at 50% 100%, rgba(var(--horizon-color), var(--horizon-op)), rgba(var(--horizon-color), 0) 70%);
            pointer-events: none;
            transition: background 4s linear;
        }

        .oilfield-scene .ground {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 18vh;
            background: linear-gradient(180deg, #131f36, #060a14);
            border-top: 1px solid rgba(148,163,184,.25);
        }

        .oilfield-scene .ground::before {
            content: "";
            position: absolute;
            left: 0; right: 0; top: -2px;
            height: 2px;
            background: repeating-linear-gradient(90deg, rgba(96,165,250,.35) 0 24px, transparent 24px 48px);
        }

        .rig-layer {
            position: absolute;
            left: 0;
            bottom: 18vh;
            width: 100%;
            height: 46vh;
            overflow: visible;
        }

        .rig-layer svg {
            position: absolute;
            bottom: 0;
            overflow: visible;
        }

        /* --- Pumpjacks de fondo (parallax, más pequeños y tenues) --- */
        .pumpjack-bg { opacity: .4; filter: saturate(.7); }
        .pumpjack-bg .beam-group { animation-duration: 4.4s; }
        .pumpjack-bg .crank { animation-duration: 4.4s; }
        .pumpjack-bg .pitman { animation-duration: 4.4s; }

        /* --- Unidad de bombeo (pumpjack) — animación --- */
        .pumpjack .beam-group {
            transform-box: fill-box;
            transform-origin: 50% 50%;
            animation: beamRock 3.2s ease-in-out infinite;
        }

        @keyframes beamRock {
            0%   { transform: rotate(-12deg); }
            50%  { transform: rotate(12deg); }
            100% { transform: rotate(-12deg); }
        }

        .pumpjack .crank {
            transform-box: fill-box;
            transform-origin: 50% 50%;
            animation: crankSpin 3.2s linear infinite;
        }

        @keyframes crankSpin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .pumpjack .pitman {
            animation: pitmanShift 3.2s ease-in-out infinite;
        }

        @keyframes pitmanShift {
            0%   { transform: translateY(4px); }
            50%  { transform: translateY(-4px); }
            100% { transform: translateY(4px); }
        }

        .pumpjack .oil-drop {
            opacity: 0;
            animation: dropFall 3.2s ease-in infinite;
        }

        @keyframes dropFall {
            0%   { opacity: 0; transform: translateY(0); }
            5%   { opacity: 1; }
            35%  { opacity: 1; transform: translateY(18px); }
            40%  { opacity: 0; transform: translateY(20px); }
            100% { opacity: 0; transform: translateY(0); }
        }

        /* --- Torre de perforación decorativa --- */
        .derrick { opacity: .5; }
        .derrick .blinker {
            animation: blinkLight 1.6s ease-in-out infinite;
        }
        @keyframes blinkLight {
            0%, 100% { opacity: .2; }
            50%      { opacity: 1; }
        }

        /* --- Mechero / flare stack con llama --- */
        .flare-flame {
            transform-box: fill-box;
            transform-origin: 50% 100%;
            animation: flicker 1.1s ease-in-out infinite;
        }
        @keyframes flicker {
            0%   { transform: scale(1, 1) translateX(0); opacity: .9; }
            30%  { transform: scale(1.08, 1.16) translateX(1px); opacity: 1; }
            60%  { transform: scale(.94, .9) translateX(-1px); opacity: .85; }
            100% { transform: scale(1, 1) translateX(0); opacity: .9; }
        }

        /* --- Trabajador petrolero --- */
        .worker {
            animation: workerIdle 2.6s ease-in-out infinite;
            transform-box: fill-box;
            transform-origin: 50% 100%;
        }

        @keyframes workerIdle {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-3px) rotate(-.6deg); }
        }

        .worker .arm-wave {
            transform-box: fill-box;
            transform-origin: 100% 0%;
            animation: armWave 2.6s ease-in-out infinite;
        }

        @keyframes armWave {
            0%, 100%  { transform: rotate(0deg); }
            25%, 45%  { transform: rotate(-32deg); }
            60%       { transform: rotate(-10deg); }
        }

        .worker .head {
            transform-box: fill-box;
            transform-origin: 50% 100%;
            animation: headLook 5.2s ease-in-out infinite;
        }

        @keyframes headLook {
            0%, 60%, 100% { transform: rotate(0deg); }
            75%            { transform: rotate(8deg); }
            88%            { transform: rotate(-6deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .oilfield-scene,
            .oilfield-scene *,
            .pumpjack .beam-group,
            .pumpjack .crank,
            .pumpjack .pitman,
            .pumpjack .oil-drop,
            .flare-flame,
            .worker,
            .worker .arm-wave,
            .worker .head,
            .cloud,
            .stars {
                animation: none !important;
            }
        }

        /* ===================================================
           CONTENIDO (flota sobre la escena)
           =================================================== */
        .left-panel {
            position: relative;
            z-index: 1;
            width: 55%;
            color: #ffffff;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 6vh;
        }

        .left-panel::before {
            content: "";
            position: absolute;
            inset: -1rem -2rem;
            background: linear-gradient(100deg, rgba(8,13,26,.55) 0%, rgba(8,13,26,.28) 55%, rgba(8,13,26,0) 85%);
            z-index: -1;
            border-radius: 24px;
        }

        .left-panel img {
            width: 160px;
            margin-bottom: 1.6rem;
            filter: drop-shadow(0 0 12px rgba(59,130,246,.55));
        }

        .left-panel h1 {
            font-size: 2.1rem;
            font-weight: 700;
            margin-bottom: .8rem;
            text-shadow: 0 2px 12px rgba(0,0,0,.4);
        }

        .left-panel p {
            font-size: 1rem;
            line-height: 1.6;
            color: #dbe3ff;
            max-width: 420px;
            text-shadow: 0 1px 8px rgba(0,0,0,.4);
        }

        .features {
            margin-top: 1.6rem;
            padding: 0;
        }

        .features li {
            margin-bottom: 0.7rem;
            list-style: none;
            font-size: 0.95rem;
            color: #eef2ff;
            text-shadow: 0 1px 6px rgba(0,0,0,.45);
        }

        .features li::before {
            content: "✓";
            color: #38bdf8;
            margin-right: 0.5rem;
        }

        /* Empuja el resto hacia abajo para que la escena respire debajo del texto */
        .scene-spacer {
            flex: 1 1 auto;
            min-height: 8vh;
        }

        /* ===== PANEL DERECHO ===== */
        .right-panel {
            position: relative;
            z-index: 1;
            width: 45%;
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

            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

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
            z-index: 2;
            text-align: center;
            font-size: 0.7rem;
            color: #cbd5f5;
            padding: 0.6rem 0;
            background: rgba(2, 6, 23, 0.75);
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
                padding: 2rem;
                padding-top: 4vh;
            }

            .oilfield-scene { opacity: .85; }
        }
    </style>
</head>

<body>

    <!-- ===== ESCENA DE FONDO: CAMPO PETROLERO (pantalla completa) ===== -->
    <div class="oilfield-scene" aria-hidden="true">
        <div class="stars-wrap"><div class="stars"></div></div>
        <div class="moon"></div>
        <div class="sun"></div>
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="horizon-glow"></div>

        <div class="rig-layer">
            <!-- Torre de perforación decorativa (fondo, izquierda) -->
            <svg class="derrick" viewBox="10 0 80 200" preserveAspectRatio="xMidYMax meet" style="left:3%; width:80px;">
                <g stroke="#93c5fd" stroke-width="2.4" fill="none" stroke-linecap="round">
                    <line x1="20" y1="200" x2="50" y2="10" />
                    <line x1="80" y1="200" x2="50" y2="10" />
                    <line x1="26" y1="150" x2="74" y2="150" />
                    <line x1="32" y1="105" x2="68" y2="105" />
                    <line x1="38" y1="60"  x2="62" y2="60" />
                </g>
                <circle class="blinker" cx="50" cy="8" r="3" fill="#f87171" />
            </svg>

            <!-- Pumpjack de fondo #1 -->
            <svg class="pumpjack pumpjack-bg" viewBox="150 25 190 110" preserveAspectRatio="xMidYMax meet" style="left:15%; width:190px;">
                <g stroke="#cbd5f5" stroke-width="4" fill="none" stroke-linecap="round">
                    <line x1="205" y1="120" x2="230" y2="60" />
                    <line x1="255" y1="120" x2="230" y2="60" />
                    <line x1="214" y1="92" x2="246" y2="92" />
                </g>
                <rect x="222" y="112" width="16" height="14" rx="2" fill="#334155" />
                <line class="pitman" x1="230" y1="60" x2="230" y2="112" stroke="#94a3b8" stroke-width="3" />
                <g class="beam-group">
                    <g transform="translate(230,60)">
                        <rect x="-70" y="-8" width="34" height="16" rx="3" fill="#1d4ed8" />
                        <rect x="-70" y="-4" width="140" height="8" rx="4" fill="#cbd5f5" />
                        <path d="M 70 -4 C 92 -4, 96 -16, 84 -22 C 78 -25, 70 -22, 66 -14 L 60 -4 Z" fill="#cbd5f5" />
                    </g>
                </g>
                <circle cx="230" cy="60" r="4" fill="#1e293b" stroke="#cbd5f5" stroke-width="2" />
                <rect x="182" y="104" width="26" height="16" rx="3" fill="#334155" />
                <circle class="crank" cx="196" cy="104" r="10" fill="none" stroke="#38bdf8" stroke-width="3" />
            </svg>

            <!-- Mechero (flare stack) -->
            <svg class="flare" viewBox="0 -15 60 215" preserveAspectRatio="xMidYMax meet" style="left:35%; width:42px;">
                <line x1="30" y1="200" x2="30" y2="30" stroke="#94a3b8" stroke-width="4" stroke-linecap="round" />
                <line x1="30" y1="160" x2="46" y2="160" stroke="#94a3b8" stroke-width="3" stroke-linecap="round" />
                <path class="flare-flame" d="M 30 30 C 22 18, 24 6, 30 -4 C 36 6, 40 16, 30 30 Z" fill="url(#flameGrad)" />
                <defs>
                    <linearGradient id="flameGrad" x1="0" y1="1" x2="0" y2="0">
                        <stop offset="0%" stop-color="#f97316" />
                        <stop offset="55%" stop-color="#fb923c" />
                        <stop offset="100%" stop-color="#fde68a" />
                    </linearGradient>
                </defs>
            </svg>

            <!-- Pumpjack principal (primer plano, protagonista) -->
            <svg class="pumpjack" viewBox="150 25 190 110" preserveAspectRatio="xMidYMax meet" style="left:54%; width:360px;">
                <g stroke="#e0e7ff" stroke-width="4" fill="none" stroke-linecap="round">
                    <line x1="205" y1="120" x2="230" y2="60" />
                    <line x1="255" y1="120" x2="230" y2="60" />
                    <line x1="214" y1="92" x2="246" y2="92" />
                </g>

                <rect x="222" y="112" width="16" height="14" rx="2" fill="#334155" />

                <circle class="oil-drop" cx="230" cy="122" r="2.5" fill="#0ea5e9" />

                <line class="pitman" x1="230" y1="60" x2="230" y2="112" stroke="#cbd5f5" stroke-width="3" />

                <g class="beam-group">
                    <g transform="translate(230,60)">
                        <rect x="-70" y="-8" width="34" height="16" rx="3" fill="#2563eb" />
                        <rect x="-70" y="-4" width="140" height="8" rx="4" fill="#e0e7ff" />
                        <path d="M 70 -4 C 92 -4, 96 -16, 84 -22 C 78 -25, 70 -22, 66 -14 L 60 -4 Z" fill="#e0e7ff" />
                    </g>
                </g>

                <circle cx="230" cy="60" r="4.5" fill="#1e293b" stroke="#e0e7ff" stroke-width="2" />

                <rect x="180" y="102" width="30" height="18" rx="3" fill="#334155" />
                <circle class="crank" cx="195" cy="103" r="11" fill="none" stroke="#38bdf8" stroke-width="3" />
                <circle cx="195" cy="103" r="2.5" fill="#38bdf8" />
            </svg>

            <!-- Trabajador con casco (primer plano) -->
            <svg class="worker" viewBox="170 65 70 90" preserveAspectRatio="xMidYMax meet" style="left:46%; width:100px;">
                <g transform="translate(200,84)">
                    <line x1="-4" y1="34" x2="-6" y2="54" stroke="#1e3a8a" stroke-width="7" stroke-linecap="round" />
                    <line x1="4" y1="34" x2="6" y2="54" stroke="#1e3a8a" stroke-width="7" stroke-linecap="round" />

                    <rect x="-10" y="8" width="20" height="28" rx="6" fill="#f59e0b" />
                    <line x1="-10" y1="19" x2="10" y2="19" stroke="#fff7ed" stroke-width="2.4" />

                    <line x1="-10" y1="14" x2="-18" y2="30" stroke="#f59e0b" stroke-width="5.5" stroke-linecap="round" />

                    <g class="arm-wave">
                        <line x1="10" y1="14" x2="20" y2="-4" stroke="#f59e0b" stroke-width="5.5" stroke-linecap="round" />
                    </g>

                    <g class="head">
                        <circle cx="0" cy="0" r="8" fill="#fcd9b8" />
                        <path d="M -9 -2 A 9 9 0 0 1 9 -2 Z" fill="#fbbf24" />
                        <rect x="-10" y="-3" width="20" height="3.4" rx="1.7" fill="#f59e0b" />
                    </g>
                </g>
            </svg>
        </div>

        <div class="ground"></div>
    </div>

    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">
        <img src="{{ asset('img/Logo1.png') }}" alt="Unienergia">

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

        <div class="scene-spacer"></div>
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

    <!-- ===== Ciclo día/atardecer/noche según la hora local del navegador ===== -->
    <script>
        (function () {
            var scene = document.querySelector('.oilfield-scene');
            if (!scene) return;

            // Paletas clave del ciclo (hora decimal 0–24). Entre cada par de
            // puntos se interpola suavemente, así el atardecer/amanecer van
            // cambiando en vez de saltar de golpe entre día y noche.
            var KEYFRAMES = [
                { h: 0,    sky: [[11,17,32],  [22,38,79],   [30,58,138]],  sunOp: 0,   moonOp: 1,   starsOp: .9, horizon: [251,146,60],  horizonOp: .18 },
                { h: 5,    sky: [[11,17,32],  [22,38,79],   [30,58,138]],  sunOp: 0,   moonOp: 1,   starsOp: .9, horizon: [251,146,60],  horizonOp: .18 },
                { h: 6.5,  sky: [[30,58,138], [249,115,22], [253,230,138]], sunOp: .55, moonOp: .35, starsOp: .3, horizon: [251,146,60],  horizonOp: .42 },
                { h: 8,    sky: [[56,189,248],[125,211,252],[186,230,253]], sunOp: 1,   moonOp: 0,   starsOp: 0,  horizon: [253,224,71],  horizonOp: .2 },
                { h: 17,   sky: [[56,189,248],[125,211,252],[186,230,253]], sunOp: 1,   moonOp: 0,   starsOp: 0,  horizon: [253,224,71],  horizonOp: .2 },
                { h: 18.5, sky: [[49,46,129], [249,115,22], [253,230,138]], sunOp: .5,  moonOp: .35, starsOp: .3, horizon: [251,113,133], horizonOp: .48 },
                { h: 20,   sky: [[11,17,32],  [22,38,79],   [30,58,138]],  sunOp: 0,   moonOp: 1,   starsOp: .9, horizon: [251,146,60],  horizonOp: .18 },
                { h: 24,   sky: [[11,17,32],  [22,38,79],   [30,58,138]],  sunOp: 0,   moonOp: 1,   starsOp: .9, horizon: [251,146,60],  horizonOp: .18 }
            ];

            function lerp(a, b, t) { return a + (b - a) * t; }
            function lerpColor(a, b, t) {
                return [
                    Math.round(lerp(a[0], b[0], t)),
                    Math.round(lerp(a[1], b[1], t)),
                    Math.round(lerp(a[2], b[2], t))
                ];
            }

            function calcular(horaDecimal) {
                var actual = KEYFRAMES[0];
                var siguiente = KEYFRAMES[KEYFRAMES.length - 1];

                for (var i = 0; i < KEYFRAMES.length - 1; i++) {
                    if (horaDecimal >= KEYFRAMES[i].h && horaDecimal <= KEYFRAMES[i + 1].h) {
                        actual = KEYFRAMES[i];
                        siguiente = KEYFRAMES[i + 1];
                        break;
                    }
                }

                var rango = siguiente.h - actual.h;
                var t = rango > 0 ? (horaDecimal - actual.h) / rango : 0;

                return {
                    skyTop: lerpColor(actual.sky[0], siguiente.sky[0], t),
                    skyMid: lerpColor(actual.sky[1], siguiente.sky[1], t),
                    skyBottom: lerpColor(actual.sky[2], siguiente.sky[2], t),
                    sunOp: lerp(actual.sunOp, siguiente.sunOp, t),
                    moonOp: lerp(actual.moonOp, siguiente.moonOp, t),
                    starsOp: lerp(actual.starsOp, siguiente.starsOp, t),
                    horizon: lerpColor(actual.horizon, siguiente.horizon, t),
                    horizonOp: lerp(actual.horizonOp, siguiente.horizonOp, t)
                };
            }

            function aplicar() {
                var ahora = new Date();
                var horaDecimal = ahora.getHours() + ahora.getMinutes() / 60;
                var v = calcular(horaDecimal);

                scene.style.setProperty('--sky-top', 'rgb(' + v.skyTop.join(',') + ')');
                scene.style.setProperty('--sky-mid', 'rgb(' + v.skyMid.join(',') + ')');
                scene.style.setProperty('--sky-bottom', 'rgb(' + v.skyBottom.join(',') + ')');
                scene.style.setProperty('--sun-op', v.sunOp);
                scene.style.setProperty('--moon-op', v.moonOp);
                scene.style.setProperty('--stars-op', v.starsOp);
                scene.style.setProperty('--horizon-color', v.horizon.join(','));
                scene.style.setProperty('--horizon-op', v.horizonOp);
            }

            aplicar();
            setInterval(aplicar, 60000); // recalcula cada minuto para reflejar el paso real del tiempo
        })();
    </script>

</body>
</html>
