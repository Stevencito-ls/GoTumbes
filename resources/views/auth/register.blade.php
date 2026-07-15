<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-[28px] font-bold text-white mb-2 tracking-tight">Crear cuenta</h2>
        <p class="text-slate-400 text-[15px]">Regístrate para acceder a más beneficios</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Nombre Completo
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Juan Pérez"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Correo Electrónico
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="tu@email.com"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-xs font-bold text-slate-300 uppercase tracking-widest">
                Confirmar Contraseña
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña"
                   class="block w-full bg-slate-950/50 border border-slate-700/50 rounded-xl px-4 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-[15px] shadow-inner">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full flex justify-center py-4 px-4 rounded-xl text-[15px] font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-teal-500 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-teal-900/20">
                Crear cuenta
            </button>
        </div>
        
        <div class="text-center pt-4">
            <span class="text-[14px] text-slate-400">¿Ya tienes cuenta?</span>
            <a href="{{ route('login') }}" class="text-[14px] text-teal-400 hover:text-teal-300 font-bold ml-1 transition-colors">Inicia sesión</a>
        </div>
    </form>
</x-guest-layout>
