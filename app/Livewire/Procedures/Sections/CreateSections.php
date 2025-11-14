<?php

namespace App\Livewire\Procedures\Sections;

use App\Models\Procedure;
use Livewire\Component;

class CreateSections extends Component
{
    public $procedure;

    public function mount(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    public function render()
    {
        return view('livewire.procedures.sections.create-sections');
    }
}
