<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PtaZet4</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2" id="favicon">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Fondo animado */
        body {
            margin:0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height:100vh;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1f4e 50%, #0f172a 100%);
            color:white;
            overflow-x:hidden;
            display:flex;
            flex-direction:column;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #3b82f6, rgba(59, 130, 246, 0)),
                radial-gradient(2px 2px at 60px 70px, #60a5fa, rgba(96, 165, 250, 0)),
                radial-gradient(1px 1px at 50px 50px, #a78bfa, rgba(167, 139, 250, 0)),
                radial-gradient(1px 1px at 130px 80px, #6366f1, rgba(99, 102, 241, 0)),
                radial-gradient(2px 2px at 90px 10px, #93c5fd, rgba(147, 197, 253, 0));
            background-repeat: repeat;
            background-size: 200px 200px;
            background-position: 0 0;
            animation: dotsDrift 20s linear infinite;
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }
        
        @keyframes dotsDrift {
            0% { background-position: 0 0; }
            100% { background-position: -200px 0; }
        }

        /* Animaciones */
        @keyframes fadeDown { from {opacity:0; transform:translateY(-20px);} to {opacity:1; transform:translateY(0);} }
        @keyframes fadeUp { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
        @keyframes scaleUp { from {transform:scale(0.95);} to {transform:scale(1);} }
        @keyframes float {0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);} }
        @keyframes glow {0%{box-shadow:0 0 10px #3b82f6;}50%{box-shadow:0 0 35px #6366f1;}100%{box-shadow:0 0 10px #3b82f6;}}
        @keyframes slideInLeft {from {opacity:0; transform:translateX(-40px);} to {opacity:1; transform:translateX(0);}}
        @keyframes slideInRight {from {opacity:0; transform:translateX(40px);} to {opacity:1; transform:translateX(0);}}
        @keyframes pulse {0%, 100%{transform:scale(1);} 50%{transform:scale(1.05);}}
        @keyframes shimmer {0%{background-position:-1000px 0;} 100%{background-position:1000px 0;}}
        @keyframes rotateIn {from {opacity:0; transform:rotate(-10deg) scale(0.8);} to {opacity:1; transform:rotate(0) scale(1);}}
        @keyframes borderGlow {0% {border-color: rgba(59, 130, 246, 0.5);} 50% {border-color: rgba(99, 102, 241, 1);} 100% {border-color: rgba(59, 130, 246, 0.5);}}
        @keyframes playPulse {0% {box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.8); transform: translate(-50%, -50%) scale(1);} 50% {box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);} 100% {box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); transform: translate(-50%, -50%) scale(1);}}
        /* Modal */
        .modal {display:none;position:fixed;inset:0;background:rgba(0,0,0,0.95);justify-content:center;align-items:center;z-index:50;transition:opacity 0.5s;backdrop-filter:blur(5px);}
        .modal.active {display:flex;animation:fadeUp 0.5s;}
        .modal iframe {width:90%;max-width:900px;aspect-ratio:16/9;transform:scale(0.8);animation:scaleUp 0.5s forwards;border:3px solid #3b82f6;border-radius:15px;box-shadow:0 20px 60px rgba(59, 130, 246, 0.3);}

        /* Último vídeo destacado */
        .featured {grid-column:1/-1;display:flex;flex-direction:column;align-items:center;gap:30px;animation:fadeUp 0.8s ease-out;max-width:700px;margin:0 auto 50px auto;width:100%;}
        
        .featured-header {text-align:center;margin-bottom:10px;}
        
        .featured-label {font-size:1rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:2px;margin-bottom:10px;animation:slideInLeft 0.8s ease-out;}
        
        .featured-title {font-size:2rem;font-weight:900;animation:slideInLeft 1s ease-out;background:linear-gradient(135deg, #dc2626, #ef4444, #f87171);background-size:200% 200%;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;text-align:center;padding:0;margin:0;animation:slideInRight 1s ease-out, titleGradient 4s ease infinite;filter:drop-shadow(0 0 30px rgba(220, 38, 38, 0.6));white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%;}
        
        @keyframes titleGradient {0%, 100% {background-position:0% 50%;} 50% {background-position:100% 50%;}}
        
        .featured-container {position:relative;width:100%;border-radius:30px;overflow:hidden;background:linear-gradient(135deg, rgba(30, 27, 75, 0.5), rgba(15, 23, 42, 0.7));backdrop-filter:blur(20px);border:1px solid rgba(139, 92, 246, 0.3);transition:all 0.5s cubic-bezier(0.4, 0, 0.2, 1);animation:featuredAppear 1.2s ease-out;}
        
        .featured-container::before {content:'';position:absolute;inset:-3px;border-radius:30px;background:linear-gradient(135deg, #dc2626, #ef4444, #f87171, #8b5cf6, #6366f1, #3b82f6, #dc2626);background-size:400% 400%;animation:borderFlow 8s linear infinite;z-index:-1;opacity:0.6;}
        
        @keyframes borderFlow {0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;}}
        
        .featured-container:hover {transform:translateY(-8px) scale(1.02);border-color:rgba(139, 92, 246, 0.6);}
        
        .featured-container::after {content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.08), transparent);transform:rotate(45deg);transition:all 0.6s ease;pointer-events:none;}
        
        .featured-container:hover::after {animation:featuredShine 2s ease-in-out infinite;}
        
        @keyframes featuredShine {0% {left:-50%;} 100% {left:150%;}}
        
        @keyframes featuredAppear {from {opacity:0;transform:scale(0.9) translateY(30px);} to {opacity:1;transform:scale(1) translateY(0);}}
        
        .featured-image {position:relative;width:100%;cursor:pointer;aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;overflow:hidden;background:linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.2));}
        
        .featured-image:hover img {transform:scale(1.08);filter:brightness(1.15) saturate(1.2);}
        
        .play-badge {position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width:100px;height:100px;background:linear-gradient(145deg, #8b5cf6, #6366f1, #3b82f6);background-size:200% 200%;border-radius:50%;display:flex;justify-content:center;align-items:center;opacity:0;transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);box-shadow:0 0 0 0 rgba(139, 92, 246, 0.7), 0 0 40px rgba(139, 92, 246, 0.6), 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.3);border:4px solid rgba(255, 255, 255, 0.3);z-index:10;animation:ytPlayPulse 2s ease-in-out infinite, ytGradientRotate 3s linear infinite;}
        
        .play-badge::before {content:'';position:absolute;inset:-10px;border-radius:50%;border:3px solid rgba(139, 92, 246, 0.5);animation:ytRipple 2s ease-out infinite;}
        
        .play-badge::after {content:'▶';font-size:38px;color:white;margin-left:5px;filter:drop-shadow(0 3px 6px rgba(0, 0, 0, 0.4));}
        
        .featured-image:hover .play-badge {opacity:1;transform:translate(-50%, -50%) scale(1.15);box-shadow:0 0 0 20px rgba(139, 92, 246, 0.2), 0 0 70px rgba(139, 92, 246, 1), 0 20px 50px rgba(0, 0, 0, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.5);}
        
        .featured-info {padding:25px 30px;background:linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 27, 75, 0.8));border-top:1px solid rgba(139, 92, 246, 0.2);}
        
        .featured-video-title {font-size:1.3rem;font-weight:700;color:#f3f4f6;margin-bottom:15px;line-height:1.4;text-align:center;background:linear-gradient(135deg, #f3f4f6, #e5e7eb);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        
        .featured-meta {display:flex;justify-content:center;gap:30px;color:#94a3b8;font-size:0.95rem;flex-wrap:wrap;}
        
        .featured-meta-item {display:flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(139, 92, 246, 0.1);border-radius:20px;border:1px solid rgba(139, 92, 246, 0.2);transition:all 0.3s ease;}
        
        .featured-meta-item:hover {background:rgba(139, 92, 246, 0.2);border-color:rgba(139, 92, 246, 0.4);transform:translateY(-2px);}
        
        @keyframes ytPlayPulse {0%, 100% {box-shadow:0 0 0 0 rgba(139, 92, 246, 0.7), 0 0 40px rgba(139, 92, 246, 0.6), 0 10px 30px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.3);} 50% {box-shadow:0 0 0 15px rgba(139, 92, 246, 0), 0 0 70px rgba(139, 92, 246, 1), 0 15px 40px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);}}
        
        @keyframes ytRipple {0% {transform:scale(1);opacity:1;} 100% {transform:scale(1.5);opacity:0;}}
        
        @keyframes ytGradientRotate {0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;}}

        /* Miniaturas */
        .video-card {position:relative;cursor:pointer;overflow:hidden;border-radius:20px;animation:fadeUp 0.8s ease-out;border:2px solid rgba(99, 102, 241, 0.3);transition:all 0.5s ease;box-shadow:0 10px 30px rgba(0,0,0,0.3);aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;}
        .video-card:hover {transform:translateY(-12px) scale(1.02);box-shadow:0 25px 60px rgba(99, 102, 241, 0.6);border-color:rgba(99, 102, 241, 0.9);}
        .video-card img {width:100%;height:100%;object-fit:fill;transition:transform 0.5s ease, filter 0.5s ease;display:block;}
        .video-card:hover img {transform:scale(1.1); filter:brightness(1.2) saturate(1.1);}
        .video-card h4 {
            position:absolute;
            bottom:0;
            width:100%;
            padding:15px;
            margin:0;
            background:linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.9) 100%);
            font-weight:bold;
            font-size:1rem;
            text-align:center;
            transition:all 0.5s ease;
            z-index:10;
        }
        .video-card:hover h4 {background:linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,1) 100%);padding:15px;}
        .video-card::before {content:'';position:absolute;inset:0;background:linear-gradient(135deg, rgba(96, 165, 250, 0.1), rgba(167, 139, 250, 0.1));opacity:0;transition:opacity 0.3s;z-index:1;}
        .video-card:hover::before {opacity:1;}

        header {
            position: sticky;
            top: 0;
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

        /* Sección títulos */
        section h2 {animation:slideInLeft 1s ease-out;}

        /* Layout con sidebar derecho */
        .container-content {
            display: flex;
            flex: 1;
            gap: 20px;
            padding: 20px;
            max-width: 100%;
            position: relative;
            z-index: 2;
        }

        /* Layout vertical 33% */
        main {
            flex: 1;
            padding:20px !important;
            max-width:none !important;
            margin:0 !important;
            position: relative;
            z-index: 2;
        }

        /* Sidebar derecho */
        .live-sidebar {
            width: 350px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(30, 27, 75, 0.8), rgba(15, 23, 42, 0.9));
            border-radius: 20px;
            border: 2px solid rgba(99, 102, 241, 0.3);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.2);
            animation: slideInRight 0.8s ease-out;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .live-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .live-sidebar::-webkit-scrollbar-track {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
        }

        .live-sidebar::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.5);
            border-radius: 10px;
        }

        .live-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.8);
        }

        .live-status {
            text-align: center;
        }

        .live-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #a78bfa, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .live-indicator {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
        }

        .live-badge {
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: pulse 2s ease-in-out infinite;
            box-shadow: 0 0 30px rgba(220, 38, 38, 0.5);
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(153, 27, 27, 0.9));
            border: 2px solid rgba(248, 113, 113, 0.6);
        }

        .live-badge.offline {
            animation: none;
            box-shadow: 0 0 10px rgba(107, 114, 128, 0.3);
            background: linear-gradient(135deg, rgba(55, 65, 81, 0.9), rgba(31, 41, 55, 0.9));
            border: 2px solid rgba(107, 114, 128, 0.5);
        }

        .live-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #f87171;
            animation: blink 1.5s ease-in-out infinite;
        }

        .live-dot.offline {
            background: #6b7280;
            animation: none;
            opacity: 0.6;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .live-platforms {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .platform-toggle {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 6px;
            gap: 6px;
            margin-bottom: 10px;
        }

        .toggle-btn {
            border: none;
            border-radius: 10px;
            padding: 10px 12px;
            color: #e5e7eb;
            background: rgba(255, 255, 255, 0.03);
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.7), rgba(139, 92, 246, 0.8));
            color: white;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
        }

        .platform-link {
            padding: 12px 15px;
            border-radius: 12px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 2px solid;
            background-size: 200% 200%;
        }

        .platform-link.twitch {
            background: linear-gradient(135deg, rgba(145, 71, 254, 0.2), rgba(145, 71, 254, 0.1));
            border-color: rgba(145, 71, 254, 0.6);
            color: #d8b4fe;
        }

        .platform-link.twitch:hover {
            background: linear-gradient(135deg, rgba(145, 71, 254, 0.4), rgba(145, 71, 254, 0.2));
            border-color: rgba(145, 71, 254, 1);
            box-shadow: 0 0 20px rgba(145, 71, 254, 0.4);
            transform: translateX(5px);
        }

        .platform-link.kick {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            border-color: rgba(34, 197, 94, 0.6);
            color: #86efac;
        }

        .platform-link.kick:hover {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.4), rgba(34, 197, 94, 0.2));
            border-color: rgba(34, 197, 94, 1);
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.4);
            transform: translateX(5px);
        }

        .offline-message {
            padding: 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.1), rgba(167, 139, 250, 0.1));
            border: 2px dashed rgba(96, 165, 250, 0.4);
            text-align: center;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .offline-message strong {
            color: #93c5fd;
        }

        .next-stream {
            padding: 15px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(75, 85, 99, 0.1));
            border-left: 4px solid rgba(107, 114, 128, 0.6);
            font-size: 0.9rem;
            color: #d1d5db;
        }

        .next-stream strong {
            color: #f3f4f6;
        }

        /* Stream Preview */
        .stream-preview {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, rgba(30, 27, 75, 0.8), rgba(15, 23, 42, 0.9));
            border: 2px solid rgba(99, 102, 241, 0.4);
            animation: fadeUp 0.6s ease-out, borderGlow 3s ease-in-out infinite;
            display: flex;
            flex-direction: column;
        }

        .stream-preview::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #f59e0b, #3b82f6);
            background-size: 300% 300%;
            border-radius: 15px;
            z-index: -1;
            opacity: 0.6;
            animation: gradientShift 8s ease infinite;
            filter: blur(8px);
        }

        @keyframes borderGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
            }
            50% {
                box-shadow: 0 0 35px rgba(99, 102, 241, 0.8), 0 0 50px rgba(139, 92, 246, 0.4);
            }
        }

        @keyframes gradientShift {
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

        .stream-preview-image {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(99, 102, 241, 0.2));
            animation: subtleGlow 4s ease-in-out infinite;
        }

        @keyframes subtleGlow {
            0%, 100% {
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(99, 102, 241, 0.2));
            }
            50% {
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.4), rgba(139, 92, 246, 0.3));
            }
        }

        .stream-preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .stream-preview-image:hover img {
            transform: scale(1.08);
            filter: brightness(1.1);
        }

        .stream-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(99, 102, 241, 0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stream-preview-image:hover .stream-overlay {
            opacity: 1;
        }

        .stream-play-icon {
            width: 70px;
            height: 70px;
            background: rgba(59, 130, 246, 0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            border: 3px solid rgba(255, 255, 255, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        .stream-viewers {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.8);
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(248, 113, 113, 0.5);
        }

        .viewer-dot {
            width: 8px;
            height: 8px;
            background: #f87171;
            border-radius: 50%;
            animation: blink 1s ease-in-out infinite;
        }

        .stream-info {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stream-category {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #93c5fd;
            font-weight: 600;
            background: rgba(59, 130, 246, 0.2);
            padding: 4px 10px;
            border-radius: 8px;
            width: fit-content;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .stream-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #f3f4f6;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .stream-link-button {
            display: inline-block;
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(99, 102, 241, 0.8));
            color: white;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid rgba(96, 165, 250, 0.6);
            cursor: pointer;
            font-size: 0.95rem;
        }

        .stream-link-button:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 1), rgba(99, 102, 241, 1));
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.8);
            transform: translateY(-2px);
            border-color: rgba(96, 165, 250, 1);
        }

        #stream-preview-container {
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
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
    <div class="container-content">
        <main class="max-w-6xl mx-auto px-6 py-20 space-y-12">

        <!-- HERO -->
        <section class="text-center animate-[fadeDown_1s_ease-out]">
            <h1 class="text-4xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-300 to-blue-400 animate-[float_3s_ease-in-out_infinite]" style="animation:slideInLeft 1s ease-out; text-shadow: 0 0 30px rgba(34, 211, 238, 0.6);">
                Canal de Youtube
            </h1>
            <p class="text-xl text-white max-w-2xl mx-auto font-medium" style="animation:slideInRight 1s ease-out;animation-delay:0.2s;">
                Resumenes de directos, videos editados, colaboraciones
                y mucho más :3
            </p>
        </section>

        <!-- ÚLTIMO VÍDEO DESTACADO -->
        @if(count($videos))
        @php 
            $last = $videos[0];
            $videoId = str_replace('yt:video:', '', $last['id']);
            $title = $last['title'];
            $thumbnail = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        @endphp
        <section class="featured">
            <div class="featured-header">
                <h2 class="featured-title">{{ $title }}</h2>
            </div>
            
            <div class="featured-container">
                <div class="featured-image" onclick="openModal('{{ $videoId }}')">
                    <img src="{{ $thumbnail }}" alt="{{ $title }}" onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'"/>
                    <div class="play-badge"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- OTROS 4 VÍDEOS -->
        <section class="space-y-10">
            <h2 class="text-2xl font-extrabold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent text-center" style="text-shadow: 0 0 25px rgba(220, 38, 38, 0.7);">
                ✨ Más vídeos
            </h2>

            <div id="youtube-feed" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(array_slice($videos,1,3) as $i => $v)
                    @php
                        $videoId = str_replace('yt:video:', '', $v['id']);
                        $title = $v['title'];
                        $thumbnail = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                    @endphp
                    <div class="video-card" onclick="openModal('{{ $videoId }}')" style="animation-delay:{{ $i * 0.15 }}s;">
                        <h4>{{ $title }}</h4>
                        <img src="{{ $thumbnail }}"/>
                    </div>
                @endforeach
            </div>
        </section>

    </main>

    <!-- SIDEBAR - ESTADO DE DIRECTO -->
    <aside class="live-sidebar">
        <div class="live-status">
            <div class="live-title">📡 Canales de Streaming</div>
            <div class="live-indicator" id="live-status-container">
                <div style="text-align: center; color: #9ca3af; font-size: 0.9rem;">
                    Verificando estado...
                </div>
            </div>
        </div>

        <div id="stream-preview-container"></div>

        <div class="platform-toggle" id="platform-toggle">
            <button class="toggle-btn active" data-platform="twitch">Twitch</button>
            <button class="toggle-btn" data-platform="kick">Kick</button>
        </div>

        <div class="live-platforms">
            <a href="https://twitch.tv/PtaZet4_" target="_blank" rel="noopener" class="platform-link twitch">
                <span>♠️</span>
                <span>Twitch</span>
            </a>
            <a href="https://kick.com/PtaZet4" target="_blank" rel="noopener" class="platform-link kick">
                <span>♥️</span>
                <span>Kick</span>
            </a>
        </div>

        <div id="stream-info-container"></div>
    </aside>

    </div>

    <!-- MODAL -->
    <div id="video-modal" class="modal items-center justify-center">
        <iframe id="modal-iframe" src="" frameborder="0" allowfullscreen></iframe>
    </div>

    <!-- JS -->
    <script>
        function openModal(videoId){
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('modal-iframe');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            modal.classList.add('active');
        }

        function closeModal(){
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('modal-iframe');
            iframe.src = '';
            modal.classList.remove('active');
        }

        document.getElementById('video-modal').addEventListener('click', e=>{
            if(e.target.id==='video-modal') closeModal();
        });

        let selectedPlatform = 'twitch';
        let lastStatus = null;

        // Verificar estado de Kick directamente desde el navegador
        async function checkKickStatus() {
            try {
                // Añadir timestamp para evitar caché
                const timestamp = new Date().getTime();
                const response = await fetch(`https://kick.com/api/v2/channels/ptazet4?_=${timestamp}`, {
                    cache: 'no-cache',
                    headers: {
                        'Cache-Control': 'no-cache',
                        'Pragma': 'no-cache'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    // Verificar si livestream es null (offline) o si tiene el flag is_live en false
                    const hasLivestream = data.livestream !== null && data.livestream !== undefined;
                    
                    if (!hasLivestream) {
                        return {
                            live: false,
                            title: '',
                            viewers: 0,
                            game: '',
                            thumbnail: '',
                            url: 'https://kick.com/ptazet4'
                        };
                    }
                    
                    const isLiveFlagSet = data.livestream.is_live === true;
                    
                    if (!isLiveFlagSet) {
                        return {
                            live: false,
                            title: '',
                            viewers: 0,
                            game: '',
                            thumbnail: '',
                            url: 'https://kick.com/ptazet4'
                        };
                    }
                    
                    let thumbnail = '';
                    if (data.livestream.thumbnail && data.livestream.thumbnail.url) {
                        thumbnail = data.livestream.thumbnail.url;
                    } else if (data.livestream.thumbnail && typeof data.livestream.thumbnail === 'string') {
                        thumbnail = data.livestream.thumbnail;
                    } else if (data.user && data.user.profile_pic) {
                        thumbnail = data.user.profile_pic;
                    } else if (data.livestream.playback_url) {
                        thumbnail = data.livestream.playback_url.replace('.m3u8', '.jpg');
                    }
                    
                    return {
                        live: true,
                        title: data.livestream.session_title || '',
                        viewers: parseInt(data.livestream.viewer_count) || 0,
                        game: data.livestream.categories && data.livestream.categories.length > 0 
                            ? data.livestream.categories[0].name 
                            : 'Sin categoría',
                        thumbnail: thumbnail,
                        url: 'https://kick.com/ptazet4'
                    };
                }
            } catch (error) {
                // Silently fail
            }
            
            // Si hay algún error, devolver offline
            return {
                live: false,
                title: '',
                viewers: 0,
                game: '',
                thumbnail: '',
                url: 'https://kick.com/ptazet4'
            };
        }

        // Verificar estado de streams
        async function checkStreamStatus() {
            try {
                // Obtener estado de Twitch del servidor y Kick del navegador
                const [serverResponse, kickData] = await Promise.all([
                    fetch('/api/stream-status'),
                    checkKickStatus()
                ]);
                
                if (!serverResponse.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }

                const data = await serverResponse.json();
                
                // Si obtuvimos datos de Kick desde el navegador, sobrescribir
                if (kickData !== null) {
                    data.kick = kickData.live;
                    data.kickData = kickData;
                    data.isLive = data.twitch || kickData.live;
                    if (!data.platform && kickData.live) {
                        data.platform = 'kick';
                    }
                }
                
                lastStatus = data;
                updateStreamUI(data);
            } catch (error) {
                console.error('Error verificando streams:', error);
                updateStreamUI({
                    isLive: false,
                    platform: null,
                    twitch: false,
                    kick: false,
                    streamData: null
                });
            }
        }

        function updatePlatformToggle(active) {
            const toggleButtons = document.querySelectorAll('#platform-toggle .toggle-btn');
            toggleButtons.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.platform === active);
            });
        }

        function updateStreamUI(data) {
            const statusContainer = document.getElementById('live-status-container');
            const infoContainer = document.getElementById('stream-info-container');
            const previewContainer = document.getElementById('stream-preview-container');
            const twitchButton = document.querySelector('.platform-link.twitch');
            const kickButton = document.querySelector('.platform-link.kick');
            const platformToggle = document.getElementById('platform-toggle');

            // Normalizar datos por plataforma
            const twitchData = data.twitchData || (data.platform === 'twitch' ? data.streamData : { live: data.twitch || false });
            const kickData = data.kickData || (data.platform === 'kick' ? data.streamData : { live: data.kick || false });

            const twitchLive = twitchData && twitchData.live;
            const kickLive = kickData && kickData.live;

            // Mostrar/ocultar botones inferiores según plataforma en directo
            if (twitchButton) twitchButton.style.display = twitchLive ? 'none' : 'inline-flex';
            if (kickButton) kickButton.style.display = kickLive ? 'none' : 'inline-flex';

            // Mostrar slider solo si ambas plataformas están en directo
            if (platformToggle) {
                const showToggle = twitchLive && kickLive;
                platformToggle.style.display = showToggle ? 'grid' : 'none';
                if (!showToggle) {
                    if (twitchLive && !kickLive) selectedPlatform = 'twitch';
                    else if (kickLive && !twitchLive) selectedPlatform = 'kick';
                }
            }

            // Elegir plataforma inicial si no hay selección manual o cambiar a la que esté en vivo
            if (!selectedPlatform) {
                selectedPlatform = twitchLive ? 'twitch' : (kickLive ? 'kick' : 'twitch');
            } else if (!twitchLive && kickLive && selectedPlatform === 'twitch') {
                selectedPlatform = 'kick';
            } else if (!kickLive && twitchLive && selectedPlatform === 'kick') {
                selectedPlatform = 'twitch';
            }
            updatePlatformToggle(selectedPlatform);

            const activePlatform = selectedPlatform;
            const activeData = activePlatform === 'twitch' ? twitchData : kickData;
            const isLive = activeData && activeData.live;
            const platformEmoji = activePlatform === 'twitch' ? '♠️' : '♥️';
            const platformName = activePlatform.charAt(0).toUpperCase() + activePlatform.slice(1);

            if (isLive && activeData) {
                const streamData = {
                    title: activeData.title || `En directo en ${platformName}`,
                    viewers: activeData.viewers || 0,
                    thumbnail: activeData.thumbnail || '',
                    game: activeData.game || 'Sin categoría',
                    url: activeData.url || (activePlatform === 'twitch' ? 'https://twitch.tv/PtaZet4_' : 'https://kick.com/PtaZet4')
                };

                // Asegurar que el contenedor del status existe
                let statusBadge = statusContainer.querySelector('.live-badge');
                if (!statusBadge) {
                    statusContainer.innerHTML = `
                        <div class="live-badge">
                            <div class="live-dot"></div>
                            <span>EN DIRECTO</span>
                        </div>
                        <div style="font-size: 0.9rem; color: #d1d5db;">
                            Transmitiendo en <strong style="color: #93c5fd;"><span class="platform-name">${platformEmoji} ${platformName}</span></strong>
                        </div>
                    `;
                } else {
                    // Actualizar el badge existente de offline a live
                    statusBadge.classList.remove('offline');
                    const liveDot = statusBadge.querySelector('.live-dot');
                    if (liveDot) {
                        liveDot.classList.remove('offline');
                    }
                    const badgeText = statusBadge.querySelector('span');
                    if (badgeText && badgeText.textContent !== 'EN DIRECTO') {
                        badgeText.textContent = 'EN DIRECTO';
                    }
                    const platformSpan = statusContainer.querySelector('.platform-name');
                    if (platformSpan) {
                        platformSpan.textContent = `${platformEmoji} ${platformName}`;
                    } else {
                        // Si no existe el span de plataforma, recrear el mensaje completo
                        const statusTextDiv = Array.from(statusContainer.children).find(el => 
                            el.style.fontSize === '0.9rem' || el.textContent.includes('offline') || el.textContent.includes('Transmitiendo')
                        );
                        if (statusTextDiv) {
                            statusTextDiv.innerHTML = `Transmitiendo en <strong style="color: #93c5fd;"><span class="platform-name">${platformEmoji} ${platformName}</span></strong>`;
                        }
                    }
                }

                statusContainer.style.display = 'flex';
                infoContainer.innerHTML = '';

                // ACTUALIZAR PREVIEW - SOLO MODIFICAR VALORES, NO RECREAR DOM
                if (!previewContainer.querySelector('.stream-preview')) {
                    let viewerText = '';
                    if (streamData.viewers >= 0) {
                        viewerText = `<div class="stream-viewers">
                            <div class="viewer-dot"></div>
                            <span class="viewer-count">${streamData.viewers.toLocaleString()}</span>
                        </div>`;
                    }

                    let imageContent = '';
                    if (streamData.thumbnail) {
                        imageContent = `<img src="${streamData.thumbnail}" alt="${streamData.title}" class="stream-preview-img" onerror="this.style.display='none'"/>`;
                    }

                    previewContainer.innerHTML = `
                        <div class="stream-preview">
                            <div class="stream-preview-image" data-url="${streamData.url}">
                                ${imageContent}
                                ${viewerText}
                                <div class="stream-overlay">
                                    <div class="stream-play-icon">▶</div>
                                </div>
                            </div>
                            <div class="stream-info">
                                <div class="stream-category"><span class="category-text">♠️ ${streamData.game}</span></div>
                                <div class="stream-title"><span class="title-text">${streamData.title}</span></div>
                                <a href="${streamData.url}" target="_blank" class="stream-link-button">
                                    ▶ Ver en vivo
                                </a>
                            </div>
                        </div>
                    `;
                    
                    const previewImageDiv = previewContainer.querySelector('.stream-preview-image');
                    if (previewImageDiv) {
                        previewImageDiv.addEventListener('click', function() {
                            window.open(this.dataset.url, '_blank');
                        });
                    }
                } else {
                    // Actualizar imagen existente
                    const previewImageDiv = previewContainer.querySelector('.stream-preview-image');
                    let img = previewContainer.querySelector('.stream-preview-img');
                    
                    if (streamData.thumbnail) {
                        if (img) {
                            // Actualizar imagen existente
                            if (img.src !== streamData.thumbnail) {
                                img.src = streamData.thumbnail;
                                img.alt = streamData.title;
                                img.style.display = 'block';
                            }
                        } else {
                            // Crear imagen si no existe
                            img = document.createElement('img');
                            img.src = streamData.thumbnail;
                            img.alt = streamData.title;
                            img.className = 'stream-preview-img';
                            img.onerror = function() { this.style.display = 'none'; };
                            if (previewImageDiv) {
                                previewImageDiv.insertBefore(img, previewImageDiv.firstChild);
                            }
                        }
                    } else if (img) {
                        // Si no hay thumbnail, ocultar la imagen
                        img.style.display = 'none';
                    }

                    const viewerCount = previewContainer.querySelector('.viewer-count');
                    if (viewerCount) {
                        const newViewerText = streamData.viewers >= 0 ? streamData.viewers.toLocaleString() : '0';
                        if (viewerCount.textContent !== newViewerText) {
                            viewerCount.textContent = newViewerText;
                        }
                        const viewerBox = previewContainer.querySelector('.stream-viewers');
                        if (viewerBox) viewerBox.style.display = 'flex';
                    } else if (streamData.viewers >= 0) {
                        // Crear contador si no existe
                        const viewerBox = document.createElement('div');
                        viewerBox.className = 'stream-viewers';
                        viewerBox.innerHTML = `
                            <div class="viewer-dot"></div>
                            <span class="viewer-count">${streamData.viewers.toLocaleString()}</span>
                        `;
                        if (previewImageDiv) {
                            previewImageDiv.appendChild(viewerBox);
                        }
                    }

                    const categoryText = previewContainer.querySelector('.category-text');
                    if (categoryText) {
                        const newCategoryHTML = `♠️ ${streamData.game}`;
                        if (categoryText.innerHTML !== newCategoryHTML) {
                            categoryText.innerHTML = newCategoryHTML;
                        }
                    }

                    const titleText = previewContainer.querySelector('.title-text');
                    if (titleText) {
                        const newTitleHTML = streamData.title;
                        if (titleText.textContent !== newTitleHTML) {
                            titleText.textContent = newTitleHTML;
                        }
                    }

                    if (previewImageDiv && previewImageDiv.dataset.url !== streamData.url) {
                        previewImageDiv.dataset.url = streamData.url;
                    }

                    const streamLinkButton = previewContainer.querySelector('.stream-link-button');
                    if (streamLinkButton && streamLinkButton.href !== streamData.url) {
                        streamLinkButton.href = streamData.url;
                    }
                }

            } else {
                // Offline
                statusContainer.innerHTML = `
                    <div class="live-badge offline">
                        <div class="live-dot offline"></div>
                        <span>OFFLINE</span>
                    </div>
                `;

                previewContainer.innerHTML = '';

                infoContainer.innerHTML = `
                    <div class="offline-message">
                        <strong>🌙 Actualmente descansando</strong><br>
                        ¡Sígueme en Twitch y Kick para no perderte el próximo directo!
                    </div>
                `;
            }
        }

        // Manejar cambio de slider
        const platformToggle = document.getElementById('platform-toggle');
        if (platformToggle) {
            platformToggle.addEventListener('click', (e) => {
                const btn = e.target.closest('.toggle-btn');
                if (!btn) return;
                const targetPlatform = btn.dataset.platform;
                if (targetPlatform && targetPlatform !== selectedPlatform) {
                    selectedPlatform = targetPlatform;
                    updatePlatformToggle(selectedPlatform);
                    if (lastStatus) {
                        updateStreamUI(lastStatus);
                    }
                }
            });
        }

        // Verificar estado al cargar
        checkStreamStatus();

        // Verificar cada 3 segundos
        setInterval(checkStreamStatus, 3000);
    </script>

</body>
</html>
