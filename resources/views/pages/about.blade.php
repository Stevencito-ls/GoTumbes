<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - GoTumbes</title>
    @vite(['resources/css/app.css', 'resources/css/about.css', 'resources/js/app.js'])
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
                    <a href="{{ route('about') }}" class="text-teal-400 font-semibold transition-colors">Nosotros</a>
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

    <!-- Content -->
    <section class="pt-32 pb-24 relative z-20 min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-8 text-white">Sobre <span class="text-teal-500">Nosotros</span></h1>
            
            <div class="glass-panel p-10 rounded-3xl text-left space-y-6">
                <p class="text-lg text-slate-300 leading-relaxed">
                    En <strong>GoTumbes</strong>, somos apasionados por mostrar al mundo la belleza oculta del norte peruano. Fundada con el propósito de ofrecer experiencias inolvidables, nuestra agencia se especializa en conectar a los viajeros con la naturaleza vibrante, las playas paradisíacas y la rica cultura de Tumbes.
                </p>
                
                <h3 class="text-2xl font-bold text-white mt-8 mb-4">Nuestra Misión</h3>
                <p class="text-slate-400 leading-relaxed">
                    Brindar un servicio turístico de excelencia, promoviendo el turismo sostenible y generando un impacto positivo en las comunidades locales, mientras garantizamos la seguridad, comodidad y satisfacción total de nuestros clientes.
                </p>

                <h3 class="text-2xl font-bold text-white mt-8 mb-4">Nuestra Visión</h3>
                <p class="text-slate-400 leading-relaxed">
                    Convertirnos en la agencia de viajes líder y referente en la región norte del Perú, reconocida internacionalmente por la calidad de nuestras experiencias y nuestro compromiso con la conservación del medio ambiente.
                </p>

                <div class="mt-12 flex justify-center">
                    <a href="{{ url('/') }}#catalog" class="px-8 py-3 bg-teal-500 text-white font-bold rounded-full hover:bg-teal-400 transition-all transform hover:scale-105 shadow-lg">
                        Descubre Nuestros Destinos
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (Simplified) -->
    <footer class="bg-slate-900 text-slate-500 py-8 text-center text-sm border-t border-slate-800">
        &copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.
    </footer>

</body>
</html>
