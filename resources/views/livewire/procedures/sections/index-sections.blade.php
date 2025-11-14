@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/procedures.css') }}">
    @endpush
@endonce

@php
    use Illuminate\Support\Str;
@endphp

<div class="procedure-layout">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.show', $procedure)">
            {{ $procedure->name }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Secciones</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="h-1 w-full bg-black dark:bg-gray-400 rounded"></div>

    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Secciones del procedimiento</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gestiona cada bloque de preguntas y respuestas asociado a este procedimiento.
            </p>
        </div>
        <flux:button variant="primary" href="{{ route('sections.create', $procedure) }}">
            <i class="fas fa-plus mr-1"></i>
            Agregar sección
        </flux:button>
    </div>

    <div class="grid grid-cols-1">
        <div class="procedure-card">
            <div class="procedure-card__header">
                <div>
                    <h2 class="procedure-card__title">Listado de secciones</h2>
                    <p class="procedure-card__subtitle">
                        Orden, título y resumen del contenido principal de cada sección.
                    </p>
                </div>
                @if (session('message'))
                    <span class="procedure-message">
                        {{ session('message') }}
                    </span>
                @endif
            </div>

            <div class="procedure-card__body">
                <div class="overflow-x-auto">
                    <table class="procedure-table">
                        <thead>
                            <tr>
                                <th>
                                    Orden
                                </th>
                                <th>
                                    Título
                                </th>
                                <th>
                                    Descripción
                                </th>
                                <th class="text-right">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sections as $section)
                                @php
                                    $summary = optional($section->contents->first())->content;
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/70 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">#{{ $section->order }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $section->title }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $summary ? Str::limit($summary, 100) : 'Sin descripción' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('sections.show', ['procedure' => $procedure, 'section' => $section]) }}"
                                                class="p-2 text-blue-600 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                                title="Ver sección">
                                                <x-heroicon-o-eye class="w-4 h-4" />
                                            </a>
                                            <a href="{{ route('sections.edit', ['procedure' => $procedure, 'section' => $section]) }}"
                                                class="p-2 text-green-600 hover:bg-green-100 dark:text-green-400 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                                title="Editar sección">
                                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                                            </a>
                                            <button type="button"
                                                x-data
                                                x-on:click.prevent="if(confirm('¿Eliminar la sección {{ $section->title }}?')) { $wire.deleteSection({{ $section->id }}) }"
                                                class="p-2 text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                                wire:loading.attr="disabled"
                                                title="Eliminar sección">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Aún no hay secciones registradas para este procedimiento.
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
