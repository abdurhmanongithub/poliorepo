<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Models\CommunityType;
use App\Models\SubCategory;
use App\Models\Woreda;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Community::paginate(10);
        $woredas = Woreda::all();
        $communityTypes = CommunityType::all();
        $subCategories = Community::all();
        return view('community.index', compact('items', 'communityTypes', 'subCategories', 'woredas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $community = new Community();
        $woredas = Woreda::all();
        $communityTypes = CommunityType::all();
        $subCategories = SubCategory::all();
        return view('community.create', compact('community', 'communityTypes', 'subCategories', 'woredas'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => [
                'required',
                'regex:/^(\+251|0)9[0-9]{8}/'
            ],

        ]);
        Community::updateOrCreate(

            [
                'full_name' => $request->get('full_name'),
                'gender' => $request->get('gender'),
                'woreda_id' => $request->get('woreda_id'),
                'community_type_id' => $request->get('community_type_id'),
                // 'sub_category_id' => $request->get('sub_category_id'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]
        );
        return redirect()->route('community.index')->with('success', ' community type created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $Community)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        // dd('s');
        $woredas = Woreda::all();
        $communityTypes = CommunityType::all();
        $subCategories = Community::all();
        return view('community.edit', compact('community', 'communityTypes', 'subCategories', 'woredas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
        $request->validate([
            'phone' => [
                'required',
                'regex:/^(\+251|0)9[0-9]{8}/'
            ],

        ]);

        $community->update(
            [
                'full_name' => $request->get('full_name'),
                'gender' => $request->get('gender'),
                'woreda_id' => $request->get('woreda_id'),
                'community_type_id' => $request->get('community_type_id'),
                // 'sub_category_id' => $request->get('sub_category_id'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]
        );
        return redirect()->route('community.index')->with('success', 'Community type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        $community->delete();
        return response()->json(['message' => 'Item deleted successfully.'], 200);
        // if ($community->count() == 0) {
        //     return response()->json(['message' => 'Item deleted successfully.'], 200);
        // } else {
        //     return response()->json(['message' => 'Item is used by other resources'], 403);
        // }
    }
}
