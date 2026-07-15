<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinos - GoTumbes</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/destinations.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                    <a href="{{ route('destinations.index') }}" class="text-teal-400 font-semibold transition-colors">Destinos</a>
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

    <!-- Hero Section para Destinos -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-slate-900/80 mix-blend-multiply z-10"></div>
            <!-- Un gradiente animado sutil de fondo -->
            <div class="absolute inset-0 bg-gradient-to-br from-teal-900/40 via-slate-900 to-rose-900/20"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-bold tracking-tight mb-6 text-white drop-shadow-lg">
                Catálogo de <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-300">Destinos</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto font-light drop-shadow-md">
                Explora todos los paquetes turísticos que hemos preparado para ti. Desde la tranquilidad del mar hasta la aventura en los manglares.
            </p>
        </div>
    </div>

    <!-- Grid de Destinos -->
    <section class="relative z-20 py-16 bg-slate-900" id="destinations-section">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Skeleton Loader -->
            <div id="skeleton-loader" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @for ($i = 0; $i < 6; $i++)
                <div class="tour-card glass-panel rounded-2xl overflow-hidden border border-slate-700/50 flex flex-col h-full animate-pulse">
                    <div class="relative h-64 bg-slate-800"></div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="h-6 bg-slate-800 rounded w-3/4 mb-4"></div>
                        <div class="h-4 bg-slate-800 rounded w-full mb-2"></div>
                        <div class="h-4 bg-slate-800 rounded w-5/6 mb-6 flex-grow"></div>
                        <div class="h-12 bg-teal-900/50 rounded-xl w-full"></div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Destinos Container -->
            <div id="destinations-container" class="grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 hidden">
                <!-- Se llenará vía JS -->
            </div>

            <!-- Estado Vacío -->
            <div id="empty-state" class="text-center py-20 glass-panel rounded-3xl border border-slate-700/50 hidden">
                <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-2xl font-bold text-slate-300 mb-2">No hay destinos disponibles</h3>
                <p class="text-slate-500">Pronto agregaremos nuevas e increíbles experiencias.</p>
            </div>
        </div>
    </section>

    <script>
        (function() {
            fetch('/api/destinations')
                .then(response => response.json())
                .then(data => {
                    const skeleton = document.getElementById('skeleton-loader');
                    if (skeleton) skeleton.classList.add('hidden');
                    
                    if (data.length === 0) {
                        const emptyState = document.getElementById('empty-state');
                        if (emptyState) emptyState.classList.remove('hidden');
                    } else {
                        const container = document.getElementById('destinations-container');
                        if (!container) return;
                        
                        container.innerHTML = ''; // Clear in case of Turbo cache
                        container.classList.remove('hidden');
                        container.classList.add('grid');
                        
                        data.forEach(dest => {
                            const titleFormatted = dest.title.replace(/([a-z])([A-Z])/g, '$1 $2');
                            const description = dest.description ? (dest.description.length > 120 ? dest.description.substring(0, 120) + '...' : dest.description) : 'Sin descripción.';
                            const price = Number(dest.price || 0).toFixed(2);
                            const imageUrl = dest.image_url || '/images/destinations/CatedralTumbes.jpg';
                            const url = `/destinations/${dest.id}`;
                            
                            const cardHTML = `
                                <div class="tour-card glass-panel rounded-2xl overflow-hidden group border border-slate-700/50 flex flex-col h-full">
                                    <div class="relative h-64 overflow-hidden bg-slate-800">
                                        <img src="${imageUrl}" alt="${dest.title}" class="tour-image w-full h-full object-cover transition-transform duration-700">
                                        <div class="absolute top-4 right-4 bg-slate-900/80 backdrop-blur-sm text-teal-400 px-3 py-1 rounded-full text-sm font-bold border border-teal-500/30">
                                            S/ ${price}
                                        </div>
                                    </div>
                                    <div class="p-6 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-white mb-2">${titleFormatted}</h3>
                                        <p class="text-slate-400 text-sm mb-6 flex-grow">${description}</p>
                                        
                                        <a href="${url}" class="w-full text-center py-3 bg-teal-500 hover:bg-teal-400 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-teal-500/20 block">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            `;
                            container.insertAdjacentHTML('beforeend', cardHTML);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching destinations:', error);
                    const skeleton = document.getElementById('skeleton-loader');
                    if (skeleton) skeleton.classList.add('hidden');
                    const emptyState = document.getElementById('empty-state');
                    if (emptyState) emptyState.classList.remove('hidden');
                });
        })();
    </script>

    <!-- Footer Simple -->
    <footer class="bg-slate-950 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-2xl font-black tracking-tighter text-white mb-4 flex justify-center items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-6 w-auto opacity-80">
                Go<span class="text-teal-500">Tumbes</span>
            </div>
            <p class="text-slate-500 text-sm">© {{ date('Y') }} Turismo Karla E.I.R.L. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
