<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\StoreCoreGroupDataRequest;
use App\Http\Requests\UpdateCoreGroupDataRequest;
use App\Imports\CoreGroupDataImport;
use App\Imports\CoreGroupDataImportForPreview;
use App\Models\AFPData;
use App\Models\CoreGroupData;
use App\Models\OtherDataSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class CoreGroupDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('core-group-data.index', [
            'totalDatas' => CoreGroupData::count(),
            'columnCount' => count(Schema::getColumnListing('core_group_data')),
        ]);
    }
    function dataManagement()
    {
        $dataSchema = new stdClass();
        $dataSchema->name = 'Core Group Data';
        return view('core-group-data.data-manage', [
            'totalDatas' => CoreGroupData::count(),
            'dataSchema' => $dataSchema,
            'columns' => Schema::getColumnListing('core_group_data'),
            'columnCount' => count(Schema::getColumnListing('core_group_data')),
        ]);
    }
    public function importView()
    {

        return view('core-group-data.data.import', [
            'totalDatas' => CoreGroupData::count(),
            'columnCount' => count(Schema::getColumnListing('core_group_data')),
        ]);
    }
    public function importPreview(Request $request)
    {
        $schemaList = Schema::getColumnListing('core_group_data') ?? [];
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

        $import = new CoreGroupDataImportForPreview($keys, 10);
        $excelData = Excel::toArray($import, $request->file('excel_file'));
        return view('core-group-data.data.import-preview', [
            'totalDatas' => CoreGroupData::count(),
            'columnCount' => count(Schema::getColumnListing('core_group_data')),
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
            'import_batch' => CoreGroupData::getNextDataSource(),
            'source' => Constants::OTHER_DATA_SOURCE_CORE_GROUP_DATA,
        ]);
        $keys = [];
        foreach (Schema::getColumnListing('core_group_dat   a') as $item) {
            $keys[] = \Str::slug($item, '_');
        }
        Excel::import(new CoreGroupDataImport($otherDataSource, $keys), storage_path('app/' . $filePath));
        return redirect()->route('core-group-data.data-management')->with('success', 'Data imported successfully');
    }

    public function datafetch()
    {
        $data = CoreGroupData::query();
        return datatables()->of($data->get())->toJson();
    }


    public function getCaseCounts()
    {
        $data = CoreGroupData::select('area_name_region', DB::raw('COUNT(*) as case_count'))
            ->whereIn('area_name_region', ['Somali', 'Gambella', 'Oromia', 'Benshangul Gumuz', 'SNNP'])
            ->groupBy('area_name_region')

            ->get();
        return response()->json($data);
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
    public function store(StoreCoreGroupDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CoreGroupData $coreGroupData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoreGroupData $coreGroupData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoreGroupDataRequest $request, CoreGroupData $coreGroupData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoreGroupData $coreGroupData)
    {
        //
    }
}
