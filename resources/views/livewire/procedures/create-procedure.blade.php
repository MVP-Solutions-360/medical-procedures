@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/procedures.css') }}">
    @endpush
@endonce

<div class="procedure-layout">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.index')">
            Procedimientos
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="h-1 w-full bg-black dark:bg-gray-400 rounded my-4"></div>
    <!-- Listado -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Agregar procedimiento</h1>
        <flux:button variant="primary">
            <a href="{{ route('procedure.index') }}">
                <i class="fas fa-arrow-left mr-1"></i>
                Regresar
            </a>
        </flux:button>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="procedure-card">
            <div class="procedure-card__header">
                <div>
                    <h2 class="procedure-card__title">Agregar procedimiento</h2>
                </div>
            </div>
            <div class="procedure-card__body">
                <form wire:submit.prevent="create" class="space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <flux:input type="text" label="Nombre" wire:model.defer="name" />
                        <flux:input type="text" label="Categoría" wire:model.defer="category" />
                        <flux:input type="text" label="Anestesia" wire:model.defer="anesthesia" />
                        <flux:input type="text" label="Hospitalización" wire:model.defer="hospitalization" />
                        <flux:input type="number" min="0" label="Tiempo de cirugía (min)" wire:model.defer="surgery_time_min" />
                        <flux:input type="number" min="0" label="Tiempo de cirugía (max)" wire:model.defer="surgery_time_max" />
                        <flux:input type="number" min="0" label="Recuperación inicial (semanas)" wire:model.defer="initial_recovery_weeks" />
                        <flux:input type="number" min="0" label="Resultados finales (semanas)" wire:model.defer="final_results_weeks" />
                        <flux:select label="Nivel de riesgo" wire:model.defer="risk_level">
                            <option value="">Seleccione un nivel de riesgo</option>
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </flux:select>
                        <flux:select label="Estado" wire:model.defer="is_active">
                            <option value="true">Activo</option>
                            <option value="false">Inactivo</option>
                        </flux:select>
                    </div>

                    <div class="space-y-4">
                        <flux:textarea label="Resumen" wire:model.defer="summary" />
                        <flux:textarea label="Descripción" wire:model.defer="description" />
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Multimedia</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Adjunta los archivos que acompañarán al procedimiento.
                        </p>

                        <div class="space-y-6">
                            <div>
                                <flux:label for="main_image">Imagen principal (flyer)</flux:label>
                                <flux:input type="file" id="main_image" wire:model="main_image" accept="image/*" />
                                @error('main_image')
                                    <flux:text class="text-red-500 text-sm">{{ $message }}</flux:text>
                                @enderror
                                @if ($main_image)
                                    <div class="mt-3">
                                        <img src="{{ $main_image->temporaryUrl() }}" alt="Vista previa flyer"
                                            class="w-32 h-32 object-cover rounded border border-gray-200 dark:border-gray-700">
                                    </div>
                                @endif
                            </div>

                            <div>
                                <flux:label for="gallery_images">Galería de imágenes</flux:label>
                                <flux:input type="file" id="gallery_images" wire:model="gallery_images" accept="image/*" multiple />
                                @error('gallery_images')
                                    <flux:text class="text-red-500 text-sm">{{ $message }}</flux:text>
                                @enderror
                                @if ($gallery_images)
                                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        @foreach ($gallery_images as $image)
                                            <img src="{{ $image->temporaryUrl() }}" alt="Vista previa galería"
                                                class="w-24 h-24 object-cover rounded border border-gray-200 dark:border-gray-700">
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div>
                                <flux:label for="procedure_video">Video del procedimiento</flux:label>
                                <flux:input type="file" id="procedure_video" wire:model="procedure_video"
                                    accept="video/mp4,video/quicktime" />
                                @error('procedure_video')
                                    <flux:text class="text-red-500 text-sm">{{ $message }}</flux:text>
                                @enderror
                                @if ($procedure_video)
                                    <div class="mt-3 flex items-center text-sm text-gray-600 dark:text-gray-300">
                                        <x-heroicon-o-play class="w-4 h-4 mr-2" />
                                        {{ $procedure_video->getClientOriginalName() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <flux:button variant="ghost" type="button" wire:click="resetForm">
                            Cancelar
                        </flux:button>
                        <flux:button type="submit" variant="primary" class="cursor-pointer">
                            <x-heroicon-o-cloud-arrow-up class="w-4 h-4 mr-2" />
                            Guardar procedimiento
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
