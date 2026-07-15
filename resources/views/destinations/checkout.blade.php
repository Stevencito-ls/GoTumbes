<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $destination['title'] }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/destinations.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-slate-900 text-slate-100 selection:bg-teal-500 selection:text-white pb-20">

    <!-- Top Navigation -->
    <nav class="w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-black tracking-tighter text-white flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="GoTumbes Logo" class="h-8 w-auto">
                <a href="{{ url('/') }}">Go<span class="text-teal-500">Tumbes</span></a>
            </div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-slate-300">
                <a href="{{ url('/') }}" class="hover:text-teal-400 transition-colors">Inicio</a>
                <a href="{{ route('destinations.index') }}" class="hover:text-teal-400 transition-colors">Destinos</a>
                <a href="{{ route('about') }}" class="hover:text-teal-400 transition-colors">Nosotros</a>
                <a href="{{ route('services') }}" class="hover:text-teal-400 transition-colors">Servicios</a>
                <a href="{{ route('contact') }}" class="hover:text-teal-400 transition-colors">Contacto</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('destinations.show', $destination['id']) }}" class="text-sm font-semibold text-slate-400 hover:text-teal-400 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Tour
                </a>
            </div>
        </div>
    </nav>

    <!-- Error/Success Messages -->
    <div class="max-w-4xl mx-auto px-6 mt-8">
        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500 text-rose-500 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 mt-8">
        <h1 class="text-3xl font-bold mb-8">Confirmar Reserva</h1>

        <form action="{{ route('destinations.process_checkout', $destination['id']) }}" method="POST" id="checkout-form" class="grid grid-cols-1 md:grid-cols-3 gap-8" autocomplete="off">
            @csrf

            <!-- Left: Payment Form -->
            <div class="md:col-span-2 flex flex-col gap-8">
                
                <!-- Personal Info -->
                <section class="bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-lg">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-white">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Información Personal
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Nombre Completo</label>
                            <input type="text" name="name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            @error('name') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Correo Electrónico</label>
                            <input type="email" name="email" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            @error('email') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Fecha de Reserva</label>
                            <input type="date" name="reservation_date" min="{{ date('Y-m-d') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent [color-scheme:dark]">
                            @error('reservation_date') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>

                <!-- Payment Details -->
                <section class="bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-lg">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-white">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Pago Manual (Yape / Plin)
                    </h2>
                    
                    <div class="mb-6 bg-slate-900/50 p-6 rounded-2xl border border-slate-700 text-center">
                        <p class="text-sm text-slate-400 mb-4">Para confirmar tu reserva, transfiere el monto total a este número y anota el número de operación.</p>
                        
                        <div class="text-3xl font-black text-white mb-2 tracking-widest">999 999 999</div>
                        <p class="text-teal-400 font-medium">A nombre de: Agencia GoTumbes EIRL</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Método utilizado</label>
                            <select name="payment_method" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Número de Operación</label>
                            <input type="text" name="operation_number" placeholder="Ej: 12345678" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent font-mono uppercase">
                            <p class="text-xs text-slate-500 mt-1">Ingresa el código que aparece en tu comprobante de pago.</p>
                            @error('operation_number') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right: Order Summary -->
            <div class="md:col-span-1">
                <div class="bg-slate-800 p-6 rounded-3xl border border-slate-700 shadow-lg sticky top-24">
                    <h3 class="font-bold text-white text-lg mb-4">Resumen</h3>
                    
                    <div class="flex gap-4 mb-6 pb-6 border-b border-slate-700">
                        <img src="{{ $destination['image_url'] ?? '' }}" alt="" class="w-20 h-20 object-cover rounded-xl shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-white leading-tight">{{ preg_replace('/([a-z])([A-Z])/s', '$1 $2', $destination['title']) }}</h4>
                            <p class="text-teal-400 font-semibold mt-1">S/ <span id="unit-price">{{ $destination['price'] }}</span></p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Cantidad de Personas (Tickets)</label>
                            <input type="number" name="tickets" id="tickets" value="1" min="1" max="{{ $destination['max_people'] ?? 10 }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-slate-700">
                            <span class="text-slate-400 font-medium">Total a pagar</span>
                            <span class="text-2xl font-black text-white">S/ <span id="total-price">{{ $destination['price'] }}</span></span>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full flex items-center justify-center gap-2 py-4 px-6 rounded-2xl text-slate-900 font-bold bg-teal-400 hover:bg-teal-300 transition-transform hover:-translate-y-0.5 shadow-lg shadow-teal-500/30 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <svg id="btn-spinner" class="w-5 h-5 hidden animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span id="btn-text">Pagar y Reservar</span>
                    </button>
                    <p class="text-xs text-center text-slate-500 mt-4">Transacción segura. Pago protegido.</p>
                </div>
            </div>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketInput = document.getElementById('tickets');
            const unitPrice = parseFloat(document.getElementById('unit-price').innerText);
            const totalPriceEl = document.getElementById('total-price');

            ticketInput.addEventListener('input', function() {
                let tickets = parseInt(this.value) || 1;
                let max = parseInt(this.getAttribute('max')) || 10;
                
                if (tickets < 1) { tickets = 1; this.value = 1; }
                if (tickets > max) { tickets = max; this.value = max; }

                totalPriceEl.innerText = (tickets * unitPrice).toFixed(2);
            });

            // Handle Form Submit Loading State
            const form = document.getElementById('checkout-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnIcon = document.getElementById('btn-icon');
            const btnSpinner = document.getElementById('btn-spinner');
            const btnText = document.getElementById('btn-text');

            form.addEventListener('submit', function(e) {
                // Prevent multiple submissions
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                btnIcon.classList.add('hidden');
                btnSpinner.classList.remove('hidden');
                btnText.innerText = 'Procesando Reserva...';
            });
        });
    </script>
</body>
</html>
