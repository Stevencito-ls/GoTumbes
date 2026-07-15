<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - GoTumbes</title>
    @vite(['resources/css/app.css', 'resources/css/contact.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white bg-slate-900 text-slate-100">

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
                    <a href="{{ route('services') }}" class="hover:text-teal-400 transition-colors">Servicios</a>
                    <a href="{{ route('contact') }}" class="text-teal-400 font-semibold transition-colors">Contacto</a>
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
    <section class="pt-32 pb-24 relative z-20 min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Info de Contacto -->
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-white">Ponte en <span class="text-teal-500">Contacto</span></h1>
                <p class="text-slate-400 text-lg mb-10">
                    ¿Tienes alguna duda o quieres personalizar un paquete turístico? Escríbenos y nuestro equipo te responderá a la brevedad.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4 glass-panel p-4 rounded-2xl">
                        <div class="w-12 h-12 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Visítanos</h4>
                            <p class="text-slate-400 text-sm">Plaza Principal S/N, Tumbes, Perú</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 glass-panel p-4 rounded-2xl">
                        <div class="w-12 h-12 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Llámanos</h4>
                            <p class="text-slate-400 text-sm">+51 987 654 321</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 glass-panel p-4 rounded-2xl">
                        <div class="w-12 h-12 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Escríbenos</h4>
                            <p class="text-slate-400 text-sm">reservas@gotumbes.pe</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="glass-panel p-8 rounded-3xl">
                <h3 class="text-2xl font-bold text-white mb-6">Envíanos un mensaje</h3>
                <form action="#" method="POST" class="space-y-4" onsubmit="event.preventDefault(); alert('Mensaje enviado. (Simulación)');">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Nombre Completo</label>
                        <input type="text" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white px-4 py-3 focus:ring-teal-500 focus:border-teal-500" placeholder="Ej. Ana Pérez" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Correo Electrónico</label>
                        <input type="email" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white px-4 py-3 focus:ring-teal-500 focus:border-teal-500" placeholder="ana@ejemplo.com" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Asunto</label>
                        <input type="text" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white px-4 py-3 focus:ring-teal-500 focus:border-teal-500" placeholder="Ej. Consulta sobre tour a Punta Sal" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Mensaje</label>
                        <textarea rows="4" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white px-4 py-3 focus:ring-teal-500 focus:border-teal-500" placeholder="Escribe tu consulta aquí..." required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-teal-500 text-white font-bold py-3 rounded-xl hover:bg-teal-400 transition-colors shadow-lg">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
            
        </div>
    </section>

    <!-- Footer (Simplified) -->
    <footer class="bg-slate-900 text-slate-500 py-8 text-center text-sm border-t border-slate-800">
        &copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.
    </footer>

</body>
</html>
