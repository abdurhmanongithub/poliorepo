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

class AFPDataImport implements ToModel, WithHeadingRow, WithBatchInserts
{

    private $dataSource = null;
    private $keys = [];
    public function __construct(OtherDataSource $dataSource,$keys)
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
        return new AFPData($values);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
