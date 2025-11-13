@php
    use Illuminate\Support\Facades\Storage;
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
        <flux:breadcrumbs.item :href="route('procedure.edit', $procedure)">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-sm uppercase tracking-wide text-gray-500 dark:text-gray-400">Editar procedimiento</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $procedure->name }}</h1>
        </div>
        <div class="flex gap-3">
            <flux:button variant="ghost" href="{{ route('procedure.show', $procedure) }}">
                <x-heroicon-o-eye class="w-4 h-4 mr-2" />
                Ver detalle
            </flux:button>
            <flux:button variant="ghost" href="{{ route('procedure.index') }}">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Volver al listado
            </flux:button>
        </div>
    </div>

    @if (session()->has('procedure_updated'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
            {{ session('procedure_updated') }}
        </div>
    @endif
    @if (session()->has('media_updated'))
        <div class="rounded-lg border border-sky-200 bg-sky-50 text-sky-800 px-4 py-3 text-sm">
            {{ session('media_updated') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <form wire:submit.prevent="updateProcedure" class="space-y-8">
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
                    <option value="">Seleccione</option>
                    <option value="bajo">Bajo</option>
                    <option value="medio">Medio</option>
                    <option value="alto">Alto</option>
                </flux:select>
                <flux:select label="Estado" wire:model.defer="is_active">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </flux:select>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <flux:textarea label="Resumen" wire:model.defer="summary" rows="5" />
                <flux:textarea label="Descripción" wire:model.defer="description" rows="5" />
            </div>

            <div class="flex flex-wrap gap-3 justify-end">
                <flux:button variant="ghost" type="button" href="{{ route('procedure.show', $procedure) }}">
                    Cancelar
                </flux:button>
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Guardar cambios
                </flux:button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm text-red-500">
                @error('name') <p>{{ $message }}</p> @enderror
                @error('slugInput') <p>{{ $message }}</p> @enderror
                @error('category') <p>{{ $message }}</p> @enderror
                @error('summary') <p>{{ $message }}</p> @enderror
                @error('description') <p>{{ $message }}</p> @enderror
                @error('anesthesia') <p>{{ $message }}</p> @enderror
                @error('hospitalization') <p>{{ $message }}</p> @enderror
                @error('surgery_time_min') <p>{{ $message }}</p> @enderror
                @error('surgery_time_max') <p>{{ $message }}</p> @enderror
                @error('initial_recovery_weeks') <p>{{ $message }}</p> @enderror
                @error('final_results_weeks') <p>{{ $message }}</p> @enderror
                @error('risk_level') <p>{{ $message }}</p> @enderror
                @error('is_active') <p>{{ $message }}</p> @enderror
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900/40 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 space-y-8">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Multimedia</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gestiona la imagen principal, la galería y el video.</p>
        </div>

        <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-4">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Imagen principal</h3>
            @if ($procedure->featured_image_path)
                <img src="{{ Storage::url($procedure->featured_image_path) }}" alt="Imagen principal" class="w-full max-w-xl rounded-lg border border-gray-200 dark:border-gray-700 object-cover">
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Aún no se ha definido una imagen principal.</p>
            @endif
            <form wire:submit.prevent="updateFeaturedImage" class="space-y-3">
                <flux:input type="file" wire:model="featuredImageUpload" accept="image/*" />
                @error('featuredImageUpload') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    <x-heroicon-o-arrow-up-on-square-stack class="w-4 h-4 mr-2" />
                    Guardar imagen
                </flux:button>
            </form>
        </div>

        <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Galería</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Añade o elimina imágenes adicionales.</p>
                </div>
                <flux:button variant="ghost" size="sm" onclick="document.getElementById('gallery_upload_input').click()">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    Agregar
                </flux:button>
            </div>
            @if ($procedure->images->count())
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ($procedure->images as $image)
                        <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <img src="{{ Storage::url($image->url) }}" alt="Imagen" class="h-28 w-full object-cover">
                            <button type="button"
                                class="absolute top-1 right-1 bg-black/60 hover:bg-black/80 text-white rounded-full p-1"
                                wire:click="removeGalleryImage({{ $image->id }})">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No hay imágenes en la galería todavía.</p>
            @endif
            <form wire:submit.prevent="addGalleryImages" class="space-y-3">
                <flux:input type="file" id="gallery_upload_input" wire:model="galleryUploads" multiple accept="image/*" />
                @error('galleryUploads') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                @error('galleryUploads.*') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    <x-heroicon-o-arrow-up-on-square-stack class="w-4 h-4 mr-2" />
                    Subir imágenes
                </flux:button>
            </form>
        </div>

        <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-4">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Video</h3>
            @if ($procedure->video_path)
                <div class="rounded-xl overflow-hidden bg-black">
                    <video controls class="w-full h-64 object-cover">
                        <source src="{{ Storage::url($procedure->video_path) }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No has cargado un video aún.</p>
            @endif
            <form wire:submit.prevent="updateVideo" class="space-y-3">
                <flux:input type="file" wire:model="videoUpload" accept="video/mp4,video/quicktime" />
                @error('videoUpload') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    <x-heroicon-o-arrow-up-on-square-stack class="w-4 h-4 mr-2" />
                    Guardar video
                </flux:button>
            </form>
        </div>
    </div>
</div>
