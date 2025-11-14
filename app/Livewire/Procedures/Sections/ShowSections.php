<?php

namespace App\Livewire\Procedures\Sections;

use App\Models\Procedure;
use App\Models\ProcedureSection;
use Livewire\Component;

class ShowSections extends Component
{
    public $procedure;
    public $section;

    public function mount(Procedure $procedure, ProcedureSection $section)
    {
        $this->procedure = $procedure;
        $this->section = $section->load('contents');
    }

    public function render()
    {
        return view('livewire.procedures.sections.show-sections');
    }
}
