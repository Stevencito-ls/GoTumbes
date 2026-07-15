<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/80 border border-slate-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-slate-300">
                    {{ __("¡Has iniciado sesión exitosamente!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
