<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Illuminate\Support\Facades\Validator;
use RakibDevs\Weather\Weather;

class ApiController extends Controller
{
    //
    public function nasaIndex()
    {
        return view('api_view.nasa');
    }

    public function fetchData(Request $request)
    {
        $wt = new Weather();

        $info = $wt->getCurrentByCity('dhaka');
        dd($info);
        // Initial validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'start' => 'required|integer|digits:8',
                'end' => 'required|integer|digits:8',
                'temporal' => 'required|string|in:hourly,daily,monthly',
                'spatial' => 'required|string|in:point,regional',
                'latitude' => 'required_if:spatial,point|nullable|numeric',
                'longitude' => 'required_if:spatial,point|nullable|numeric',
                'latitude-min' => 'required_if:spatial,regional|nullable|numeric',
                'latitude-max' => 'required_if:spatial,regional|nullable|numeric',
                'longitude-min' => 'required_if:spatial,regional|nullable|numeric',
                'longitude-max' => 'required_if:spatial,regional|nullable|numeric',
                'community' => 'required|string',
                'parameters' => 'required|string',
                'format' => 'nullable|string',
                'user' => 'nullable|string',
                'header' => 'nullable|boolean',
                'time-standard' => 'nullable|string',
            ]
        );

        // Check if initial validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Custom validation for date difference and latitude difference (for regional)
        $startDate = Carbon::createFromFormat('Ymd', $request->input('start'));
        $endDate = Carbon::createFromFormat('Ymd', $request->input('end'));
        $dateDiff = $startDate->diffInDays($endDate);

        if ($dateDiff >= 365) {
            return redirect()->back()->with('error', 'The date difference must be less than 365 days.')->withInput();
        }

        if ($request->input('spatial') === 'regional') {
            $latitudeMin = $request->input('latitude-min');
            $latitudeMax = $request->input('latitude-max');
            $latitudeDiff = $latitudeMax - $latitudeMin;

            if ($latitudeDiff < 2) {
                return redirect()->back()->with('error', 'The difference between latitude-min and latitude-max must be at least 2.')->withInput();
            }
        }

        // Build the base URL
        $baseUrl = "https://power.larc.nasa.gov/api/temporal/{$request->input('temporal')}/{$request->input('spatial')}";

        // Build the query parameters
        $queryParams = [
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'community' => $request->input('community'),
            'parameters' => $request->input('parameters'),
            'format' => $request->input('format', 'csv'),  // default to 'csv'
            'user' => $request->input('user'),
            'header' => $request->input('header', true),  // default to true
            'time-standard' => $request->input('time-standard', 'lst'),  // default to 'lst'
        ];

        // Add spatial parameters based on the request type
        if ($request->input('spatial') === 'point') {
            $queryParams['latitude'] = $request->input('latitude');
            $queryParams['longitude'] = $request->input('longitude');
        } else {
            $queryParams['latitude-min'] = $request->input('latitude-min');
            $queryParams['latitude-max'] = $request->input('latitude-max');
            $queryParams['longitude-min'] = $request->input('longitude-min');
            $queryParams['longitude-max'] = $request->input('longitude-max');
        }

        // Make the request to the NASA API
        $response = HttpCache::get($baseUrl, $queryParams);

        // Return the response from the NASA API
        return view('index', [
            'result' => $response->body(),
            'status' => $response->status(),
        ])->withInput($request->all());
    }
}
