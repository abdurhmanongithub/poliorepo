<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use App\Http\Requests\StoreWeatherDataRequest;
use App\Http\Requests\UpdateWeatherDataRequest;
use App\Imports\WeatherDataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WeatherDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = WeatherData::latest();
        if ($request->get('type') == 'filter') {
            // dd($request);
            if ($request->get('year')) {

                $items = $items->where('year', $request->get('year'));
            }
            if ($request->get('month')) {

                $items = $items->where('mo', $request->get('month'));
            }
            if ($request->get('dy')) {

                $items = $items->where('dy', $request->get('day'));
            }
            if ($request->get('location')) {

                $items = $items->where('location', $request->get('location'));
            }
        }
        //
        $items = $items->paginate(10); // Fetch all records from the table

        return view('weather.index', [
            'items' => $items
        ]);
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
    public function store(StoreWeatherDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WeatherData $weatherData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeatherData $weatherData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeatherDataRequest $request, WeatherData $weatherData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeatherData $weatherData)
    {
        //
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'location' => 'required|string',  // Validate the location input

        ]);
        $location = $request->input('location');

        Excel::import(new WeatherDataImport($location), $request->file('file'), );

        return redirect()->back()->with('success', 'Weather data imported successfully.');
    }
}
