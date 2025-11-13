<?php

namespace App\Livewire\Procedures;

use App\Models\Procedure;
use Livewire\Component;

class IndexProcedure extends Component
{
    public $procedures;

    public function mount()
    {
        $this->procedures = Procedure::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.procedures.index-procedure');
    }
}
