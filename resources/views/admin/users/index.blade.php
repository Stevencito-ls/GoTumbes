<x-admin-layout>
    <x-slot name="header">
        Gestión de Usuarios (Firebase)
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-800/50 text-xs uppercase text-slate-700 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4 font-medium">Nombre</th>
                        <th class="px-6 py-4 font-medium">Email</th>
                        <th class="px-6 py-4 font-medium">Rol Actual</th>
                        <th class="px-6 py-4 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                                {{ $user['name'] ?? 'Sin Nombre' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user['email'] ?? 'Sin Email' }}
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($user['role']) && $user['role'] === 'admin')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-900/30 dark:text-sky-400">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.users.update_role', $user['id']) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <select name="role" class="rounded-lg border-slate-300 text-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900">
                                        <option value="user" {{ (isset($user['role']) && $user['role'] == 'user') ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ (isset($user['role']) && $user['role'] == 'admin') ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200 transition">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
