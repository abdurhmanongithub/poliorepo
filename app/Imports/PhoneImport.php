<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PhoneImport implements ToCollection
{
    public $phone_string;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $phone_arr = [];

        foreach ($collection as $key => $value) {
            array_push($phone_arr, $value[0]);
        }

        $this->phone_string = implode(',', $phone_arr);
    }
}
