<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DataImportTemplateExport implements FromCollection
{
    public $header;
    public function __construct($header) {
        $this->header = $header;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([$this->header]);
    }
}
