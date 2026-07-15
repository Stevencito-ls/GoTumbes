<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - GoTumbes</title>
    @vite(['resources/css/app.css', 'resources/css/services.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-slate-900 text-slate-100 selection:bg-teal-500 selection:text-white pb-20">

    <!-- Header / Nav -->
    <div class="fixed w-full z-50">
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
                    <a href="{{ route('services') }}" class="text-teal-400 font-semibold transition-colors">Servicios</a>
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

    <!-- Content -->
    <section class="pt-32 pb-24 relative z-20 min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white">Nuestros <span class="text-teal-500">Servicios</span></h1>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">Más allá de increíbles tours, te ofrecemos todo lo necesario para que tu viaje a Tumbes sea perfecto y sin preocupaciones.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="glass-panel p-8 rounded-3xl text-center transform transition duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 mx-auto bg-teal-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Tours Guiados</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Explora los Manglares, Puerto Pizarro, Punta Sal y más, con guías locales expertos que te contarán todos los secretos de la región.
                    </p>
                </div>

                <!-- Servicio 2 -->
                <div class="glass-panel p-8 rounded-3xl text-center transform transition duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 mx-auto bg-teal-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Traslados Aeropuerto</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Servicio de recojo seguro y puntual desde el aeropuerto o terminal terrestre directo a tu hotel. Movilidad privada y desinfectada.
                    </p>
                </div>

                <!-- Servicio 3 -->
                <div class="glass-panel p-8 rounded-3xl text-center transform transition duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 mx-auto bg-teal-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Reserva de Hoteles</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Te ayudamos a encontrar el alojamiento perfecto que se ajuste a tu presupuesto, desde resorts frente al mar hasta cómodos hostales.
                    </p>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <a href="{{ route('contact') }}" class="px-8 py-3 bg-white text-slate-900 font-bold rounded-full hover:bg-teal-500 hover:text-white transition-all shadow-lg">
                    Solicitar un Servicio Personalizado
                </a>
            </div>
        </div>
    </section>

    <!-- Footer (Simplified) -->
    <footer class="bg-slate-900 text-slate-500 py-8 text-center text-sm border-t border-slate-800">
        &copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.
    </footer>

</body>
</html>
