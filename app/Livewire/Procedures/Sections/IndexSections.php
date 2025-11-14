<?php

namespace App\Livewire\Procedures\Sections;

use App\Models\Procedure;
use App\Models\ProcedureSection;
use Livewire\Component;

class IndexSections extends Component
{
    public Procedure $procedure;

    public function mount(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    public function render()
    {
        $sections = ProcedureSection::with('contents')
            ->where('procedure_id', $this->procedure->id)
            ->orderBy('order')
            ->get();

        return view('livewire.procedures.sections.index-sections', compact('sections'));
    }

    public function deleteSection(int $sectionId): void
    {
        $section = ProcedureSection::where('procedure_id', $this->procedure->id)
            ->with('contents')
            ->findOrFail($sectionId);

        $section->contents()->delete();
        $section->delete();

        session()->flash('message', 'La sección se eliminó correctamente.');
    }
}
