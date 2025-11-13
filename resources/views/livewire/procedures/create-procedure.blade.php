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
        <h1 class="text-xl font-semibold">Agregar procedimiento</h1>
        <flux:button variant="primary">
            <a href="{{ route('procedure.index') }}">
                <i class="fas fa-arrow-left mr-1"></i>
                Regresar
            </a>
        </flux:button>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="bg-white dark:bg-gray-900/40 rounded-xl shadow border border-gray-100 dark:border-gray-800">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Agregar procedimiento</h2>
                </div>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="text" label="Anestesia" wire:model="anesthesia" />
                    <flux:input type="number" label="Tiempo de cirugía (min)" wire:model="surgery_time_min" />
                    <flux:input type="number" label="Tiempo de cirugía (max)" wire:model="surgery_time_max" />
                    <flux:input type="text" label="Hospitalización" wire:model="hospitalization" />
                    <flux:input type="number" label="Recuperación inicial (semanas)"
                        wire:model="initial_recovery_weeks" />
                    <flux:input type="number" label="Resultados finales (semanas)" wire:model="final_results_weeks" />
                    <flux:select label="Nivel de riesgo" wire:model="risk_level">
                        <option value="">Seleccione un nivel de riesgo</option>
                        <option value="bajo">Bajo</option>
                        <option value="medio">Medio</option>
                        <option value="alto">Alto</option>
                    </flux:select>

                    <flux:select label="Estado" wire:model="is_active">
                        <option value="">Seleccione un estado</option>
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </flux:select>

                    <flux:input type="text" label="Nombre" wire:model="name" />
                    <flux:input type="textarea" label="Resumen" wire:model="summary" />
                    <flux:input type="textarea" label="Descripción" wire:model="description" />
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <flux:button variant="primary" wire:click="create">
            <i class="fas fa-save mr-1"></i>
            Guardar
        </flux:button>
    </div>
</div>
