<?php

namespace App\Http\Controllers;

use App\Models\DataSchema;
use Illuminate\Http\Request;

class DataSyncController extends Controller
{

    public function importView(DataSchema $dataSchema){
        return view('data_schema.data.import',compact('dataSchema'));
    }
    public function syncFromApi(Request $request)
    {
        // Your logic to sync data from API
    }

    public function syncFromExcel(Request $request)
    {
        // Your logic to sync data from Excel file
    }
}
