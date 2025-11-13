<?php

namespace App\Livewire\Procedures;

use Livewire\Component;
use Illuminate\Support\Str;

class CreateProcedure extends Component
{
    public $name;
    public $slug;
    public $category;
    public $summary;
    public $description;
    public $anesthesia;
    public $surgery_time_min;
    public $surgery_time_max;
    public $hospitalization;
    public $initial_recovery_weeks;
    public $final_results_weeks;
    public $risk_level;
    public $is_active = true;
    public $sections = [];
    public $techniques = [];
    public $indications = [];
    public $preops = [];
    public $postops = [];
    public $extras = [];
    public $risks = [];
    public $images = [];
    public $metadata = [];
    public $errors = [];
    public $success = false;
    public $success_message = '';
    public $error_message = '';

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre debe tener menos de 255 caracteres',
        ];
    }
    


    public function mount()
    {
        $this->slug = Str::slug($this->name);
    }

    public function render()
    {
        return view('livewire.procedures.create-procedure');
    }
}
