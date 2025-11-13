<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procedure;
use App\Models\ProcedureSection;

class ProcedureSectionSeeder extends Seeder
{
    public function run(): void
    {
        $procedure = Procedure::where('slug', 'abdominoplastia')->first();

        $sections = [
            '¿Qué es la cirugía?',
            '¿Cómo se lleva a cabo?',
            'Técnicas aplicadas',
            'Adicionales incluidos',
            'Recomendaciones postoperatorias',
            'Posibles complicaciones',
            'Mini Abdominoplastia',
            'Abdominoplastia inversa',
            'Criterios sobre masa corporal'
        ];

        foreach ($sections as $index => $title) {
            ProcedureSection::create([
                'procedure_id' => $procedure->id,
                'title' => $title,
                'order' => $index + 1
            ]);
        }
    }
}
