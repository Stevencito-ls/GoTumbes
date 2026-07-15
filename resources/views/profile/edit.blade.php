<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de Sesión -->
            @if (session('status'))
                <div class="bg-teal-900/50 border border-teal-500 text-teal-300 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-rose-900/50 border border-rose-500 text-rose-300 px-4 py-3 rounded-xl relative" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Información del Perfil -->
            <div class="p-4 sm:p-8 bg-slate-900/80 border border-slate-700 shadow sm:rounded-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-slate-200">
                            {{ __('Información del Perfil') }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ __("Actualiza la información de tu perfil y número de teléfono.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-200 mb-1">Nombre</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-teal-500 focus:border-teal-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        </div>

                        <!-- Correo Electrónico (Solo Lectura) -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-200 mb-1">Correo Electrónico</label>
                            <div class="flex items-center justify-between">
                                <input id="email" name="email" type="email" class="mt-1 block w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-2 text-slate-400 cursor-not-allowed" value="{{ $user->email }}" readonly />
                                
                                <!-- Estado de Verificación -->
                                <div class="ml-4 whitespace-nowrap">
                                    @if($emailVerified)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-900/50 text-emerald-400 border border-emerald-800">
                                            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Actualizado (Verificado)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-rose-900/50 text-rose-400 border border-rose-800">
                                            No verificado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-200 mb-1">Teléfono</label>
                            <input id="phone" name="phone" type="text" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-teal-500 focus:border-teal-500" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder="Ej: +51 987654321" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-teal-500 transition-colors">
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </form>

                    <!-- Botón para verificar correo (si no está verificado) -->
                    @if(!$emailVerified)
                    <form method="POST" action="{{ route('profile.verify-email') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-teal-400 hover:text-teal-300 transition-colors">
                            {{ __('Haz clic aquí para enviar el correo de verificación.') }}
                        </button>
                    </form>
                    @endif
                </section>
            </div>

            <!-- Actualizar Contraseña -->
            <div class="bg-slate-900/80 border border-slate-700 shadow sm:rounded-xl overflow-hidden">
                <button type="button" class="w-full text-left p-4 sm:p-8 hover:bg-slate-800/50 focus:outline-none transition-colors flex justify-between items-center group" onclick="document.getElementById('password_section').classList.toggle('hidden'); document.getElementById('pwd_icon').classList.toggle('rotate-180');">
                    <div>
                        <h2 class="text-lg font-medium text-slate-200 flex items-center gap-2 group-hover:text-teal-400 transition-colors">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                            {{ __('Actualizar Contraseña') }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ __('Asegúrate de que tu cuenta esté usando una contraseña segura.') }}
                        </p>
                    </div>
                    <svg id="pwd_icon" class="w-6 h-6 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div id="password_section" class="hidden border-t border-slate-700 p-4 sm:p-8 bg-slate-900/40">
                    <form method="post" action="{{ route('profile.password') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-200 mb-1">Contraseña Actual</label>
                            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-teal-500 focus:border-teal-500" autocomplete="current-password" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-200 mb-1">Nueva Contraseña</label>
                            <input id="password" name="password" type="password" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-teal-500 focus:border-teal-500" autocomplete="new-password" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-200 mb-1">Confirmar Contraseña</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-teal-500 focus:border-teal-500" autocomplete="new-password" />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-teal-500 transition-colors">
                                {{ __('Guardar Nueva Contraseña') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Eliminar Cuenta -->
            <div class="bg-slate-900/80 border border-rose-900/50 shadow sm:rounded-xl overflow-hidden">
                <button type="button" class="w-full text-left p-4 sm:p-8 hover:bg-slate-800/50 focus:outline-none transition-colors flex justify-between items-center group" onclick="document.getElementById('delete_section').classList.toggle('hidden'); document.getElementById('del_icon').classList.toggle('rotate-180');">
                    <div>
                        <h2 class="text-lg font-medium text-rose-500 flex items-center gap-2 group-hover:text-rose-400 transition-colors">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            {{ __('Eliminar Cuenta') }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán de forma permanente.') }}
                        </p>
                    </div>
                    <svg id="del_icon" class="w-6 h-6 text-slate-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div id="delete_section" class="hidden border-t border-rose-900/50 p-4 sm:p-8 bg-slate-900/40">
                    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('delete')
                        
                        <div class="bg-rose-900/20 border border-rose-500/30 p-4 rounded-xl">
                            <p class="text-sm text-rose-300 mb-4">
                                Estás a punto de eliminar tu cuenta de forma permanente. Para confirmar esta acción, por favor ingresa tu contraseña.
                            </p>
                            <label for="delete_password" class="block text-sm font-medium text-slate-200 mb-1">Ingresa tu contraseña</label>
                            <input id="delete_password" name="password" type="password" class="mt-1 block w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-white focus:ring-rose-500 focus:border-rose-500" required />
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-rose-600 hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-rose-500 transition-colors">
                                {{ __('Sí, Eliminar Mi Cuenta') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
