@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/procedures.css') }}">
    @endpush
@endonce

@php
    use Illuminate\Support\Str;
    $mainContent = optional($section->contents->first())->content;
@endphp

<div class="procedure-layout">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.show', $procedure)">
            {{ $procedure->name }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Detalle de sección</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="procedure-card">
        <div class="procedure-card__header">
            <div>
                <p class="procedure-card__subtitle">Sección del procedimiento</p>
                <h1 class="procedure-card__title">{{ $section->title }}</h1>
            </div>
            <flux:button variant="ghost" href="{{ route('sections.index', $procedure) }}">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Volver al listado
            </flux:button>
        </div>

        <div class="procedure-card__body space-y-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wide">Resumen</h3>
                <p class="mt-2 text-base text-gray-800 dark:text-gray-200">
                    {{ $mainContent ?? 'Sin descripción registrada.' }}
                </p>
            </div>

            @if ($section->contents->count() > 1)
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wide">
                        Contenido adicional
                    </h3>
                    <div class="space-y-2">
                        @foreach ($section->contents->skip(1) as $content)
                            <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-800/40">
                                <p class="text-sm text-gray-700 dark:text-gray-200">
                                    {{ Str::of($content->content)->limit(250) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
