<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminExcelExport implements FromCollection, WithStyles, WithColumnFormatting
{
    private $prontuarios;

    public function __construct($prontuarios)
    {
        $this->prontuarios = $prontuarios;
    }

    public function collection()
    {
        $data = collect([
            [null, null, 'NÚMEROS GENERADOS'],
            [null, null],
        ]);

        $headings = collect([
            ['ID', 'Responsable','Área', 'Grupo', 'Subgrupo', 'E. Externa', 'T. Público', 'Giro', 'Documento', 'Asunto', 'Número', 'Folios', 'Fecha', 'Comentario', 'Estado'],
        ]);

        $prontuariosData = $this->prontuarios->map(function ($prontuario) {
            return [
                $prontuario->id,
                $prontuario->worker->name,
                $prontuario->area->abbreviation ?? 'N/A',
                $prontuario->group->description ?? 'N/A',
                $prontuario->subgroup->description ?? 'N/A',
                $prontuario->entity->abbreviation ?? 'N/A',
                $prontuario->publicType->description ?? 'N/A',
                $prontuario->giroType->description,
                $prontuario->docType->abbreviation,
                $prontuario->subject,
                $prontuario->number,
                $prontuario->folios,
                Carbon::parse($prontuario->date)->format('d/m/Y'),
                $prontuario->comment ?? 'N/A',
                $prontuario->approved ? 'Aprobado' : 'Desaprobado',
            ];
        });

        return $data->concat($headings)->concat($prontuariosData);
    }

    public function styles($sheet)
    {
        // Estilo para el título
        $sheet->getStyle('C1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Estilo para los encabezados
        $sheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A3:O3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF99CCFF');
        $sheet->getStyle('A3:O3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Estilo para las celdas de los datos
        $sheet->getStyle('A4:O' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'M' => 'yyyy-mm-dd',
        ];
    }
}
