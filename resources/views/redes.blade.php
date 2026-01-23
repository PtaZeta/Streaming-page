<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Redes - PtaZet4</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2" id="favicon">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* Animación de fondo con partículas */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 2px, transparent 2px);
            background-size: 50px 50px;
            animation: particleMove 20s linear infinite;
            z-index: 0;
        }

        @keyframes particleMove {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Header */
        header {
            position: relative;
            z-index: 100;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 25px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(99, 102, 241, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 15px;
        }

        header a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        header a:hover {
            color: #93c5fd;
            transform: translateY(-2px);
        }

        header a:hover::after {
            width: 100%;
        }

        /* Contenedor principal */
        .container {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        /* Título principal */
        .main-title {
            text-align: center;
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: titleFloat 3s ease-in-out infinite;
            text-shadow: 0 0 40px rgba(99, 102, 241, 0.5);
        }

        @keyframes titleFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #cbd5e1;
            margin-bottom: 60px;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Grid de redes sociales */
        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        /* Tarjeta de red social */
        .social-card {
            position: relative;
            background: linear-gradient(135deg, rgba(30, 27, 75, 0.9), rgba(15, 23, 42, 0.95));
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(99, 102, 241, 0.3);
            overflow: hidden;
            animation: cardFadeIn 0.6s ease-out backwards;
        }

        .social-card:nth-child(1) { animation-delay: 0.1s; }
        .social-card:nth-child(2) { animation-delay: 0.2s; }
        .social-card:nth-child(3) { animation-delay: 0.3s; }
        .social-card:nth-child(4) { animation-delay: 0.4s; }
        .social-card:nth-child(5) { animation-delay: 0.5s; }
        .social-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Efecto de brillo animado en el fondo */
        .social-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .social-card:hover::before {
            animation: shine 1.5s ease-in-out infinite;
        }

        @keyframes shine {
            0% {
                left: -50%;
            }
            100% {
                left: 150%;
            }
        }

        .social-card:hover {
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 40px var(--glow-color);
            border-color: var(--border-color);
        }

        /* Iconos de redes sociales */
        .social-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-gradient);
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s ease;
            animation: iconPulse 2s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        .social-icon svg {
            width: 50px;
            height: 50px;
            fill: white;
            transition: all 0.3s ease;
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .social-card:hover .social-icon {
            transform: rotate(360deg) scale(1.2);
            box-shadow: 0 15px 50px var(--shadow-color);
        }

        /* Nombre de la red */
        .social-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        /* Username */
        .social-username {
            font-size: 1.1rem;
            color: #94a3b8;
            font-family: 'Segoe UI', system-ui, sans-serif;
            font-weight: 500;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        /* Badge de recomendado */
        .recommended-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #1e293b;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.5);
            z-index: 2;
            animation: badgePulse 2s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 15px rgba(251, 191, 36, 0.5);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 6px 25px rgba(251, 191, 36, 0.8);
            }
        }

        /* Colores específicos por red social */
        .youtube {
            --bg-gradient: linear-gradient(135deg, #ff0000, #cc0000);
            --shadow-color: rgba(255, 0, 0, 0.4);
            --glow-color: rgba(255, 0, 0, 0.6);
            --border-color: rgba(255, 0, 0, 0.6);
        }

        .twitter {
            --bg-gradient: linear-gradient(135deg, #1da1f2, #0c85d0);
            --shadow-color: rgba(29, 161, 242, 0.4);
            --glow-color: rgba(29, 161, 242, 0.6);
            --border-color: rgba(29, 161, 242, 0.6);
        }

        .twitch {
            --bg-gradient: linear-gradient(135deg, #9146ff, #772ce8);
            --shadow-color: rgba(145, 70, 255, 0.4);
            --glow-color: rgba(145, 70, 255, 0.6);
            --border-color: rgba(145, 70, 255, 0.6);
        }

        .kick {
            --bg-gradient: linear-gradient(135deg, #53fc18, #3dd80a);
            --shadow-color: rgba(83, 252, 24, 0.4);
            --glow-color: rgba(83, 252, 24, 0.6);
            --border-color: rgba(83, 252, 24, 0.6);
        }

        .tiktok {
            --bg-gradient: linear-gradient(135deg, #00f2ea, #ff0050);
            --shadow-color: rgba(0, 242, 234, 0.4);
            --glow-color: rgba(255, 0, 80, 0.6);
            --border-color: rgba(255, 0, 80, 0.6);
        }

        .instagram {
            --bg-gradient: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            --shadow-color: rgba(225, 48, 108, 0.4);
            --glow-color: rgba(225, 48, 108, 0.6);
            --border-color: rgba(225, 48, 108, 0.6);
        }

        /* Decoración de fondo flotante */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            animation: float 20s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #ec4899, #f59e0b);
            bottom: 15%;
            right: 10%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            top: 50%;
            left: 5%;
            animation-delay: 6s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            top: 20%;
            right: 20%;
            animation-delay: 9s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(30px, -30px) rotate(90deg);
            }
            50% {
                transform: translate(0, -60px) rotate(180deg);
            }
            75% {
                transform: translate(-30px, -30px) rotate(270deg);
            }
        }

        /* Efecto de estrellas */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.5);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }

            header {
                gap: 15px;
            }

            header a {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Formas flotantes decorativas -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Estrellas -->
    <div class="stars" id="stars"></div>

    <!-- HEADER -->
    <header>
        <a href="/">Inicio</a>
        <a href="/redes">Redes</a>
        <a href="/contenido">Contenido</a>
    </header>

    <!-- CONTENIDO -->
    <div class="container">
        <h1 class="main-title">🌐 Mis Redes Sociales</h1>
        <p class="subtitle">Sígueme en todas mis plataformas</p>

        <div class="social-grid">
            <!-- YouTube -->
            <a href="https://www.youtube.com/@PtaZet4" target="_blank" rel="noopener" class="social-card youtube">
                <span class="recommended-badge">⭐ Recomendado</span>
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </div>
                <div class="social-name">YouTube</div>
                <div class="social-username">@PtaZet4</div>
            </a>

            <!-- Twitter/X -->
            <a href="https://x.com/PtaZet4" target="_blank" rel="noopener" class="social-card twitter">
                <span class="recommended-badge">⭐ Recomendado</span>
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </div>
                <div class="social-name">X (Twitter)</div>
                <div class="social-username">@PtaZet4</div>
            </a>

            <!-- Twitch -->
            <a href="https://www.twitch.tv/ptazet4_" target="_blank" rel="noopener" class="social-card twitch">
                <span class="recommended-badge">⭐ Recomendado</span>
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z"/>
                    </svg>
                </div>
                <div class="social-name">Twitch</div>
                <div class="social-username">@PtaZet4_</div>
            </a>

            <!-- Kick -->
            <a href="https://kick.com/ptazet4" target="_blank" rel="noopener" class="social-card kick">
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 2h4v8.5l6-6.5h5l-7 7.5 7.5 11H17l-5.5-8.5-1.5 1.5V22H6V2z"/>
                    </svg>
                </div>
                <div class="social-name">Kick</div>
                <div class="social-username">@PtaZet4</div>
            </a>

            <!-- TikTok -->
            <a href="https://www.tiktok.com/@ptazet4" target="_blank" rel="noopener" class="social-card tiktok">
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                </div>
                <div class="social-name">TikTok</div>
                <div class="social-username">@PtaZet4</div>
            </a>

            <!-- Instagram -->
            <a href="https://www.instagram.com/ptazet4/" target="_blank" rel="noopener" class="social-card instagram">
                <div class="social-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                    </svg>
                </div>
                <div class="social-name">Instagram</div>
                <div class="social-username">@PtaZet4</div>
            </a>
        </div>
    </div>

    <script>
        // Generar estrellas aleatorias
        const starsContainer = document.getElementById('stars');
        for (let i = 0; i < 100; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            starsContainer.appendChild(star);
        }

        // Efecto de cursor con partículas
        document.addEventListener('mousemove', (e) => {
            if (Math.random() > 0.9) {
                const particle = document.createElement('div');
                particle.style.position = 'fixed';
                particle.style.left = e.clientX + 'px';
                particle.style.top = e.clientY + 'px';
                particle.style.width = '4px';
                particle.style.height = '4px';
                particle.style.borderRadius = '50%';
                particle.style.background = 'rgba(147, 197, 253, 0.8)';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '1000';
                particle.style.animation = 'particleFade 1s ease-out forwards';
                document.body.appendChild(particle);

                setTimeout(() => particle.remove(), 1000);
            }
        });

        // Añadir animación de partículas del cursor
        const style = document.createElement('style');
        style.textContent = `
            @keyframes particleFade {
                0% {
                    opacity: 1;
                    transform: translate(0, 0) scale(1);
                }
                100% {
                    opacity: 0;
                    transform: translate(${Math.random() * 40 - 20}px, ${Math.random() * 40 - 20}px) scale(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
