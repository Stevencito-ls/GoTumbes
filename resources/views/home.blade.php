<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoTumbes - Experiencias Inolvidables</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white bg-slate-900 text-slate-100" id="body-main">

    <!-- Header / Nav -->
    <div class="fixed w-full z-50">
        <!-- Main Nav -->
        <nav class="w-full glass-panel border-b-0">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="text-2xl font-black tracking-tighter text-white flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-8 w-auto">
                    <a href="{{ url('/') }}">Go<span class="text-teal-500">Tumbes</span></a>
                </div>
                <div class="hidden md:flex space-x-8 text-sm font-medium text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-teal-400 transition-colors">Inicio</a>
                    <a href="{{ route('destinations.index') }}" class="hover:text-teal-400 transition-colors">Destinos</a>
                    <a href="{{ route('about') }}" class="hover:text-teal-400 transition-colors">Nosotros</a>
                    <a href="{{ route('services') }}" class="hover:text-teal-400 transition-colors">Servicios</a>
                    <a href="{{ route('contact') }}" class="hover:text-teal-400 transition-colors">Contacto</a>
                </div>
                <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <x-user-menu />
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-teal-400 transition">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold bg-teal-500 hover:bg-teal-400 text-white px-4 py-2 rounded-full transition shadow-[0_4px_10px_rgba(20,184,166,0.3)]">Registrarse</a>
                        @endif
                    @endauth
                @endif
                </div> </div>
        </nav>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/51917328085?text=Hola%20GoTumbes,%20quiero%20más%20información%20sobre%20los%20tours" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 bg-[#25D366] hover:bg-[#1ebe57] text-white rounded-full p-4 shadow-lg shadow-[#25D366]/30 transition-all hover:scale-110 z-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.005-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
        </svg>
    </a>

    <!-- Mensajes de Sesión/Advertencias -->
    @if(session('warning'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-amber-500 text-white px-6 py-3 rounded-full shadow-lg font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('warning') }}
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative w-full h-screen flex items-center justify-center overflow-hidden">
        <!-- Video Background -->
        <video id="hero-video" autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('videos/demoPagina.webm') }}" type="video/webm">
        </video>
        
        <!-- Subtle Overlays for Legibility & Blending -->
        <div class="absolute inset-0 bg-black/40 z-0"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-900/80 via-slate-900/30 to-transparent z-0"></div>
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-slate-900 to-transparent z-0"></div>

        <div class="hero-title z-0 drop-shadow-2xl">GOTUMBES</div>

        <!-- Interface -->  
        <div class="relative z-10 text-center mt-16 px-4">
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter mb-6 text-white" style="text-shadow: 0 10px 20px rgba(0,0,0,0.8);">
                Descubre el Paraíso <br>
                <span class="text-teal-400" style="text-shadow: 0 10px 20px rgba(0,0,0,0.8);">
                    Oculto del Norte
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 max-w-2xl mx-auto mb-10 font-light tracking-wide" style="text-shadow: 0 4px 10px rgba(0,0,0,0.9);">
                Sumérgete en playas de arena blanca, manglares vibrantes y gastronomía de clase mundial.
            </p>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Experiencias Seleccionadas Section -->
    <section id="experiencias" class="py-24 bg-slate-900 relative z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16 md:flex md:justify-between md:items-end">
                <div>
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 text-white">Experiencias<br>Seleccionadas</h2>
                    <p class="text-slate-400">Descubre la magia de Tumbes en movimiento.</p>
                </div>
                <a href="{{ route('destinations.index') }}" class="mt-6 md:mt-0 px-6 py-3 bg-teal-500/10 text-teal-400 border border-teal-500/30 rounded-full hover:bg-teal-500 hover:text-white transition-all font-medium inline-flex items-center gap-2">
                    Ver todos los destinos <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(array_slice($destinations, 0, 3) as $index => $dest)
                <a href="{{ route('destinations.show', $dest['id']) }}" class="relative rounded-3xl overflow-hidden aspect-[9/16] group cursor-pointer border border-slate-700/50 shadow-2xl {{ $index === 1 ? 'md:-translate-y-8' : '' }} block">
                    <img src="{{ asset($dest['image_url'] ?? 'images/default.jpg') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $dest['title'] }}" onerror="this.src='https://images.unsplash.com/photo-1596395819057-cb378328dcce?q=80&w=600&auto=format&fit=crop'">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-8 w-full transform transition-transform duration-300 group-hover:-translate-y-2">
                        @php
                            $badgeColor = $index === 0 ? 'bg-teal-500' : ($index === 1 ? 'bg-rose-500' : 'bg-amber-500');
                            $badgeText = $index === 0 ? 'Aventura' : ($index === 1 ? 'Relax' : 'Cultura');
                        @endphp
                        <div class="inline-block px-3 py-1 {{ $badgeColor }} text-white text-xs font-bold rounded-full mb-3 shadow-lg">{{ $badgeText }}</div>
                        <h3 class="text-3xl font-bold text-white mb-2 leading-tight">{{ preg_replace('/([a-z])([A-Z])/s', '$1 $2', $dest['title']) }}</h3>
                        <p class="text-slate-300 text-sm line-clamp-2">{{ $dest['description'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="text-2xl font-black tracking-tighter text-white mb-4">
                    Go<span class="text-teal-500">Tumbes</span>
                </div>
                <p class="text-sm text-slate-400 mb-6 max-w-sm">
                    Tu agencia de viajes de confianza en Tumbes. Descubre las mejores playas, manglares y experiencias con seguridad y garantía.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ $globalSettings['facebook_url'] ?? '#' }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="{{ $globalSettings['instagram_url'] ?? '#' }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Sobre Nosotros</a></li>
                    <li><a href="#catalog" class="hover:text-teal-400 transition-colors">Destinos</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Preguntas Frecuentes</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Términos y Condiciones</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Contacto</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-teal-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span>{!! nl2br(e($globalSettings['address'] ?? "Plaza Principal S/N\nTumbes, Perú")) !!}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        <span>{{ $globalSettings['phone'] ?? '+51 987 654 321' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <span>{{ $globalSettings['email'] ?? 'reservas@gotumbes.pe' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-slate-800 text-sm text-center text-slate-500">
            &copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Data Injection for JS -->
    {!! "<script>window.GoTumbesData = { destinations: " . Illuminate\Support\Js::from($destinations) . " };</script>" !!}
</body>
</html>
