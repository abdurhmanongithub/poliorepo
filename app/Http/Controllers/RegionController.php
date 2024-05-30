<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Region::paginate(10);
        return view('region.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $region = new Region();
        return view('region.create', compact('region'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Region::updateOrCreate(
            [
                'name' => $request->get('name'),
            ],
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
            ]
        );
        return redirect()->route('region.index')->with('success', ' Region created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        return view('region.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {

        $region->update(
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
            ]
        );
        return redirect()->route('region.index')->with('success', 'Regions updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        if ($region->zones()->count() == 0) {
            // $category->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Item is used by other resources'], 403);
        }
    }
}
