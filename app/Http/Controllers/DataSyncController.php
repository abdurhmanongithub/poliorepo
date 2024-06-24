<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\ExcelImport;
use App\Imports\SampleImport;
use App\Models\Data;
use App\Models\DataSchema;
use App\Models\DataSource;
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
        $schemaList = $dataSchema->structure ?? [];
        if (count($schemaList) == 0) {
            return redirect()->back()->with('error', 'Goto Data Management and add the schema of the data');
        }
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv', // Validate file type
        ]);
        $filePath = $request->file('excel_file')->store('temp');
        $keys = [];
        foreach ($dataSchema->structure as $item) {
            $keys[] = \Str::slug($item['name'], '_');
        }
        $import = new SampleImport($keys, 10);
        $excelData = Excel::toArray($import, $request->file('excel_file'));
        return view('data_schema.data.excel.preview', compact('excelData', 'keys', 'dataSchema', 'filePath'));

    }
    public function syncFromExcel(DataSchema $dataSchema, Request $request)
    {
        ini_set('max_execution_time', 6000);
        $filePath = $request->input('file_path');
        $dataSource = DataSource::create([
            'import_batch' => $dataSchema->getNextDataSource(),
            'data_schema_id' => $dataSchema->id,
        ]);
        $keys = [];
        foreach ($dataSchema->structure as $item) {
            $keys[] = \Str::slug($item['name'], '_');
        }
        Excel::import(new DataImport($dataSource,$keys),storage_path('app/' . $filePath));
        // $excelData = Excel::toCollection($import, storage_path('app/' . $filePath))->first();
        // $data = [];
        // $importBatch = $dataSchema->getNextDataSource();

        // // Get the keys from the first row
        // $keys = $excelData->shift()->toArray();
        // $schema = $dataSchema->structure;
        // $names = [];
        // foreach ($schema as $item) {
        //     $names[] = $item['name'];
        // }
        // foreach ($excelData as $row) {
        //     $rowData = array_combine($keys, $row->toArray());
        //     $rowData['data_schema_id'] = $dataSchema->id;
        //     $rowData['import_batch'] = $importBatch;
        //     $rowData['is_from_api'] = false;
        //     $values = [];
        //     foreach ($rowData as $key => $datum) {
        //         if (in_array($key, $names)) {
        //             $values[$key] = $datum;
        //             unset($rowData[$key]);
        //         }
        //     }
        //     $rowData['values'] = json_encode($values);
        //     $data[] = $rowData;
        // }
        // if (!empty($data)) {
        //     Data::insert($data); // Replace Model with your actual Eloquent model class
        // }
        return redirect()->route('data_schema.data.index', ['data_schema' => $dataSchema->id])->with('success', 'Data imported successfully');

    }
}
