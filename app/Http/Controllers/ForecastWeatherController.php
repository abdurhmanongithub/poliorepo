<?php

namespace App\Http\Controllers;

use App\Models\ForecastWeather;
use App\Http\Requests\StoreForecastWeatherRequest;
use App\Http\Requests\UpdateForecastWeatherRequest;

class ForecastWeatherController extends Controller
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
    public function store(StoreForecastWeatherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ForecastWeather $forecastWeather)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForecastWeather $forecastWeather)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateForecastWeatherRequest $request, ForecastWeather $forecastWeather)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForecastWeather $forecastWeather)
    {
        //
    }
}
