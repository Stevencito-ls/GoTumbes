<x-admin-layout>
    <x-slot name="header">
        Dashboard Administrador - GoTumbes
    </x-slot>

    <!-- Top Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 p-6 flex items-center justify-between group hover:shadow-xl transition-shadow">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Destinos</p>
                <h3 class="text-3xl font-black text-white">{{ count($destinations) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <!-- Placeholder Stats -->
        <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 p-6 flex items-center justify-between group hover:shadow-xl transition-shadow">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Reservas</p>
                <h3 class="text-3xl font-black text-white">{{ $reservationsCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 p-6 flex items-center justify-between group hover:shadow-xl transition-shadow">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Ingresos</p>
                <h3 class="text-3xl font-black text-white">S/ {{ number_format($totalIncome, 2) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Chart Row -->
    <div class="mb-8 bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
            <h3 class="text-lg font-bold text-white">Ingresos por Destino</h3>
            <p class="text-sm text-slate-400 mt-1">Análisis de ventas basado en reservas actuales</p>
        </div>
        <div class="p-6">
            <canvas id="incomeChart" height="100" data-labels="{{ json_encode($chartLabels) }}" data-chartdata="{{ json_encode($chartData) }}"></canvas>
        </div>
    </div>

    <!-- Mensajes de Sesión -->
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulario de Nuevo Destino -->
        <div class="lg:col-span-1">
            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden sticky top-24">
                <div class="p-6 border-b border-slate-700 bg-slate-800/50">
                    <h3 class="text-lg font-bold text-white">Agregar Destino</h3>
                    <p class="text-sm text-slate-400 mt-1">Registra un nuevo lugar en Firebase</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Título</label>
                            <input type="text" name="title" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Precio (S/)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-medium">S/</span>
                                    <input type="number" name="price" required class="block w-full pl-9 rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Categoría</label>
                                <select name="category" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                                    <option value="Playa">Playa</option>
                                    <option value="Aventura">Aventura</option>
                                    <option value="Cultura">Cultura</option>
                                    <option value="Naturaleza">Naturaleza</option>
                                    <option value="Ciudad">Ciudad</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Descripción</label>
                            <textarea name="description" rows="3" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Imagen</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-600 border-dashed rounded-xl hover:border-teal-400 hover:bg-teal-900/20 transition-colors group cursor-pointer" onclick="document.getElementById('file-upload').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-500 group-hover:text-teal-400 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-400 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-teal-400 hover:text-teal-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-400 bg-transparent">
                                            <span>Subir archivo</span>
                                            <input id="file-upload" name="image" type="file" class="sr-only">
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, GIF hasta 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">¿Qué incluye el paquete?</label>
                            <textarea name="included" rows="2" placeholder="Ej: Transporte, Almuerzo, Guía..." class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors resize-none"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Máx. Personas</label>
                                <input type="number" name="max_people" min="1" placeholder="Ej: 15" class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                            </div>
                            <div class="flex items-center justify-center mt-6">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="disabled_access" class="w-5 h-5 text-teal-500 bg-slate-900 border-slate-600 rounded focus:ring-teal-400 focus:ring-offset-slate-800 transition-colors">
                                    <span class="text-sm font-semibold text-slate-300 group-hover:text-white transition-colors">Acceso Discapacitados</span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full mt-6 py-3 px-4 rounded-xl shadow-lg shadow-teal-500/20 text-sm font-bold text-slate-900 bg-teal-400 hover:bg-teal-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-400 focus:ring-offset-slate-800 transform transition-all hover:-translate-y-0.5">
                            Guardar Destino
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de Destinos -->
        <div class="lg:col-span-2">
            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                    <div>
                        <h3 class="text-lg font-bold text-white">Directorio de Destinos</h3>
                        <p class="text-sm text-slate-400 mt-1">Lista actual en Cloud Firestore</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-900/50 border-b border-slate-700 text-slate-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Destino</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Precio</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($destinations as $dest)
                            <tr class="hover:bg-slate-700/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-14 h-14 rounded-xl overflow-hidden shadow-sm flex-shrink-0 group-hover:shadow-md transition-shadow">
                                            <img src="{{ $dest['image_url'] ?? 'https://images.unsplash.com/photo-1596395819057-cb378328dcce?q=80&w=200&auto=format&fit=crop' }}" class="w-full h-full object-cover" alt="Destino">
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-base">{{ preg_replace('/([a-z])([A-Z])/s', '$1 $2', $dest['title'] ?? 'Sin título') }}</div>
                                            <div class="text-slate-400 text-xs truncate max-w-[200px] mt-0.5">{{ $dest['description'] ?? 'Sin descripción' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-teal-500/10 text-teal-400 font-bold border border-teal-500/20">
                                        S/ {{ $dest['price'] ?? '0' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 transition-opacity">
                                        <button data-id="{{ $dest['id'] ?? '' }}" 
                                                data-title="{{ $dest['title'] ?? '' }}" 
                                                data-price="{{ $dest['price'] ?? '' }}" 
                                                data-description="{{ $dest['description'] ?? '' }}" 
                                                data-category="{{ $dest['category'] ?? '' }}"
                                                data-included="{{ $dest['included'] ?? '' }}"
                                                data-max_people="{{ $dest['max_people'] ?? '' }}"
                                                data-disabled_access="{{ !empty($dest['disabled_access']) ? '1' : '0' }}"
                                                onclick="editDestination(this)" 
                                                class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-colors" title="Editar">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        
                                        <form action="{{ route('admin.destinations.destroy', $dest['id']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-colors" onclick="return confirm('¿Seguro que deseas eliminar este destino?')" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700 mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">No hay destinos registrados</h4>
                                    <p class="text-slate-400 text-sm">Empieza agregando un nuevo destino en el formulario lateral.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-white mb-4" id="modal-title">Editar Destino</h3>
                    <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Título</label>
                            <input type="text" id="edit_title" name="title" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Precio (S/)</label>
                                <input type="number" id="edit_price" name="price" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Categoría</label>
                                <select id="edit_category" name="category" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                                    <option value="Playa">Playa</option>
                                    <option value="Aventura">Aventura</option>
                                    <option value="Cultura">Cultura</option>
                                    <option value="Naturaleza">Naturaleza</option>
                                    <option value="Ciudad">Ciudad</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Descripción</label>
                            <textarea id="edit_description" name="description" rows="3" required class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">¿Qué incluye?</label>
                            <textarea id="edit_included" name="included" rows="2" class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-1">Máx. Personas</label>
                                <input type="number" id="edit_max_people" name="max_people" min="1" class="block w-full rounded-xl border-slate-600 bg-slate-900 text-white placeholder-slate-500 shadow-sm focus:border-teal-400 focus:ring-teal-400 transition-colors">
                            </div>
                            <div class="flex items-center justify-center mt-6">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" id="edit_disabled_access" name="disabled_access" class="w-5 h-5 text-teal-500 bg-slate-900 border-slate-600 rounded focus:ring-teal-400 focus:ring-offset-slate-800 transition-colors">
                                    <span class="text-sm font-semibold text-slate-300 group-hover:text-white transition-colors">Acceso Discapacitados</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1">Nueva Imagen (Opcional)</label>
                            <input type="file" name="image" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-teal-500/10 file:text-teal-400 hover:file:bg-teal-500/20">
                        </div>
                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" onclick="closeEditModal()" class="py-2 px-4 rounded-xl font-bold text-slate-300 hover:bg-slate-700 transition-colors">Cancelar</button>
                            <button type="submit" class="py-2 px-6 rounded-xl shadow-lg shadow-teal-500/20 font-bold text-slate-900 bg-teal-400 hover:bg-teal-300 transition-colors">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('incomeChart');
            const ctx = canvas.getContext('2d');
            
            const labels = JSON.parse(canvas.dataset.labels || '[]');
            const data = JSON.parse(canvas.dataset.chartdata || '[]');
            
            if (labels.length === 0) {
                // Dummy data if empty
                labels.push('Playa', 'Aventura', 'Cultura');
                data.push(0, 0, 0);
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ingresos (S/)',
                        data: data,
                        backgroundColor: 'rgba(45, 212, 191, 0.2)', // teal-400 with opacity
                        borderColor: 'rgba(45, 212, 191, 1)', // teal-400
                        borderWidth: 2,
                        borderRadius: 8,
                        hoverBackgroundColor: 'rgba(45, 212, 191, 0.4)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'transparent'
                            },
                            ticks: {
                                color: '#94a3b8' // slate-400
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                borderColor: 'transparent'
                            },
                            ticks: {
                                color: '#94a3b8' // slate-400
                            }
                        }
                    }
                }
            });
        });

        window.editDestination = function(btn) {
            const id = btn.dataset.id;
            document.getElementById('editForm').action = `/admin/destinations/${id}`;
            document.getElementById('edit_title').value = btn.dataset.title;
            document.getElementById('edit_price').value = btn.dataset.price;
            document.getElementById('edit_description').value = btn.dataset.description;
            if(btn.dataset.category) {
                document.getElementById('edit_category').value = btn.dataset.category;
            }
            document.getElementById('edit_included').value = btn.dataset.included;
            document.getElementById('edit_max_people').value = btn.dataset.max_people;
            document.getElementById('edit_disabled_access').checked = btn.dataset.disabled_access === '1';
            
            document.getElementById('editModal').classList.remove('hidden');
        }

        window.closeEditModal = function() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>
