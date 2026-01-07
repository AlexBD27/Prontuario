<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class AreaSheetExport implements FromCollection, WithHeadings, WithEvents
{
    private $area;
    private $groups;
    private $headerRows = [];
    private $groupRows = [];
    private $workerRows = [];

    public function __construct($area, $groups)
    {
        $this->area = $area;
        $this->groups = $groups;
    }

    public function collection()
    {
        $data = collect();
        $rowCounter = 2;

        foreach ($this->groups as $group => $workers) {
            $data->push([null, "Grupo: $group"]);
            $this->groupRows[] = $rowCounter; 
            $rowCounter++;

            foreach ($workers as $worker => $prontuarios) {
                $data->push([null, "Trabajador: $worker"]);
                $this->workerRows[] = $rowCounter; 
                $rowCounter++;

                $data->push([
                    'N°',
                    'Área',
                    'Grupo',
                    'Subgrupo',
                    'E. Externa',
                    'T. Público',
                    'Giro',
                    'Documento',
                    'Asunto',
                    'Número',
                    'Folios',
                    'Fecha',
                    'Comentario',
                    'Estado',
                ]);
                $this->headerRows[] = $rowCounter; 
                $rowCounter++;

                foreach ($prontuarios as $index => $prontuario) {
                    $data->push([
                        $index + 1,
                        $prontuario->area->abbreviation ?? 'N/A',
                        $prontuario->group->description ?? 'N/A',
                        $prontuario->subgroup->description ?? 'N/A',
                        $prontuario->entity->abbreviation ?? 'N/A',
                        $prontuario->publicType->description ?? 'N/A',
                        $prontuario->giroType->description ?? 'N/A',
                        $prontuario->docType->abbreviation ?? 'N/A',
                        $prontuario->subject,
                        $prontuario->number ?? 'N/A',
                        $prontuario->folios ?? 'N/A',
                        Carbon::parse($prontuario->date)->format('d/m/Y'),
                        $prontuario->comment ?? 'N/A',
                        $prontuario->approved ? 'Aprobado' : 'Desaprobado',
                    ]);
                    $rowCounter++;
                }

                $data->push([null]);
                $rowCounter++;
            }

            $data->push([null]);
            $rowCounter++;
        }

        return $data;
    }


    public function headings(): array
    {
        return ["Área: {$this->area}"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->setTitle($this->area);

                foreach ($this->headerRows as $headerRow) {
                    $sheet->getStyle("A{$headerRow}:N{$headerRow}")
                        ->getFont()
                        ->setBold(true)
                        ->setSize(12);
                    $sheet->getStyle("A{$headerRow}:N{$headerRow}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FF99CCFF');
                    $sheet->getStyle("A{$headerRow}:N{$headerRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                foreach ($this->groupRows as $groupRow) {
                    $sheet->getStyle("B{$groupRow}")
                        ->getFont()
                        ->setBold(true)
                        ->setSize(12);
                }

                foreach ($this->workerRows as $workerRow) {
                    $sheet->getStyle("B{$workerRow}")
                        ->getFont()
                        ->setItalic(true)
                        ->setSize(12);
                }

                $sheet->mergeCells('A1:N1');
                $sheet->getStyle('A1:N1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14);
                $sheet->getStyle('A1:N1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
