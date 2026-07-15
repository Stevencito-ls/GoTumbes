<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <meta name="view-transition" content="same-origin">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950 min-h-screen flex items-center justify-center p-4 relative">
        
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-teal-900/20 blur-[120px]"></div>
            <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-emerald-900/10 blur-[100px]"></div>
        </div>

        <div class="w-full max-w-4xl bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-teal-900/10 rounded-3xl flex flex-col md:flex-row overflow-hidden min-h-[550px] max-h-[90vh] border border-slate-800/60 relative z-10">
            
            <!-- Left Side (Teal Panel) -->
            <div class="md:w-5/12 bg-gradient-to-br from-teal-600 to-emerald-700 p-8 lg:p-10 hidden md:flex flex-col justify-between relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-black opacity-10 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <!-- Logo & Title -->
                    <a href="/" class="flex items-center gap-3 mb-8 group">
                        <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-10 w-auto group-hover:scale-110 transition-transform drop-shadow-md">
                        <span class="text-2xl font-black tracking-tighter text-white">Go<span class="text-emerald-200">Tumbes</span></span>
                    </a>
                    
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 leading-tight">Las mejores<br>maravillas del<br>norte</h1>
                    <p class="text-teal-50 mb-8 leading-relaxed font-medium">
                        Inicia sesión para disfrutar de una experiencia de turismo más rápida y personalizada.
                    </p>
                    
                    <ul class="space-y-4 text-teal-50 font-medium text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Reservas en línea rápidas
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Múltiples métodos de pago
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Historial de viajes
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Compra segura solo con cuenta registrada
                        </li>
                    </ul>
                </div>
                
                <div class="text-xs text-teal-200/60 font-medium relative z-10">
                    &copy; {{ date('Y') }} GoTumbes. Todos los derechos reservados.
                </div>
            </div>
            
            <!-- Right Side (Forms) -->
            <div class="w-full md:w-7/12 p-8 md:p-10 flex flex-col h-full bg-slate-900/50 overflow-y-auto custom-scrollbar">
                <!-- Mobile Logo -->
                <div class="md:hidden flex items-center gap-2 mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-8 w-auto">
                    <span class="text-2xl font-black tracking-tighter text-white">Go<span class="text-teal-500">Tumbes</span></span>
                </div>
                
                <!-- Tabs -->
                <div class="flex border-b border-slate-800 mb-8 gap-2">
                    <a href="{{ route('login') }}" class="px-2 pb-3 mr-4 font-bold text-sm transition-all relative {{ request()->routeIs('login') ? 'text-white' : 'text-slate-500 hover:text-slate-300' }}">
                        Ingresar
                        @if(request()->routeIs('login'))
                            <span class="absolute bottom-[-1px] left-0 w-full h-[2px] bg-teal-500"></span>
                        @endif
                    </a>
                    <a href="{{ route('register') }}" class="px-2 pb-3 font-bold text-sm transition-all relative {{ request()->routeIs('register') ? 'text-white' : 'text-slate-500 hover:text-slate-300' }}">
                        Registrarse
                        @if(request()->routeIs('register'))
                            <span class="absolute bottom-[-1px] left-0 w-full h-[2px] bg-teal-500"></span>
                        @endif
                    </a>
                </div>
                
                <!-- Slot Content (Login/Register Form) -->
                <div class="flex-grow flex flex-col justify-center">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #334155; 
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #475569; 
            }
        </style>
    </body>
</html>
