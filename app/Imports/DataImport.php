<?php

namespace App\Imports;

use App\Models\Data;
use App\Models\DataSource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class DataImport implements ToModel, WithHeadingRow, WithBatchInserts
{

    private $dataSource = null;
    private $keys = [];
    public function __construct(DataSource $dataSource, $keys)
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
        if(count($values) == 0){
            return null;
        }
        return new Data([
            'data_source_id' => $this->dataSource->id,
            'data_schema_id' => $this->dataSource?->data_schema_id,
            'values' => $values
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
