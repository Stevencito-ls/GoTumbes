<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-[28px] font-bold text-white mb-2 tracking-tight">Bienvenido de nuevo</h2>
        <p class="text-slate-400 text-[15px]">Ingresa con tu cuenta para continuar</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Correo Electrónico
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@email.com"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <div class="flex justify-end pt-1">
            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-teal-400 hover:text-teal-300 transition-colors" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-4 px-4 rounded-xl text-[15px] font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-teal-500 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-teal-900/20">
                Ingresar
            </button>
        </div>
    </form>
</x-guest-layout>
