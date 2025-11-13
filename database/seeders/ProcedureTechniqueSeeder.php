<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procedure;
use App\Models\ProcedureTechnique;

class ProcedureTechniqueSeeder extends Seeder
{
    public function run()
    {
        $procedure = Procedure::where('slug','abdominoplastia')->first();

        $techniques = [
            ['name' => '3D Corsé Siluet', 'description' => 'Define cintura mediante anclaje muscular.'],
            ['name' => 'Puntos Invertidos', 'description' => 'Cierre interno sin puntos visibles.'],
            ['name' => 'Inside de Ombligo y Corte en Rombo', 'description' => 'Cicatriz de ombligo natural y oculta.'],
        ];

        foreach ($techniques as $i => $t) {
            ProcedureTechnique::create([
                'procedure_id' => $procedure->id,
                'name' => $t['name'],
                'description' => $t['description'],
                'order' => $i + 1,
            ]);
        }
    }
}
