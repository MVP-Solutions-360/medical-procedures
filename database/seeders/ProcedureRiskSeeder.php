<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procedure;
use App\Models\ProcedureRisk;

class ProcedureRiskSeeder extends Seeder
{
    public function run()
    {
        $procedure = Procedure::where('slug','abdominoplastia')->first();

        $risks = [
            'Dehiscencia de suturas',
            'Hemorragia o formación de hematomas',
            'Infecciones en la herida',
            'Riesgos por anestesia',
            'Quemaduras por liposucción asociada',
            'Necrosis de piel',
            'Seromas',
            'Coágulos sanguíneos',
            'Retraso en cicatrización'
        ];

        foreach ($risks as $i => $risk) {
            ProcedureRisk::create([
                'procedure_id' => $procedure->id,
                'risk' => $risk,
                'description' => null,
                'order' => $i + 1
            ]);
        }
    }
}
