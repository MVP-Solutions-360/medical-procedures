@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/procedures.css') }}">
    @endpush
@endonce

<flux:modal name="create-sections" class="w-full max-w-4xl">
    {{-- <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.index')">
            Procedimientos
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('procedure.show', ['procedure' => $procedure->slug])">
            {{ $procedure->name }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    
    <div class="h-1 w-full bg-black dark:bg-gray-400 rounded my-4"></div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Preguntas y respuestas</h1>
        <flux:button variant="primary">
            <a href="{{ route('procedure.index') }}">
                <i class="fas fa-arrow-left mr-1"></i>
                Regresar
            </a>
        </flux:button>
    </div> --}}
    <div class="grid grid-cols-1 gap-4">
        <div class="procedure-card">
            <div class="procedure-card__header">
                <div>
                    <h2 class="procedure-card__title">Preguntas y respuestas</h2>
                </div>
            </div>
            <div class="procedure-card__body">
                <form wire:submit.prevent="create" class="space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-4">
                        <flux:input type="text" label="Título" wire:model.defer="title" />
                        <flux:textarea label="Descripción" wire:model.defer="description" />
                    </div>
                    <div class="flex justify-end space-x-2 my-4">
                        <flux:button type="submit" variant="primary" class="cursor-pointer">
                            Crear sección
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</flux:modal>
