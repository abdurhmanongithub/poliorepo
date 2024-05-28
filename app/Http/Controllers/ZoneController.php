<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Models\Region;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Zone::paginate(10);
        $regions = Region::all();
        return view('zones.index', compact('items', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zone = new Zone();
        $regions = Region::all();
        return view('zones.index', compact('zone', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Zone::updateOrCreate(
            [
                'name' => $request->get('name'),
                'region_id' => $request->get('region_id'),
            ],
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'region_id' => $request->get('region_id'),
            ]
        );
        return redirect()->route('zone.index')->with('success', 'Data Zone created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zoneReq)
    {
        $regions = Region::all();
        return view('zones.edit', compact('zone', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {

        $zone->update(
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'region_id' => $request->get('region_id'),
            ]
        );
        return redirect()->route('zone.index')->with('success', 'zone updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        if ($zone->woredas()->count() == 0) {
            $zone->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Item is used by other resources'], 403);

        }
    }

}
