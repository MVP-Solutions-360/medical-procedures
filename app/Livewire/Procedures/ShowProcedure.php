<?php

namespace App\Livewire\Procedures;

use App\Models\Procedure;
use Livewire\Component;

class ShowProcedure extends Component
{
    public Procedure $procedure;

    public function mount(Procedure $procedure): void
    {
        $this->procedure = $procedure->load([
            'sections.contents',
            'techniques',
            'indications',
            'preop',
            'postop',
            'extras',
            'risks',
            'images',
            'metadata',
        ]);
    }

    protected function relations(): array
    {
        return [
            'sections',
            'techniques',
            'indications',
            'preop',
            'postop',
            'extras',
            'risks',
            'images',
            'metadata',
        ];
    }

    public function render()
    {
        return view('livewire.procedures.show-procedure', [
            'procedure' => $this->procedure,
        ]);
    }
}
