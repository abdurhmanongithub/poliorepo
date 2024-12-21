<?php

namespace App\Imports;

use App\Models\AFPData;
use App\Models\CoreGroupData;
use App\Models\Data;
use App\Models\DataSource;
use App\Models\OtherDataSource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AFPDataImport implements ToModel, WithHeadingRow, WithBatchInserts
{

    private $dataSource = null;
    private $keys = [];
    public function __construct(OtherDataSource $dataSource, $keys)
    {
        $this->dataSource = $dataSource;
        $this->keys = $keys;
    }
    public function model(array $row)
    {
        $values = [];
        foreach ($this->keys as $key) {
            if (array_key_exists($key, $row))
                $values[$key] = $row[$key];
        }
        if (count($values) == 0) {
            return null;
        }
        $allNull = empty(array_filter($values, function ($value) {
            return !is_null($value);
        }));
        if ($allNull) {
            return null;
        }
        $values['other_data_source_id'] = $this->dataSource->id;
        $values['date_stool_collected'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
            \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($row['date_stool_collected'])
        )->format('Y-m-d H:i:s');

        $values['date_stool_received_in_lab'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
            \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($row['date_stool_received_in_lab'])
        )->format('Y-m-d H:i:s');
        $values['date_final_cell_culture_results'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
            \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($row['date_final_cell_culture_results'])
        )->format('Y-m-d H:i:s');
        return new AFPData($values);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
