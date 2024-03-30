<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Category::paginate(100);
        return view('category.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::updateOrCreate(
            [
                'name' => $request->get('name'),
            ],
            [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ]
        );
        return redirect()->route('category.index')->with('success', 'Data category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        
        $category->update(
            [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ]
        );
        return redirect()->route('category.index')->with('success', 'Data category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->subCategories()->count() == 0) {
            // $category->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        }else{
            return response()->json(['message' => 'Item is used by other resources'], 403);
        }
    }
}
