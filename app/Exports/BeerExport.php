<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeerExport implements FromCollection, WithHeadings
{
    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->reportData);
    }

    /**
     * Método responsável por retornar os nomes das colunas no EXCEL
     *
     * @return array
     */
    public function headings(): array
    {
        return array_keys($this->reportData[0]);
    }
}
