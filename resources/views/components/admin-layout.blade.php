<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'GoTumbes Admin') }} - Panel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <div class="min-h-screen lg:flex">
            <aside class="w-full lg:w-72 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 lg:border-r lg:border-b-0">
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-8 w-auto object-contain">
                        GoTumbes
                    </a>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Panel administrativo</p>
                </div>

                @auth
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-2xl bg-slate-300 dark:bg-slate-700 flex items-center justify-center text-xl font-bold text-slate-600 dark:text-slate-300">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Hola, {{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Administrador</p>
                            </div>
                        </div>
                    </div>
                @endauth

                <nav class="px-4 py-6 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-slate-900 bg-slate-100 dark:text-white dark:bg-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-black/20' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-sky-500 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') ?? '#' }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-slate-900 bg-slate-100 dark:text-white dark:bg-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-black/20' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl {{ request()->routeIs('admin.users.*') ? 'bg-sky-500 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </span>
                        Usuarios
                    </a>
                    <a href="{{ route('admin.reservations.index') ?? '#' }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.reservations.*') ? 'text-slate-900 bg-slate-100 dark:text-white dark:bg-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-black/20' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl {{ request()->routeIs('admin.reservations.*') ? 'bg-sky-500 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </span>
                        Reservas
                    </a>
                    <a href="{{ route('admin.settings.index') ?? '#' }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'text-slate-900 bg-slate-100 dark:text-white dark:bg-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-black/20' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl {{ request()->routeIs('admin.settings.*') ? 'bg-sky-500 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        Configuración
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </span>
                        Ver sitio web
                    </a>
                </nav>

                @auth
                    <div class="mt-auto px-4 pb-6">
                        <form action="{{ route('logout') }}" method="POST" class="space-y-3">
                            @csrf
                            <button type="submit" class="w-full rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                @endauth
            </aside>

            <main class="flex-1 p-6 lg:p-8">
                @if (isset($header))
                    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-sky-600 dark:text-sky-400 font-semibold">Panel</p>
                            <h1 class="mt-2 text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $header }}</h1>
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
