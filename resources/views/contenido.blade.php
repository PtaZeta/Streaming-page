<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido - PtaZet4</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" id="favicon">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favicon = document.getElementById('favicon');
            console.log('🔍 Favicon href:', favicon ? favicon.href : 'NO ENCONTRADO');
            console.log('🔍 Asset URL:', '{{ asset('favicon.ico') }}');
            console.log('🔍 Base URL:', window.location.origin);
            
            // Verificar si el archivo existe haciendo fetch
            fetch('{{ asset('favicon.ico') }}', { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        console.log('✅ Favicon existe (Status:', response.status, ')');
                        console.log('📦 Content-Type:', response.headers.get('content-type'));
                    } else {
                        console.error('❌ Favicon no encontrado (Status:', response.status, ')');
                    }
                })
                .catch(err => console.error('❌ Error al cargar favicon:', err));
        });
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0e1a;
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* Fondo animado de malla hexagonal */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: 
                linear-gradient(60deg, transparent 30%, rgba(139, 92, 246, 0.03) 30%, rgba(139, 92, 246, 0.03) 70%, transparent 70%),
                linear-gradient(120deg, transparent 30%, rgba(59, 130, 246, 0.03) 30%, rgba(59, 130, 246, 0.03) 70%, transparent 70%);
            background-size: 80px 140px;
            animation: hexMove 20s linear infinite;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle at 20% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            animation: gradientShift 15s ease infinite;
            z-index: 0;
        }

        @keyframes hexMove {
            0% {
                background-position: 0 0, 0 0;
            }
            100% {
                background-position: 80px 140px, 80px 140px;
            }
        }

        @keyframes gradientShift {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        /* Header */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 25px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(139, 92, 246, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        /* Título de sección */
        .section-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 15px;
            text-align: center;
            background: linear-gradient(135deg, #8b5cf6, #6366f1, #3b82f6, #8b5cf6);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientFlow 8s ease infinite;
            filter: drop-shadow(0 0 30px rgba(139, 92, 246, 0.5));
        }

        @keyframes gradientFlow {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #a5b4fc;
            margin-bottom: 50px;
            animation: fadeIn 1s ease-out;
            letter-spacing: 0.5px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Pestañas */
        .tabs {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
            animation: slideDown 0.8s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-btn {
            padding: 18px 45px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(99, 102, 241, 0.1));
            border: 2px solid rgba(139, 92, 246, 0.3);
            border-radius: 20px;
            color: #e0e7ff;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .tab-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(99, 102, 241, 0.3));
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .tab-btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .tab-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 40px rgba(139, 92, 246, 0.4);
            border-color: rgba(139, 92, 246, 0.6);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border-color: #a78bfa;
            box-shadow: 0 15px 40px rgba(139, 92, 246, 0.5);
            color: white;
        }

        .tab-btn span {
            position: relative;
            z-index: 1;
        }

        /* Grid de contenido */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tarjetas de contenido */
        .content-card {
            position: relative;
            background: linear-gradient(135deg, rgba(30, 27, 75, 0.4), rgba(15, 23, 42, 0.6));
            border-radius: 25px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(139, 92, 246, 0.2);
            backdrop-filter: blur(10px);
            animation: cardAppear 0.6s ease-out backwards;
        }

        .content-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 25px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.5), rgba(59, 130, 246, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .content-card:hover::after {
            opacity: 1;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(139, 92, 246, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .content-card:hover::before {
            animation: shine 2s ease-in-out infinite;
        }

        @keyframes shine {
            0% { left: -50%; }
            100% { left: 150%; }
        }

        .content-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 25px 60px rgba(139, 92, 246, 0.4), 0 0 40px rgba(99, 102, 241, 0.2);
            border-color: rgba(139, 92, 246, 0.5);
        }

        .content-thumbnail {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.2));
        }

        .content-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .content-card:hover .content-thumbnail img {
            transform: scale(1.1);
        }

        .play-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(139, 92, 246, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s ease;
            backdrop-filter: blur(5px);
        }

        .content-card:hover .play-overlay {
            opacity: 1;
        }

        .play-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(145deg, #8b5cf6, #6366f1, #3b82f6);
            background-size: 200% 200%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 0 0 0 rgba(139, 92, 246, 0.7),
                0 0 40px rgba(139, 92, 246, 0.6),
                0 10px 30px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.25);
            animation: playPulse 2s ease-in-out infinite, gradientRotate 3s linear infinite;
        }

        .play-icon::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(139, 92, 246, 0.4);
            animation: ripple 2s ease-out infinite;
        }

        .play-icon::after {
            content: '▶';
            font-size: 32px;
            color: white;
            margin-left: 4px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .content-card:hover .play-icon {
            transform: scale(1.1);
            box-shadow: 
                0 0 0 15px rgba(139, 92, 246, 0.2),
                0 0 60px rgba(139, 92, 246, 0.9),
                0 15px 45px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        @keyframes playPulse {
            0%, 100% {
                box-shadow: 
                    0 0 0 0 rgba(139, 92, 246, 0.7),
                    0 0 40px rgba(139, 92, 246, 0.6),
                    0 10px 30px rgba(0, 0, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
            }
            50% {
                box-shadow: 
                    0 0 0 10px rgba(139, 92, 246, 0),
                    0 0 60px rgba(139, 92, 246, 0.9),
                    0 15px 40px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        @keyframes gradientRotate {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .content-info {
            padding: 20px;
        }

        .content-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f3f4f6;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .content-meta {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            color: #94a3b8;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .duration-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .views-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.9), rgba(99, 102, 241, 0.9));
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: badgeFloat 3s ease-in-out infinite;
        }

        @keyframes badgeFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Estado vacío */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .empty-state-text {
            font-size: 1.3rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .tabs {
                flex-direction: column;
                align-items: center;
            }

            .tab-btn {
                width: 100%;
                max-width: 300px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(99, 102, 241, 0.2);
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Filtros de periodo */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            animation: slideDown 0.8s ease-out;
        }

        .filter-btn {
            padding: 10px 25px;
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 12px;
            color: #a5b4fc;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .filter-btn:hover {
            background: rgba(139, 92, 246, 0.2);
            border-color: rgba(139, 92, 246, 0.5);
            color: #c7d2fe;
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border-color: #8b5cf6;
            color: white;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        }

        .filter-label {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-right: 15px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <a href="/">Inicio</a>
        <a href="/redes">Redes</a>
        <a href="/contenido">Contenido</a>
    </header>

    <!-- CONTENIDO -->
    <div class="container">
        <h1 class="section-title">🎬 Contenido de Twitch</h1>
        <p class="section-subtitle">Los mejores momentos y directos completos</p>

        <!-- Pestañas -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="clips">
                <span>🎯 Clips Destacados</span>
            </button>
            <button class="tab-btn" data-tab="vods">
                <span>📺 VODs Completos</span>
            </button>
        </div>

        <!-- Filtros de periodo para clips -->
        <div id="clips-filters" class="filter-container">
            <a href="/contenido?period=24h" class="filter-btn {{ $period === '24h' ? 'active' : '' }}">Últimas 24h</a>
            <a href="/contenido?period=7d" class="filter-btn {{ $period === '7d' ? 'active' : '' }}">Últimos 7 días</a>
            <a href="/contenido?period=30d" class="filter-btn {{ $period === '30d' ? 'active' : '' }}">Últimos 30 días</a>
            <a href="/contenido?period=all" class="filter-btn {{ $period === 'all' ? 'active' : '' }}">Todo el tiempo</a>
        </div>

        <!-- Contenido de Clips -->
        <div id="clips" class="tab-content active">
            @if(count($clips) > 0)
                <div class="content-grid">
                    @foreach($clips as $clip)
                        <a href="{{ $clip['url'] }}" target="_blank" rel="noopener" class="content-card">
                            <div class="content-thumbnail">
                                <img src="{{ $clip['thumbnail_url'] }}" alt="{{ $clip['title'] }}" loading="lazy">
                                <div class="play-overlay">
                                    <div class="play-icon"></div>
                                </div>
                                <div class="views-badge">
                                    👁 {{ number_format($clip['view_count']) }}
                                </div>
                                <div class="duration-badge">
                                    {{ gmdate('i:s', $clip['duration']) }}
                                </div>
                            </div>
                            <div class="content-info">
                                <div class="content-title">{{ $clip['title'] }}</div>
                                <div class="content-meta">
                                    <div class="meta-item">
                                        👤 {{ $clip['creator_name'] }}
                                    </div>
                                    <div class="meta-item">
                                        📅 {{ \Carbon\Carbon::parse($clip['created_at'])->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🎬</div>
                    <div class="empty-state-text">No hay clips disponibles por el momento</div>
                </div>
            @endif
        </div>

        <!-- Contenido de VODs -->
        <div id="vods" class="tab-content">
            @if(count($vods) > 0)
                <div class="content-grid">
                    @foreach($vods as $vod)
                        <a href="{{ $vod['url'] }}" target="_blank" rel="noopener" class="content-card">
                            <div class="content-thumbnail">
                                @php
                                    $thumbnail = isset($vod['thumbnail_url']) 
                                        ? str_replace(['%{width}', '%{height}'], ['640', '360'], $vod['thumbnail_url'])
                                        : 'https://static-cdn.jtvnw.net/ttv-static/404_preview-640x360.jpg';
                                @endphp
                                <img src="{{ $thumbnail }}" alt="{{ $vod['title'] }}" loading="lazy" onerror="this.src='https://static-cdn.jtvnw.net/ttv-static/404_preview-640x360.jpg'">
                                <div class="play-overlay">
                                    <div class="play-icon"></div>
                                </div>
                                <div class="views-badge">
                                    👁 {{ number_format($vod['view_count'] ?? 0) }}
                                </div>
                                <div class="duration-badge">
                                    @php
                                        $duration = $vod['duration'] ?? '0s';
                                        $seconds = 0;
                                        if (preg_match('/(\d+)h/', $duration, $h)) $seconds += intval($h[1]) * 3600;
                                        if (preg_match('/(\d+)m/', $duration, $m)) $seconds += intval($m[1]) * 60;
                                        if (preg_match('/(\d+)s/', $duration, $s)) $seconds += intval($s[1]);
                                        $formatted = $seconds >= 3600 ? gmdate('H:i:s', $seconds) : gmdate('i:s', $seconds);
                                        echo $formatted;
                                    @endphp
                                </div>
                            </div>
                            <div class="content-info">
                                <div class="content-title">{{ $vod['title'] }}</div>
                                <div class="content-meta">
                                    <div class="meta-item">
                                        📅 {{ \Carbon\Carbon::parse($vod['created_at'])->format('d/m/Y H:i') }}
                                    </div>
                                    @if(isset($vod['type']))
                                        <div class="meta-item">
                                            {{ $vod['type'] === 'archive' ? '🔴 Directo' : '📼 Video' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📺</div>
                    <div class="empty-state-text">No hay VODs disponibles por el momento</div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Sistema de pestañas
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        const clipsFilters = document.getElementById('clips-filters');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetTab = button.getAttribute('data-tab');
                
                // Desactivar todos los botones y contenidos
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Activar el botón y contenido seleccionado
                button.classList.add('active');
                document.getElementById(targetTab).classList.add('active');

                // Mostrar/ocultar filtros según la pestaña
                if (targetTab === 'clips') {
                    clipsFilters.style.display = 'flex';
                } else {
                    clipsFilters.style.display = 'none';
                }
            });
        });

        // Efecto de partículas al mover el mouse
        let particleTimeout;
        document.addEventListener('mousemove', (e) => {
            clearTimeout(particleTimeout);
            particleTimeout = setTimeout(() => {
                if (Math.random() > 0.85) {
                    const particle = document.createElement('div');
                    particle.style.position = 'fixed';
                    particle.style.left = e.clientX + 'px';
                    particle.style.top = e.clientY + 'px';
                    particle.style.width = '3px';
                    particle.style.height = '3px';
                    particle.style.borderRadius = '50%';
                    particle.style.background = 'rgba(99, 102, 241, 0.8)';
                    particle.style.pointerEvents = 'none';
                    particle.style.zIndex = '9999';
                    
                    const randomX = (Math.random() - 0.5) * 50;
                    const randomY = (Math.random() - 0.5) * 50;
                    
                    particle.animate([
                        { opacity: 1, transform: 'translate(0, 0) scale(1)' },
                        { opacity: 0, transform: `translate(${randomX}px, ${randomY}px) scale(0)` }
                    ], {
                        duration: 1000,
                        easing: 'ease-out'
                    });
                    
                    document.body.appendChild(particle);
                    setTimeout(() => particle.remove(), 1000);
                }
            }, 10);
        });
    </script>
</body>
</html>
