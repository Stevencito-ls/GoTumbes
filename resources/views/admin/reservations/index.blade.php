<x-admin-layout>
    <x-slot name="header">
        Gestión de Reservas
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-emerald-900/50 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl shadow-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-rose-900/50 border border-rose-500/30 text-rose-400 p-4 rounded-xl shadow-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
            <div>
                <h3 class="text-lg font-bold text-white">Todas las Reservas</h3>
                <p class="text-sm text-slate-400 mt-1">Historial de compras realizadas por los clientes</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/50 border-b border-slate-700 text-slate-400">
                    <tr>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs">ID</th>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs">Cliente</th>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs">Tour y Fecha</th>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs">Monto</th>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs">Pago (Estado)</th>
                        <th class="px-4 py-4 font-semibold uppercase tracking-wider text-xs text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($reservations as $res)
                    <tr class="hover:bg-slate-700/30 transition-colors group">
                        <td class="px-4 py-4">
                            <span class="font-mono text-xs text-slate-400">{{ substr($res['id'], 0, 8) }}...</span>
                            <div class="text-[10px] text-slate-500 mt-1">{{ isset($res['created_at']) ? date('d/m/Y H:i', $res['created_at']) : '' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-white">{{ $res['customer_name'] ?? 'N/A' }}</div>
                            <div class="text-slate-400 text-xs">{{ $res['customer_email'] ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-medium text-slate-300">{{ preg_replace('/([a-z])([A-Z])/s', '$1 $2', $res['destination_title'] ?? 'Sin título') }}</div>
                            <div class="text-teal-400 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $res['reservation_date'] ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="inline-flex items-center px-2 py-1 rounded bg-slate-700/50 text-slate-300 font-bold text-xs mb-1">
                                {{ $res['tickets'] ?? 0 }} Tickets
                            </div>
                            <div class="text-emerald-400 font-bold">
                                S/ {{ number_format($res['total_paid'] ?? ($res['total'] ?? ($res['price'] ?? 0)), 2) }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="uppercase text-[10px] font-bold tracking-wider px-2 py-0.5 rounded bg-blue-900/50 text-blue-400 border border-blue-500/30">
                                    {{ $res['payment_method'] ?? 'Stripe' }}
                                </span>
                                @if(isset($res['operation_number']))
                                <span class="text-xs text-slate-400 font-mono">Op: {{ $res['operation_number'] }}</span>
                                @endif
                            </div>
                            
                            @php
                                $status = $res['status'] ?? 'paid';
                            @endphp
                            
                            @if($status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-orange-900/30 text-orange-400 text-xs font-medium border border-orange-500/20">
                                    <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Pendiente
                                </span>
                            @elseif($status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-rose-900/30 text-rose-400 text-xs font-medium border border-rose-500/20">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Rechazado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-900/30 text-emerald-400 text-xs font-medium border border-emerald-500/20">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Aprobado
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if(($res['status'] ?? 'paid') === 'pending')
                                    <form action="{{ route('admin.reservations.update_status', $res['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors" title="Aprobar Pago">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reservations.update_status', $res['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors" title="Rechazar Pago">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('destinations.voucher', $res['id']) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded bg-slate-700 text-slate-300 hover:bg-slate-600 hover:text-white transition-colors" title="Ver Voucher PDF">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700 mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <h4 class="text-white font-bold mb-1">No hay reservas todavía</h4>
                            <p class="text-slate-400 text-sm">Las compras de los usuarios aparecerán aquí.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
