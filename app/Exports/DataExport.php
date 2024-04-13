<?php

namespace App\Exports;

use App\Models\Data;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;

class DataExport implements FromView, WithColumnWidths,ShouldAutoSize
{
    public $datas = null;
    public $headings = null;
    public function __construct($headings, $datas)
    {
        $this->datas = $datas;
        $this->headings = $headings;
    }
    public function columnWidths(): array
    {
        $numColumns = count($this->headings);
        $columnWidths = [];

        if ($numColumns > 0) {
            // Generate an array of column letters from A to Z
            $columnLetters = range('A', 'Z');

            // Calculate width per column
            $widthPerColumn = 100 / $numColumns;

            // Distribute the width among columns
            foreach ($columnLetters as $letter) {
                if ($numColumns > 0) {
                    $columnWidths[$letter] = $widthPerColumn;
                    $numColumns--;
                } else {
                    break;
                }
            }
        }

        return $columnWidths;
    }

    public function view(): View
    {
        return View('exports.data', ['headings' => $this->headings, 'datas' => $this->datas]);
    }
}
