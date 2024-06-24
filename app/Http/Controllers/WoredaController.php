<?php

namespace App\Http\Controllers;

use App\Models\Woreda;
use App\Http\Requests\StoreWoredaRequest;
use App\Http\Requests\UpdateWoredaRequest;
use App\Models\Zone;
use Illuminate\Http\Request;

class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Woreda::paginate(10);
        $zones = Zone::all();
        return view('woreda.index', compact('items', 'zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $woreda = new Woreda();
        $zones = Zone::all();
        return view('zones.index', compact('woreda', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Woreda::updateOrCreate(
            [
                'name' => $request->get('name'),
                'zone_id' => $request->get('zone_id'),
            ],
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'zone_id' => $request->get('zone_id'),
            ]
        );
        return redirect()->route('woreda.index')->with('success', 'Woreda created successfully');
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
    public function edit(Woreda $woreda)
    {
        $zones = Zone::all();
        return view('woreda.edit', compact('zones', 'woreda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Woreda $woreda)
    {

        $woreda->update(
            [
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'zone_id' => $request->get('zone_id'),
            ]
        );
        return redirect()->route('woreda.index')->with('success', 'woreda updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Woreda $woreda)
    {
        if ($woreda->woredas()->count() == 0) {
            $woreda->delete();
            return response()->json(['message' => 'Item deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Item is used by other resources'], 403);

        }
    }
}
