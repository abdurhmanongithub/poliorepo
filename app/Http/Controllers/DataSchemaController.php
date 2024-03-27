<?php

namespace App\Http\Controllers;

use App\Models\DataSchema;
use App\Http\Requests\StoreDataSchemaRequest;
use App\Http\Requests\UpdateDataSchemaRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DataSchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = DataSchema::paginate(10);
        return view('data_schema.index', compact('items'));
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
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'sub_category_id' => 'required',
            // 'attribute.*.type' => 'required',
            // 'attribute.*.name' => 'required',
            // 'attribute.*.is_required' => 'required',
            'force_validation.*' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        dd('sdd');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataSchema $dataSchema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSchema $dataSchema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataSchemaRequest $request, DataSchema $dataSchema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSchema $dataSchema)
    {
        //
    }
}
