<?php

namespace App\Livewire\Procedures\Sections;

use App\Models\Procedure;
use App\Models\ProcedureSection;
use App\Models\ProcedureSectionContent;
use Livewire\Component;

class CreateSections extends Component
{
    public $procedure;
    public $title = '';
    public $description = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];


    public function mount(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    public function create()
    {
        $this->validate();

        $nextOrder = ProcedureSection::where('procedure_id', $this->procedure->id)->max('order');

        $section = ProcedureSection::create([
            'procedure_id' => $this->procedure->id,
            'title' => $this->title,
            'order' => ($nextOrder ?? 0) + 1,
        ]);

        if (!empty($this->description)) {
            ProcedureSectionContent::create([
                'section_id' => $section->id,
                'type' => 'text',
                'content' => $this->description,
                'order' => 1,
            ]);
        }

        $this->reset(['title', 'description']);
    }

    public function render()
    {
        return view('livewire.procedures.sections.create-sections');
    }
}
