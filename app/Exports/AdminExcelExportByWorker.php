<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdminExcelExportByWorker implements WithMultipleSheets
{
    private $groupedProntuarios;

    public function __construct($groupedProntuarios)
    {
        $this->groupedProntuarios = $groupedProntuarios;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->groupedProntuarios as $area => $groups) {
            $sheets[] = new AreaSheetExport($area, $groups);
        }

        return $sheets;
    }
}
