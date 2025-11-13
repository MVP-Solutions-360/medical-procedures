<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procedure;

class ProcedureSeeder extends Seeder
{
    public function run(): void
    {
        Procedure::create([
            'name' => 'Abdominoplastia',
            'slug' => 'abdominoplastia',
            'category' => 'corporal',
            'summary' => 'La abdominoplastia es una intervención quirúrgica que mejora la apariencia del torso eliminando piel sobrante y uniendo las paredes abdominales.',
            'description' => 'Procedimiento dirigido a pacientes con pérdida de peso significativa, postbariátricos o mujeres post embarazo.',
            'anesthesia' => 'General',
            'surgery_time_min' => 2,
            'surgery_time_max' => 3,
            'hospitalization' => 'Ambulatoria',
            'initial_recovery_weeks' => 2,
            'final_results_weeks' => 12,
            'risk_level' => 'medio',
            'is_active' => true,
        ]);
    }
}
