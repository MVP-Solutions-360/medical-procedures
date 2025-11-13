@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $featuredImage = $procedure->featured_image_path ? Storage::url($procedure->featured_image_path) : null;
    $videoSource = $procedure->video_path ? Storage::url($procedure->video_path) : null;
    $gallerySlides = $procedure->images
        ->map(
            fn($image) => [
                'url' => Storage::url($image->url),
                'description' => $image->description ?? null,
            ],
        )
        ->values();
    $riskLevel = Str::lower($procedure->risk_level ?? 'medio');
    $riskClasses = [
        'alto' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200',
        'medio' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-200',
        'bajo' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-200',
    ];
    $statusClasses = $procedure->is_active
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200'
        : 'bg-slate-100 text-slate-700 dark:bg-slate-800/60 dark:text-slate-200';
@endphp

<div class="space-y-8">

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.index')">
            Procedimientos
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.show', $procedure)">
            {{ $procedure->name }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-wrap items-center gap-4 justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-gray-500 dark:text-gray-400">Procedimiento</p>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                {{ $procedure->name }}
            </h1>
            <div class="mt-3 flex flex-wrap gap-2">
                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-200">
                    {{ $procedure->category ?? 'Sin categoría' }}
                </span>
                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $riskClasses[$riskLevel] ?? $riskClasses['medio'] }}">
                    Riesgo: {{ ucfirst($procedure->risk_level ?? 'Medio') }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                    {{ $procedure->is_active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <flux:button variant="ghost" href="{{ route('procedure.index') }}">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Volver
            </flux:button>
            <flux:button variant="primary" href="{{ route('procedure.edit', $procedure) }}">
                <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                Editar
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div
                class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                @if ($featuredImage)
                    <div class="h-64 md:h-80 bg-cover bg-center"
                        style="background-image: url('{{ $featuredImage }}');">
                        <div class="h-full w-full bg-gradient-to-t from-black/70 to-black/10 flex items-end p-6">
                            <div>
                                <p class="text-sm text-white/80">Imagen principal</p>
                                <p class="text-lg font-medium text-white">{{ $procedure->name }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="h-64 md:h-80 flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                        <x-heroicon-o-photo class="w-10 h-10 mr-3" />
                        No hay imagen principal cargada.
                    </div>
                @endif
                <div class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Descripción general</h2>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $procedure->summary ?? 'Aún no se ha definido un resumen.' }}
                    </p>
                    <div class="prose prose-gray dark:prose-invert max-w-none text-sm leading-6">
                        {!! nl2br(e($procedure->description ?? 'Sin descripción detallada.')) !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="space-y-6">
            <div
                class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detalles clínicos</h3>
                <dl class="grid grid-cols-1 gap-3 text-sm text-gray-600 dark:text-gray-300">
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500 dark:text-gray-400">Anestesia</dt>
                        <dd>{{ $procedure->anesthesia ?? 'No definida' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500 dark:text-gray-400">Hospitalización</dt>
                        <dd>{{ $procedure->hospitalization ?? 'No aplica' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500 dark:text-gray-400">Tiempo de cirugía</dt>
                        <dd>
                            @if ($procedure->surgery_time_min || $procedure->surgery_time_max)
                                {{ $procedure->surgery_time_min ?? '?' }} - {{ $procedure->surgery_time_max ?? '?' }}
                                min
                            @else
                                Sin definir
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500 dark:text-gray-400">Recuperación inicial</dt>
                        <dd>{{ $procedure->initial_recovery_weeks ? $procedure->initial_recovery_weeks . ' semanas' : 'Sin definir' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500 dark:text-gray-400">Resultados finales</dt>
                        <dd>{{ $procedure->final_results_weeks ? $procedure->final_results_weeks . ' semanas' : 'Sin definir' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div
                class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Metadatos</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Información adicional para catálogos y SEO.
                        </p>
                    </div>
                    <flux:button variant="ghost" size="sm"
                        wire:click="$dispatch('open-add-item', { type: 'metadata', procedureId: {{ $procedure->id }} })">
                        <x-heroicon-o-plus class="w-4 h-4 mr-1" />
                        Agregar
                    </flux:button>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse ($procedure->metadata as $meta)
                        <span
                            class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200">
                            {{ $meta->key ?? 'Meta' }}: <span class="font-semibold">{{ $meta->value ?? '—' }}</span>
                        </span>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No registraste metadatos aún.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 space-y-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Multimedia</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Carrusel de imágenes y video del
                    procedimiento.</p>
            </div>
        </div>
        <div class="grid grid-cols-3 xl:grid-cols-3 gap-6">
            <div class="relative" x-data="{ active: 0, slides: @js($gallerySlides) }">
                <template x-if="slides.length === 0">
                    <div
                        class="h-60 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-xl text-gray-500 dark:text-gray-400">
                        <x-heroicon-o-photo class="w-8 h-8 mr-2" />
                        No hay imágenes en la galería.
                    </div>
                </template>
                <template x-if="slides.length > 0">
                    <div class="relative">
                        <div class="h-120 rounded-xl overflow-hidden bg-gray-900/10">
                            <template x-for="(slide, index) in slides" :key="index">
                                <img x-show="active === index" :src="slide.url"
                                    :alt="slide.description ?? 'Imagen del procedimiento'"
                                    class="h-120 w-full object-cover transition-opacity duration-500" x-cloak>
                            </template>
                        </div>
                        <button type="button"
                            class="absolute inset-y-0 left-0 px-3 text-white/90 hover:text-white focus:outline-none"
                            @click="active = active === 0 ? slides.length - 1 : active - 1" x-show="slides.length > 1">
                            <x-heroicon-o-chevron-left class="w-7 h-7 drop-shadow" />
                        </button>
                        <button type="button"
                            class="absolute inset-y-0 right-0 px-3 text-white/90 hover:text-white focus:outline-none"
                            @click="active = (active + 1) % slides.length" x-show="slides.length > 1">
                            <x-heroicon-o-chevron-right class="w-7 h-7 drop-shadow" />
                        </button>
                        <div class="absolute bottom-3 inset-x-0 flex justify-center gap-2">
                            <template x-for="(slide, index) in slides" :key="'dot-' + index">
                                <span class="w-2.5 h-2.5 rounded-full border border-white/70"
                                    :class="active === index ? 'bg-white' : 'bg-white/30'"
                                    @click="active = index"></span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="py-2">
                @if ($videoSource)
                    <div class="relative rounded-xl overflow-hidden bg-black">
                        <video controls class="w-full h-120 object-cover">
                            <source src="{{ $videoSource }}" type="video/mp4">
                            Tu navegador no soporta la reproducción de video.
                        </video>
                    </div>
                @else
                    <div
                        class="h-60 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-xl text-gray-500 dark:text-gray-400">
                        <x-heroicon-o-play class="w-8 h-8 mr-2" />
                        Aún no se ha cargado un video.
                    </div>
                @endif
                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    Actualizado el {{ $procedure->updated_at?->translatedFormat('d M Y') ?? 'N/A' }}.
                </p>
            </div>
            <div>
                @if ($procedure->images->count())
                    <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($procedure->images as $image)
                            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img src="{{ Storage::url($image->url) }}" alt="Imagen"
                                    class="h-24 w-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Elementos relacionados</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Gestiona secciones, indicaciones y demás componentes del procedimiento desde aquí.
                </p>
            </div>
        </div>

        @php
            $relationBlocks = [
                [
                    'title' => 'Secciones',
                    'description' => 'Estructura narrativa del procedimiento.',
                    'items' => $procedure->sections,
                    'type' => 'sections',
                ],
                [
                    'title' => 'Técnicas',
                    'description' => 'Métodos o tecnologías empleadas.',
                    'items' => $procedure->techniques,
                    'type' => 'techniques',
                ],
                [
                    'title' => 'Indicaciones',
                    'description' => 'Criterios clínicos y motivos.',
                    'items' => $procedure->indications,
                    'type' => 'indications',
                ],
                [
                    'title' => 'Cuidados preoperatorios',
                    'description' => 'Recomendaciones antes del procedimiento.',
                    'items' => $procedure->preop,
                    'type' => 'preop',
                ],
                [
                    'title' => 'Cuidados postoperatorios',
                    'description' => 'Seguimiento posterior y cuidados.',
                    'items' => $procedure->postop,
                    'type' => 'postop',
                ],
                [
                    'title' => 'Extras',
                    'description' => 'Información complementaria (FAQ, tips).',
                    'items' => $procedure->extras,
                    'type' => 'extras',
                ],
                [
                    'title' => 'Riesgos',
                    'description' => 'Posibles complicaciones y alertas.',
                    'items' => $procedure->risks,
                    'type' => 'risks',
                ],
                [
                    'title' => 'Galería',
                    'description' => 'Administración de imágenes adicionales.',
                    'items' => $procedure->images,
                    'type' => 'images',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($relationBlocks as $block)
                <div
                    class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-5 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $block['title'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $block['description'] }}</p>
                        </div>
                        <div class="flex gap-2">
                            <flux:button variant="ghost" size="sm"
                                wire:click="$dispatch('open-add-item', { type: '{{ $block['type'] }}', procedureId: {{ $procedure->id }} })">
                                <x-heroicon-o-plus class="w-4 h-4" />
                            </flux:button>
                            <flux:button variant="ghost" size="sm" href="#">
                                <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                            </flux:button>
                        </div>
                    </div>
                    <div class="flex-1 space-y-4 overflow-hidden max-h-64 overflow-y-auto pr-1">
                        @forelse ($block['items']->take(4) as $item)
                            @php
                                $heading = $item->title ?? ($item->name ?? ($item->label ?? 'Sin título'));
                                $body =
                                    $item->summary ??
                                    ($item->description ?? ($item->content ?? ($item->value ?? null)));
                            @endphp
                            <div
                                class="rounded-xl border border-gray-100 dark:border-gray-800 p-3 bg-gray-50/70 dark:bg-gray-800/50">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $heading }}
                                    </p>
                                    @if (isset($item->order) && $item->order)
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400">#{{ $item->order }}</span>
                                    @endif
                                </div>
                                @if ($body)
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($body, 140) }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Aún no registras elementos en esta sección.
                            </p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
