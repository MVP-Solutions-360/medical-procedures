<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procedure;
use App\Models\ProcedureSection;
use App\Models\ProcedureSectionContent;

class ProcedureSectionContentSeeder extends Seeder
{
    public function run(): void
    {
        $procedure = Procedure::where('slug', 'abdominoplastia')->first();

        // --- 1: ¿Qué es la cirugía? ---
        $section1 = ProcedureSection::where('procedure_id', $procedure->id)
            ->where('title', '¿Qué es la cirugía?')->first();

        $introTexts = [
            'La abdominoplastia es una intervención quirúrgica que mejora la apariencia del torso eliminando piel sobrante y uniendo las paredes abdominales.',
            'Está dirigida a pacientes con pérdida de peso significativa, postbariátricos o mujeres post embarazo.',
            'Mejora flacidez, exceso de piel y distensión de los músculos rectos abdominales.'
        ];

        foreach ($introTexts as $i => $text) {
            ProcedureSectionContent::create([
                'section_id' => $section1->id,
                'type' => 'text',
                'content' => $text,
                'order' => $i + 1
            ]);
        }

        // --- 2: ¿Cómo se lleva a cabo? ---
        $section2 = ProcedureSection::where('procedure_id', $procedure->id)
            ->where('title', '¿Cómo se lleva a cabo?')->first();

        $contenido2 = [
            'La cirugía se realiza bajo anestesia general.',
            'Se hace una incisión por encima del pubis, extendiéndose hacia las caderas.',
            'Se separa la piel, se expone el músculo y se realizan los amarres de las paredes abdominales.',
            'Se retira el exceso de piel y se procede al cierre mediante sutura interna.',
            'El procedimiento dura entre 2 y 3 horas.'
        ];

        foreach ($contenido2 as $i => $text) {
            ProcedureSectionContent::create([
                'section_id' => $section2->id,
                'type' => 'text',
                'content' => $text,
                'order' => $i + 1
            ]);
        }

        // --- 3: Técnicas aplicadas ---
        $section3 = ProcedureSection::where('procedure_id', $procedure->id)
            ->where('title', 'Técnicas aplicadas')->first();

        $contenido3 = [
            'Técnica 3D Corsé Siluet: define la cintura mediante anclaje muscular que genera efecto reloj de arena.',
            'Técnica Puntos Invertidos: cierra la piel con sutura absorbible dentro de la piel, evitando puntos externos y mejorando la cicatriz.',
            'Técnica Inside de Ombigo y Corte en Rombo: genera un ombligo natural con cicatriz oculta.'
        ];

        foreach ($contenido3 as $i => $text) {
            ProcedureSectionContent::create([
                'section_id' => $section3->id,
                'type' => 'text',
                'content' => $text,
                'order' => $i + 1
            ]);
        }

        // --- 4: Adicionales incluidos ---
        $section4 = ProcedureSection::where('procedure_id', $procedure->id)
            ->where('title', 'Adicionales incluidos')->first();

        $extras = [
            'Exámenes prequirúrgicos',
            'Examen de control de Hmgl',
            'Medicamentos orales',
            'Cobertura postquirúrgica',
            'Faja de baja compresión',
            'Medias antiembólicas',
            'Anticoagulante (20 unidades)',
            'Ambulancia y enfermera (12 horas)'
        ];

        foreach ($extras as $i => $item) {
            ProcedureSectionContent::create([
                'section_id' => $section4->id,
                'type' => 'list',
                'content' => $item,
                'order' => $i + 1
            ]);
        }

        // --- 5: Recomendaciones postoperatorias ---
        $section5 = ProcedureSection::where('procedure_id', $procedure->id)
            ->where('title', 'Recomendaciones postoperatorias')->first();

        $postop = [
            'No permanecer solo(a) la primera noche.',
            'Evitar conducir, alcohol, tabaco y estrés durante 24 horas.',
            'Movilizarse con acompañante y de forma cuidadosa.',
            'Iniciar alimentación con líquidos sin gas.',
            'Evitar cítricos, lácteos y bebidas gaseosas los primeros 5 a 8 días.',
            'Tomar medicamentos según prescripción médica.',
            'Usar medias de compresión sin pliegues.',
            'Dormir boca arriba con piernas elevadas.',
            'Evitar esfuerzos, calor, solearse y actividad física intensa.',
            'Asistir a todas las citas asignadas.'
        ];

        foreach ($postop as $i => $item) {
            ProcedureSectionContent::create([
                'section_id' => $section5->id,
                'type' => 'list',
                'content' => $item,
                'order' => $i + 1
            ]);
        }
    }
}
