<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class WorkerExcelExport implements FromCollection, WithStyles, WithColumnFormatting
{
    
    private $prontuarios;

    public function __construct($prontuarios)
    {
        $this->prontuarios = $prontuarios;
    }

    public function collection()
    {
        $workerData = collect([
            [null, null, 'REPORTE DEL TRABAJADOR'],
            [null, null],
            [null, 'NOMBRE', $this->prontuarios->first()?->worker->name ?? 'N/A'],
            [null, 'ÁREA', $this->prontuarios->first()?->worker->group->area->description ?? 'N/A'],
            [null, 'GRUPO', $this->prontuarios->first()?->worker->group->description ?? 'N/A'],
            [null, 'SUBGRUPO', $this->prontuarios->first()?->worker->subgroup->description ?? 'N/A'],
            [null, 'CARGO', $this->prontuarios->first()?->worker->position ?? 'N/A'],
            [null, null],
        ]);

        $headings = collect([
            ['ID', 'Área', 'Grupo', 'Subgrupo', 'E. Externa', 'T. Público', 'Giro', 'Documento', 'Asunto', 'Número', 'Folios', 'Fecha', 'Comentario', 'Estado'],
        ]);

        $prontuariosData = $this->prontuarios->map(function ($prontuario) {
            return [
                $prontuario->id,
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

        return $workerData->concat($headings)->concat($prontuariosData);
    }

    public function styles($sheet)
    {
        // Estilo para el título
        $sheet->getStyle('C1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Estilo para el detalles
        $sheet->getStyle('B3:B7')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('C3:C7')->getFont()->setBold(false)->setSize(12);

        // Estilo para los encabezados
        $sheet->getStyle('A9:N9')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A9:N9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF99CCFF');
        $sheet->getStyle('A9:N9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Estilo para las celdas de los datos
        $sheet->getStyle('A10:N' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'L' => 'yyyy-mm-dd',
        ];
    }

}
