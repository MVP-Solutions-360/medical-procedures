<?php

namespace App\Livewire\Procedures\Sections;

use App\Models\Procedure;
use App\Models\ProcedureSection;
use Livewire\Component;

class ShowSections extends Component
{
    public $procedure;
    public $procedureSection;

    public function mount(Procedure $procedure, ProcedureSection $procedureSection)
    {
        $this->procedure = $procedure;
        $this->procedureSection = $procedureSection;
    }

    public function render()
    {
        return view('livewire.procedures.sections.show-sections');
    }
}
