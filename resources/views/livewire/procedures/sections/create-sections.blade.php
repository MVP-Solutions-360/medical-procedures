<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.index')">
            Procedimientos
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.show', ['procedure' => $procedure->slug])">
            {{$procedure->name}}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="h-1 w-full bg-black dark:bg-gray-400 rounded my-4"></div>
    <!-- Listado -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Preguntas y respuestas</h1>
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
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Preguntas y respuestas</h2>
                </div>
            </div>
            <div class="p-6">
                <form wire:submit.prevent="create" class="space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <flux:input type="text" label="Título" wire:model.defer="title" />
                        <flux:input type="text" label="Descripción" wire:model.defer="description" />
                        {{-- <flux:input type="text" label="Anestesia" wire:model.defer="anesthesia" />
                        <flux:input type="text" label="Hospitalización" wire:model.defer="hospitalization" /> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
