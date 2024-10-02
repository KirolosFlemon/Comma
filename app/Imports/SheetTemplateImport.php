<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SheetTemplateImport implements ToCollection, WithHeadingRow
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection($rows)
    {
        return $rows;
    }
}
