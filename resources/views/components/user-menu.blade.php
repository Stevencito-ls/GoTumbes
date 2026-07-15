<div class="relative inline-block text-left" id="user-menu-container">
    <button type="button" id="user-menu-button" class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-full border border-slate-700 transition-colors shadow-[0_4px_10px_rgba(0,0,0,0.3)]" aria-expanded="false" aria-haspopup="true">
        <div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold text-sm shadow-inner">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <span class="text-sm font-medium text-slate-200 hidden sm:block">{{ explode(' ', Auth::user()->name)[0] }}</span>
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <div id="user-menu-dropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-2xl shadow-xl bg-slate-800 border border-slate-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition-all duration-200 opacity-0 transform scale-95 z-[100]" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <div class="py-2" role="none">
            <div class="px-4 py-3 border-b border-slate-700 mb-1">
                <p class="text-sm text-slate-300">Conectado como</p>
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="text-slate-300 hover:bg-slate-700 hover:text-white flex items-center px-4 py-3 text-sm transition-colors" role="menuitem" tabindex="-1">
                <svg class="mr-3 h-5 w-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mi Perfil
            </a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ url('/admin/dashboard') }}" class="text-slate-300 hover:bg-slate-700 hover:text-white flex items-center px-4 py-3 text-sm transition-colors" role="menuitem" tabindex="-1">
                <svg class="mr-3 h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Administrar
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="block border-t border-slate-700 mt-1 pt-1">
                @csrf
                <button type="submit" class="text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 flex w-full items-center px-4 py-3 text-sm transition-colors text-left" role="menuitem" tabindex="-1">
                    <svg class="mr-3 h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('user-menu-button');
        const dropdown = document.getElementById('user-menu-dropdown');
        let isOpen = false;

        if(btn && dropdown) {
            btn.addEventListener('click', function(event) {
                event.stopPropagation();
                isOpen = !isOpen;
                if (isOpen) {
                    dropdown.classList.remove('hidden');
                    // setTimeout para permitir que la transición se note
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0', 'scale-95');
                        dropdown.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else {
                    dropdown.classList.remove('opacity-100', 'scale-100');
                    dropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 200);
                }
            });

            document.addEventListener('click', function(event) {
                if (isOpen && !btn.contains(event.target) && !dropdown.contains(event.target)) {
                    isOpen = false;
                    dropdown.classList.remove('opacity-100', 'scale-100');
                    dropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 200);
                }
            });
        }
    });
</script>
