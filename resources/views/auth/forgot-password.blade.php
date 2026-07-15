<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white tracking-tight mb-2">Recuperar Contraseña</h2>
            <p class="text-slate-400 text-sm">Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-200 mb-1">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 block w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all shadow-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
        </div>

        <div class="mt-6 pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-[0_0_15px_rgba(20,184,166,0.25)] text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-teal-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                Enviar Enlace
            </button>
        </div>
        
        <div class="text-center mt-6 pt-2">
            <a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-slate-300 transition-colors">&larr; Volver a iniciar sesión</a>
        </div>
    </form>
</x-guest-layout>
