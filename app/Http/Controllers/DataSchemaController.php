<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exports\DataExport;
use App\Exports\DataImportTemplateExport;
use App\Models\DataSchema;
use App\Http\Requests\StoreDataSchemaRequest;
use App\Http\Requests\UpdateDataSchemaRequest;
use App\Models\Category;
use App\Models\Data;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DataSchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = DataSchema::paginate(10);
        $subCategories = SubCategory::all();
        return view('data_schema.index', compact('items', 'subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSchema = new DataSchema();
        $subCategories = SubCategory::all();
        return view('data_schema.create', compact('subCategories', 'dataSchema'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataSchemaRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
            // 'attribute.*.type' => 'required',
            // 'attribute.*.name' => 'required',
            // 'attribute.*.is_required' => 'required',
            'force_validation' => 'nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $dataSchema = DataSchema::updateOrCreate(
            [
                'name' => $request->get('name'),
                'sub_category_id' => $request->get('sub_category_id'),
            ],
            [
                'name' => $request->get('name'),
                'sub_category_id' => $request->get('sub_category_id'),
                'force_validation' => $request->get('force_validation') ? true : false
            ]
        );
        return redirect()->route('data_schema.show', ['data_schema' => $dataSchema])->with('success', 'Data schema created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataSchema $dataSchema)
    {
        $miniSide = true;
        return view('data_schema.show', compact('dataSchema', 'miniSide'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSchema $dataSchema)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataSchemaRequest $request, DataSchema $dataSchema)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
            // 'attribute.*.type' => 'required',
            // 'attribute.*.name' => 'required',
            // 'attribute.*.is_required' => 'required',
            'force_validation' => 'nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $dataSchema->update(
            [
                'name' => $request->get('name'),
                'sub_category_id' => $request->get('sub_category_id'),
                'force_validation' => $request->get('force_validation') ? true : false
            ]
        );
        return redirect()->back()->with('success', 'Data schema created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSchema $dataSchema)
    {
        if ($dataSchema->datas()->count() == 0) {
            $dataSchema->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Item is used by other resources'], 403);
        }
    }
    public function manage(DataSchema $dataSchema)
    {
        $miniSide = true;
        return view('data_schema.manage', compact('dataSchema', 'miniSide'));
    }
    public function storeAttribute(Request $request, DataSchema $dataSchema)
    {
        $request->validate([
            'attribute.*.type' => 'required',
            'attribute.*.name' => [
                'required'
            ],
            'attribute.*.is_required' => 'nullable',
        ]);
        $newAttributes = [];
        foreach ($request->get('attribute') as $attribute) {
            $isRequired = isset($attribute['is_required']) ? $attribute['is_required'] : null;
            $newAttributes[] = [
                'type' => $attribute['type'],
                'name' => $attribute['name'],
                'is_required' => $isRequired ? true : false,
            ];
        }
        $dataSchema->update(['structure' => null]);

        $dataSchema->update(['structure' => $newAttributes]);
        return redirect()->back()->with('success', 'Data schema attribute saved successfully');

    }
    public function dataIndex(DataSchema $dataSchema)
    {
        $miniSide = true;
        return view('data_schema.data.index', compact('dataSchema', 'miniSide'));
    }


    public function dataSource(DataSchema $dataSchema)
    {
        return view('data_schema.data.source', compact('dataSchema'));
    }
    public function exportData(Request $request, DataSchema $dataSchema)
    {
        $input = $request->validate([
            'type' => 'required',
            'batch' => 'required',
        ]);
        $datas = Data::query();
        if ($input['batch'] != 'all') {
            $datas = $datas->where('batch', $input['batch']);
        }
        $jsonStrings = $datas->pluck('values');
        $datas = [];
        $jsonStrings->each(function ($jsonString) use (&$datas) {
            $datas[] = $jsonString;
        });
        $headingJson = $dataSchema->structure;
        $headings = [];
        foreach ($headingJson as $heading) {
            $headings[] = $heading['name'];
        }
        $fileName = 'datas.' . $input['type'];
        switch ($input['type']) {
            case Constants::EXPORT_TYPE_CSV:
                return Excel::download(new DataExport($headings, $datas), $fileName, \Maatwebsite\Excel\Excel::CSV);
            case Constants::EXPORT_TYPE_EXCEL:
                return Excel::download(new DataExport($headings, $datas), $fileName, \Maatwebsite\Excel\Excel::XLSX);
            case Constants::EXPORT_TYPE_PDF:
                return Excel::download(new DataExport($headings, $datas), $fileName, \Maatwebsite\Excel\Excel::DOMPDF);
            case Constants::EXPORT_TYPE_HTML:
                return Excel::download(new DataExport($headings, $datas), $fileName, \Maatwebsite\Excel\Excel::HTML);
        }
        return "Non Supported export";

    }
    public function eraseData(DataSchema $dataSchema)
    {
        DB::table('data')->where('data_schema_id', $dataSchema->id)->delete();
        return redirect()->back()->with('success', 'Data Erased Successfully');
    }
    public function sourceDelete(DataSchema $dataSchema,Request $request){
        $input = $request->validate([
            'source' => 'required'
        ]);
        $dataSource = $input['source'];
        DB::table('data')->where('data_schema_id', $dataSchema->id)->where('import_batch',$dataSource)->delete();
        return redirect()->back()->with('success', 'Data Source Deleted Successfully');
    }
    public function dataImportTemplateDownload(DataSchema $dataSchema){
        $columns = $dataSchema->structure;
        $headers = [];
        foreach ($columns as $column) {
            $headers[] = $column['name'];
        }
        return Excel::download(new DataImportTemplateExport($headers), $dataSchema->getNextDataSource().'.xlsx');
    }
}
