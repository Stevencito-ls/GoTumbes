<aside id="admin-sidebar" class="bg-slate-900 text-slate-300 w-72 flex-shrink-0 flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0 absolute md:relative z-40 h-screen overflow-y-auto border-r border-slate-800 shadow-2xl">
    <!-- Logo Área -->
    <div class="h-20 flex items-center px-8 bg-slate-950/50 border-b border-slate-800/60 backdrop-blur-sm sticky top-0 z-10">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center shadow-lg shadow-teal-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-2xl font-black text-white tracking-tight">Go<span class="text-teal-400">Tumbes</span></span>
        </a>
    </div>

    <!-- Menú de Navegación -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Principal</p>
        
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-teal-500/10 text-teal-400 font-semibold shadow-[inset_4px_0_0_0_rgba(20,184,166,1)]' : 'hover:bg-slate-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-teal-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="border-b-0 leading-none pb-0">Dashboard</span>
        </x-nav-link>

        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-8 mb-2">Sistema</p>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-slate-800/50 hover:text-white">
            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="border-b-0 leading-none pb-0">Perfil Administrativo</span>
        </x-nav-link>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-slate-800/60 bg-slate-950/30">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="font-medium">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</aside>
