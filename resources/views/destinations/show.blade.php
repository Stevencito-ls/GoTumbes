<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $destination['title'] }} - GoTumbes</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    
    <!-- Open Graph / Social SEO -->
    <meta property="og:title" content="{{ $destination['title'] }} - GoTumbes">
    <meta property="og:description" content="{{ Str::limit($destination['description'] ?? 'Descubre este increíble destino turístico con GoTumbes.', 150) }}">
    <meta property="og:image" content="{{ $destination['image_url'] ?? asset('images/hero.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta name="twitter:card" content="summary_large_image">

    @vite(['resources/css/app.css', 'resources/css/destinations.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="antialiased text-slate-100 selection:bg-teal-500 selection:text-white bg-slate-900">

    <!-- Header / Nav -->
    <div class="fixed w-full z-50">
        <nav class="w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800">
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
                        @if(Auth::user() && Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="text-sm font-semibold text-slate-300 hover:text-teal-400 transition">Administrar</a>
                        @endif
                        <x-user-menu />
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-teal-400 transition">Iniciar Sesión</a>
                    @endauth
                @endif
                </div>
            </div>
        </nav>
    </div>

    <main class="pb-20">
        <!-- Hero Section -->
        <div class="relative h-[60vh] min-h-[400px] w-full bg-slate-900 overflow-hidden">
            <div class="absolute inset-0 bg-black/40 z-10"></div>
            <img src="{{ $destination['image_url'] ?? 'https://images.unsplash.com/photo-1596395819057-cb378328dcce?q=80&w=1600&auto=format&fit=crop' }}" 
                 alt="{{ $destination['title'] }}" 
                 class="w-full h-full object-cover">
            
            <div class="absolute bottom-0 left-0 w-full p-8 md:p-16 z-20 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent">
                <div class="max-w-5xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="text-white">
                        <span class="inline-block px-3 py-1 bg-teal-500/20 text-teal-300 border border-teal-500/30 rounded-full text-sm font-bold uppercase tracking-wider mb-4 backdrop-blur-md">Destino Destacado</span>
                        <h1 class="text-4xl md:text-6xl font-black mb-2">{{ preg_replace('/([a-z])([A-Z])/s', '$1 $2', $destination['title']) }}</h1>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-3xl text-center md:text-right text-white self-start md:self-end">
                        <p class="text-sm font-medium text-slate-300 uppercase tracking-wide mb-1">Precio por persona</p>
                        <p class="text-4xl font-black text-teal-400">S/ {{ $destination['price'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-5xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-10">
                    <section>
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Descripción del Tour
                        </h2>
                        <p class="text-lg text-slate-300 leading-relaxed">
                            {{ $destination['description'] }}
                        </p>
                    </section>

                    @if(!empty($destination['included']))
                    <section class="bg-slate-800 p-8 rounded-3xl shadow-sm border border-slate-700">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            ¿Qué incluye el paquete?
                        </h2>
                        <p class="text-slate-300 whitespace-pre-line">{{ $destination['included'] }}</p>
                    </section>
                    @endif
                </div>

                <!-- Right Column: Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        
                        <!-- Highlights Card -->
                        <div class="bg-slate-800 rounded-3xl shadow-lg border border-slate-700 overflow-hidden">
                            <div class="p-6 border-b border-slate-700 bg-slate-900/50">
                                <h3 class="font-bold text-white text-lg">Información Rápida</h3>
                            </div>
                            <div class="p-6 space-y-5">
                                @if(!empty($destination['max_people']))
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-400">Capacidad Máxima</p>
                                        <p class="font-bold text-white">{{ $destination['max_people'] }} Personas</p>
                                    </div>
                                </div>
                                @endif

                                @if(isset($destination['disabled_access']))
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl {{ $destination['disabled_access'] ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }} flex items-center justify-center shrink-0">
                                        @if($destination['disabled_access'])
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-400">Acceso Silla de Ruedas</p>
                                        <p class="font-bold text-white">{{ $destination['disabled_access'] ? 'Disponible' : 'No Disponible' }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <a href="{{ url('destinations/' . $destination['id'] . '/checkout') }}" class="w-full flex items-center justify-center gap-2 py-4 px-6 rounded-2xl text-white font-bold bg-teal-500 hover:bg-teal-400 transition-transform hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-teal-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Reservar Ahora
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="text-2xl font-black tracking-tighter text-white mb-4">
                    Go<span class="text-teal-500">Tumbes</span>
                </div>
                <p class="text-sm text-slate-400 mb-6 max-w-sm">
                    Tu agencia de viajes de confianza en Tumbes. Descubre las mejores playas, manglares y experiencias con seguridad y garantía.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Inicio</a></li>
                    <li><a href="#catalog" class="hover:text-teal-400 transition-colors">Destinos</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Nosotros</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">Contacto</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Contáctanos</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
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
        <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-slate-800 text-sm text-center flex flex-col md:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
