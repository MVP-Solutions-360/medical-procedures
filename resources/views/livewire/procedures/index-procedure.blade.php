<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.index')">
            Procedimientos
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="h-1 w-full bg-black dark:bg-gray-400 rounded my-4"></div>
    <!-- Listado -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Procedimientos</h1>
        <flux:button variant="primary">
            <a href="{{ route('procedure.create') }}">
                <i class="fas fa-plus mr-1"></i>
                Agregar procedimiento
            </a>
        </flux:button>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="bg-white dark:bg-gray-900/40 rounded-xl shadow border border-gray-100 dark:border-gray-800">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Procedimientos</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Listado general de procedimientos registrados.</p>
                </div>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Procedimiento
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Categoría
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Riesgo
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse(($procedures ?? []) as $procedure)
                                @php
                                    $riskLevel = strtolower($procedure->risk_level ?? '');
                                    $riskColors = match ($riskLevel) {
                                        'alto', 'high' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                        'medio', 'medium' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300',
                                        default => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('procedure.show', ['procedure' => $procedure->slug ?? $procedure]) }}"
                                               class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                                {{ $procedure->name ?? 'Sin nombre' }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Illuminate\Support\Str::limit($procedure->summary ?? 'Sin descripción disponible', 70) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $procedure->category ?? 'Sin categoría' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $riskColors }}">
                                            {{ $procedure->risk_level ?? 'Bajo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('procedure.show', ['procedure' => $procedure->slug ?? $procedure]) }}"
                                               class="p-2 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                               title="Ver detalles">
                                                <x-heroicon-o-eye class="w-4 h-4" />
                                            </a>
                                            <a href="{{ route('procedure.edit', ['procedure' => $procedure->slug ?? $procedure]) }}"
                                               class="p-2 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                               title="Editar">
                                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay procedimientos disponibles por ahora.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
