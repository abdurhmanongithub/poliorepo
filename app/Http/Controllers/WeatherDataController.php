<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use App\Http\Requests\StoreWeatherDataRequest;
use App\Http\Requests\UpdateWeatherDataRequest;
use App\Imports\WeatherDataImport;
use App\Models\CurrentWeather;
use App\Models\ForecastWeather;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

                $items = $items->where('location', 'like', '%' . $request->get('location') . '%');
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
    public function getWeatherView()
    {
        $cities = [
            'Addis Ababa',
            'Dire Dawa',
            "mek'ele",
            'Gondar',
            'Hawassa',
            'Bahir Dar',
            'Jimma',
            'Adama',
            'Harar',
            'Arba Minch',
            'Asella',
            'Debre Birhan',
            'Debre Markos',
            'Dessie',
            'Dilla',
            'Gambela',
            'Hosaena',
            'Jijiga',
            'Shashemene',
            'Sodo',
            'Weldiya',
            'Awassa',
            'Bishoftu',
            'Nekemte',
            'Goba',
            'Ambo',
            'Axum',
            'Adigrat',
            'Agaro',
            'Bedele',
            'Butajira',
            'Dembi Dolo',
            'Fiche',
            'Gimbi',
            'Mendi',
            'Metu',
            'Negele Boran',
            'Yirga Alem',
            "Agaro Town",
            "Dedo",
            "Gera",
            "Goma",
            "Gumay",
            "Kersa",
            "Limmu Kosa",
            "Limmu Sakka",
            "Mana",
            "Omo Nada",
            "Seka Chekorsa",
            "Setema",
            "Sigmo",
            "Tiro Afeta",
            "Yebu Town",
            "Gambella",
            "Chora Botor",
            "Saqqa"
        ];

        return view('weather.weather', compact('cities'));
    }
    public function getWeather(Request $request)
    {
        try {
            $this->validate($request, [
                'city' => 'required|string'
            ]);

            $client = new Client();
            $apiKey = env('OPENWEATHER_API_KEY');
            $selectedCity = $request->input('city');
            $currentWeatherResponse = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$selectedCity}&appid={$apiKey}&units=metric");
            $forecastWeatherResponse = Http::get("http://api.openweathermap.org/data/2.5/forecast?q={$selectedCity}&appid={$apiKey}&units=metric");

            $currentWeather = $currentWeatherResponse->json();
            $forecastWeather = $forecastWeatherResponse->json();


            CurrentWeather::create([
                'city' => $selectedCity,
                'temperature' => $currentWeather['main']['temp'],
                'humidity' => $currentWeather['main']['humidity'],
                'wind_speed' => $currentWeather['wind']['speed'],
                'pressure' => $currentWeather['main']['pressure'],
                'weather_description' => $currentWeather['weather'][0]['description'],
                'latitude' => $currentWeather['coord']['lat'],
                'longitude' => $currentWeather['coord']['lon'],
            ]);
            foreach ($forecastWeather['list'] as $forecast) {
                $forecastTime = Carbon::parse($forecast['dt_txt']);

                $existingForecastWeather = ForecastWeather::where('city', $selectedCity)
                    ->where('forecast_time', $forecastTime)
                    ->first();

                if (!$existingForecastWeather) {
                    ForecastWeather::create([
                        'city' => $selectedCity,
                        'forecast_time' => $forecastTime,
                        'temperature' => $forecast['main']['temp'],
                        'humidity' => $forecast['main']['humidity'],
                        'wind_speed' => $forecast['wind']['speed'],
                        'pressure' => $forecast['main']['pressure'],
                        'weather_description' => $forecast['weather'][0]['description'],
                    ]);
                }
            }

            // Current weather data
            $currentResponse = $client->get("http://api.openweathermap.org/data/2.5/weather?q={$selectedCity}&appid={$apiKey}&units=metric");
            $currentWeather = json_decode($currentResponse->getBody(), true);

            // 5-day forecast data
            $forecastResponse = $client->get("http://api.openweathermap.org/data/2.5/forecast?q={$selectedCity}&appid={$apiKey}&units=metric");
            $forecastWeather = json_decode($forecastResponse->getBody(), true);

            $cities = [
                'Addis Ababa',
                'Dire Dawa',
                "mek'ele",
                'Gondar',
                'Hawassa',
                'Bahir Dar',
                'Jimma',
                'Adama',
                'Harar',
                'Arba Minch',
                'Asella',
                'Debre Birhan',
                'Debre Markos',
                'Dessie',
                'Dilla',
                'Gambela',
                'Hosaena',
                'Jijiga',
                'Shashemene',
                'Sodo',
                'Weldiya',
                'Awassa',
                'Bishoftu',
                'Nekemte',
                'Goba',
                'Ambo',
                'Axum',
                'Adigrat',
                'Agaro',
                'Bedele',
                'Butajira',
                'Dembi Dolo',
                'Fiche',
                'Gimbi',
                'Mendi',
                'Metu',
                'Negele Boran',
                'Yirga Alem',
                "Agaro Town",
                "Dedo",
                "Gera",
                "Goma",
                "Gumay",
                "Kersa",
                "Limmu Kosa",
                "Limmu Sakka",
                "Mana",
                "Omo Nada",
                "Seka Chekorsa",
                "Setema",
                "Sigmo",
                "Tiro Afeta",
                "Yebu Town",
                "Gambella",
                "Chora Botor",
                "Saqqa"
            ];
            return view('weather.weather', [
                'currentWeather' => $currentWeather,
                'forecastWeather' => $forecastWeather,
                'selectedCity' => $selectedCity,
                'cities' => $cities
            ]);
        } catch (Exception $exception) {
            // dd('d');
            return redirect()->back()->with('error', $exception->getMessage());

        }
    }
}
