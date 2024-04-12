<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Data;
use App\Models\DataSchema;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataSyncController extends Controller
{

    public function importView(DataSchema $dataSchema)
    {
        return view('data_schema.data.import', compact('dataSchema'));
    }
    public function syncFromApi(Request $request)
    {
        // Your logic to sync data from API
    }


    public function syncPreviewFromExcel(DataSchema $dataSchema, Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv', // Validate file type
        ]);
        $filePath = $request->file('excel_file')->store('temp');
        $import = new ExcelImport(); // Create an instance of your import class
        $excelData = Excel::toCollection($import, $request->file('excel_file')); // Read Excel file data
        return view('data_schema.data.excel.preview', compact('excelData', 'dataSchema', 'filePath'));

    }
    public function syncFromExcel(DataSchema $dataSchema, Request $request)
    {
        $filePath = $request->input('file_path');
        $import = new ExcelImport();
        $excelData = Excel::toCollection($import, storage_path('app/' . $filePath))->first();
        $data = [];
        $importBatch = $dataSchema->getNextDataSource();

        // Get the keys from the first row
        $keys = $excelData->shift()->toArray();
        $schema = $dataSchema->structure;
        $names = [];
        foreach ($schema as $item) {
            $names[] = $item['name'];
        }
        foreach ($excelData as $row) {
            $rowData = array_combine($keys, $row->toArray());
            $rowData['data_schema_id'] = $dataSchema->id;
            $rowData['import_batch'] = $importBatch;
            $rowData['is_from_api'] = false;
            $values = [];
            foreach ($rowData as $key => $datum) {
                if (in_array($key, $names)) {
                    $values[$key] = $datum;
                    unset($rowData[$key]);
                }
            }
            $rowData['values'] = json_encode($values);
            $data[] = $rowData;
        }
        if (!empty($data)) {
            Data::insert($data); // Replace Model with your actual Eloquent model class
        }
        return redirect()->route('data_schema.data.index', ['data_schema' => $dataSchema->id])->with('success', 'Data imported successfully');

    }
}
