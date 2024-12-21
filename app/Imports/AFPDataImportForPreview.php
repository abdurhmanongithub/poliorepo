<?php

namespace App\Imports;

// Import necessary classes
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AFPDataImportForPreview implements ToArray, WithHeadingRow, WithLimit
{
    private $sampleSize;
    private $keys = [];
    public $rows;

    public function __construct($keys, $sampleSize = 10)
    {
        $this->sampleSize = $sampleSize;
        $this->rows = collect();
        $this->keys = $keys;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->sampleSize;
    }

    public function array(array $rows)
    {
        $filteredRows = [];
        foreach ($rows as $row) {
            $filteredRow = [];
            foreach ($this->keys as $key) {
                if (isset($row[$key])) {
                    $filteredRow[$key] = $row[$key];
                }
            }
            $filteredRows[] = $filteredRow;
        }
        $this->rows = collect($filteredRows);
    }

}
