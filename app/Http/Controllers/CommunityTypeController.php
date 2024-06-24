<?php

namespace App\Http\Controllers;

use App\Models\CommunityType;
use App\Http\Requests\StoreCommunityTypeRequest;
use App\Http\Requests\UpdateCommunityTypeRequest;
use Illuminate\Http\Request;

class CommunityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = CommunityType::paginate(10);
        return view('community_types.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CommunityType::updateOrCreate(
            [
                'name' => $request->get('name'),
            ],
            [
                'name' => $request->get('name'),
            ]
        );
        return redirect()->route('community-type.index')->with('success', ' community type created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityType $communityType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityType $communityType)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityType $communityType)
    {

        $communityType->update(
            [
                'name' => $request->get('name'),
            ]
        );
        return redirect()->route('community-type.index')->with('success', 'Community type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityType $communityType)
    {
        if ($communityType->communities()->count() == 0) {
            $communityType->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Item is used by other resources'], 403);
        }
    }
}
