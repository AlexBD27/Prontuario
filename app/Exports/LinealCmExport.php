<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LinealCmExport implements FromCollection, WithStyles
{
    protected $prontuarios;
    protected $startDate;
    protected $endDate;

    public function __construct($prontuarios, $startDate, $endDate)
    {
        $this->prontuarios = $prontuarios;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $reportHeader = collect([
            ['Reporte de CM Lineales'],
            [null],
            ['Rango de Fechas:', $this->startDate . " - " . $this->endDate],
            [null],
        ]);

        $headings = collect([
            ['Tipo de Documento', 'CM Lineales']
        ]);

        $prontuariosData = collect($this->prontuarios)->map(function ($report) {
            return [
                $report['doc_type'],
                number_format($report['cm_lineales'], 2) . ' cm'
            ];
        });

        return $reportHeader->concat($headings)->concat($prontuariosData);
    }


    public function headings(): array
    {
        return [
            "Tipo de Documento",
            "CM Lineales"
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A5:B5')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A5:B5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF99CCFF');
        $sheet->getStyle('A6:B' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
}
