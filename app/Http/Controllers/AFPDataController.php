<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\StoreAFPDataRequest;
use App\Http\Requests\UpdateAFPDataRequest;
use App\Imports\AFPDataImport;
use App\Imports\AFPDataImportForPreview;
use App\Models\AFPData;
use App\Models\OtherDataSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class AFPDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('afp-data.index', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }

    function dataManagement()
    {
        return view('afp-data.data-manage', [
            'totalDatas' => AFPData::count(),
            'columns' => Schema::getColumnListing('a_f_p_data'),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }
    public function importView()
    {

        return view('afp-data.data.import', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
        ]);
    }
    public function importPreview(Request $request)
    {
        $schemaList = Schema::getColumnListing('a_f_p_data') ?? [];
        if (count($schemaList) == 0) {
            return redirect()->back()->with('error', 'No column found for this schema');
        }
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv', // Validate file type
        ]);
        $filePath = $request->file('excel_file')->store('temp');
        $keys = [];
        foreach ($schemaList as $item) {
            $keys[] = \Str::slug($item, '_');
        }
        $keys = array_diff($keys, ['id', 'other_data_source_id', 'updated_at', 'created_at']);
        // dd($keys);
        $import = new AFPDataImportForPreview($keys, 10);
        $excelData = Excel::toArray($import, $request->file('excel_file'));
        return view('afp-data.data.import-preview', [
            'totalDatas' => AFPData::count(),
            'columnCount' => count(Schema::getColumnListing('a_f_p_data')),
            'excelData' => $excelData,
            'keys' => $keys,
            'filePath' => $filePath
        ]);
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 6000);
        $filePath = $request->input('file_path');
        $otherDataSource = OtherDataSource::create([
            'import_batch' => AFPData::getNextDataSource(),
            'source' => Constants::OTHER_DATA_SOURCE_AFP_DATA,
        ]);
        $keys = [];
        foreach (Schema::getColumnListing('a_f_p_data') as $item) {
            $keys[] = \Str::slug($item, '_');
        }
        Excel::import(new AFPDataImport($otherDataSource, $keys), storage_path('app/' . $filePath));
        return redirect()->route('afp-data.data-management')->with('success', 'Data imported successfully');
    }
    public function datafetch()
    {
        $data = AFPData::query();
        return datatables()->of($data->get())->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAFPDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AFPData $aFPData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AFPData $aFPData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAFPDataRequest $request, AFPData $aFPData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AFPData $aFPData)
    {
        //
    }
}
