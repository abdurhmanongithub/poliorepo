<?php

namespace App\Http\Controllers;

use App\Models\CurrentWeather;
use App\Http\Requests\StoreCurrentWeatherRequest;
use App\Http\Requests\UpdateCurrentWeatherRequest;

class CurrentWeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreCurrentWeatherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CurrentWeather $currentWeather)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurrentWeather $currentWeather)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrentWeatherRequest $request, CurrentWeather $currentWeather)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrentWeather $currentWeather)
    {
        //
    }
}
