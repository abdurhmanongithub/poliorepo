<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = SubCategory::paginate(100);
        return view('sub_category.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subCategory = new SubCategory();
        $categories = Category::all();
        return view('sub_category.create', compact('subCategory','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        SubCategory::updateOrCreate(
            [
                'name' => $request->get('name'),
                'category_id' => $request->get('category_id'),
            ],
            [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'category_id' => $request->get('category_id'),
            ]
        );
        return redirect()->route('sub_category.index')->with('success', 'Data sub category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('sub_category.edit', compact('subCategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {

        $subCategory->update(
            [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'category_id' => $request->get('category_id'),
            ]
        );
        return redirect()->route('sub_category.index')->with('success', 'Data sub category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->dataSchemas()->count() == 0) {
            // $subCategory->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        }else{
            return response()->json(['message' => 'Item is used by other resources'], 403);

        }    }
}
