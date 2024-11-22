@extends('base')
@section('title', 'Historical weather Datas')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMUeUkK5zKz5NHKYwrbGRRaF2FWZ5lw5r/M6A1r" crossorigin="anonymous">
<style>
    body {
        background: #e9ecef;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .weather-container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }
    .current-weather,
    .forecast {
        text-align: center;
        margin-bottom: 20px;
    }

    .current-weather h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .weather-icon {
        font-size: 4rem;
        color: #3498db;
    }

    .forecast-card {
        margin-bottom: 15px;
    }

    .forecast-card .card-body {
        padding: 10px;
    }

    .forecast-card h5 {
        font-size: 1rem;
    }

    .forecast-card .weather-icon {
        font-size: 2rem;
    }

    #map {
        height: 400px;
        margin-top: 20px;
    }
    .chart-container {
    margin-top: 30px;
    }
    ..forecast {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 20px;
    }

    .forecast h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #343a40;
    }

    .forecast-container {
    display: flex;
    overflow-x: auto;
    padding-bottom: 10px;
    scrollbar-width: thin;
    scrollbar-color: #888 #f8f9fa;
    }

    .forecast-container::-webkit-scrollbar {
    height: 8px;
    }

    .forecast-container::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
    }

    .forecast-card {
    flex: 0 0 auto;
    width: 150px;
    margin-right: 15px;
    transition: transform 0.3s ease-in-out;
    }

    .forecast-card:last-child {
    margin-right: 0;
    }

    .forecast-card .card {
    background-color: #ffffff;
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .forecast-card .card-body {
    text-align: center;
    }

    .forecast-card .card-title {
    font-size: 14px;
    margin-bottom: 10px;
    color: #343a40;
    }

    .weather-icon {
    font-size: 30px;
    color: #17a2b8;
    margin-bottom: 10px;
    }

    .forecast-card:hover {
    transform: scale(1.05);
    }

    .forecast-card p {
    font-size: 12px;
    margin: 0;
    color: #6c757d;
    }

    .forecast-card p strong {
    color: #343a40;
    }
</style>

@endpush
@section('content')
<div class="weather-container">
     @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
     @endif

    <h1 class="text-center">Weather Dashboard</h1>
    <form method="POST" action="{{ route('get-weather') }}">
        @csrf
        <div class="mb-3">
            <label for="city" class="form-label">Select City</label>
            <select class="form-select select2 form-control" id="city" name="city" required>
                <option value="" selected disabled>Choose a city</option>
                @foreach($cities as $city)
                <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Get Weather</button>
    </form>

    @if(isset($currentWeather))
    <div class="current-weather">
        <h2>Current Weather in <span class="text-info">{{ $selectedCity }}</h2>


        <i class="fas fa-cloud-sun weather-icon"></i>
        <p><strong>Temperature:</strong> {{ $currentWeather['main']['temp'] ?? 'N/A' }}°C</p>
        <p><strong>Humidity:</strong> {{ $currentWeather['main']['humidity'] ?? 'N/A' }}%</p>
        <p><strong>Wind Speed:</strong> {{ $currentWeather['wind']['speed'] ?? 'N/A' }} m/s</p>
        <p><strong>Pressure:</strong> {{ $currentWeather['main']['pressure'] ?? 'N/A' }} hPa</p>
    </div>

    <div id="map"></div>
    @endif

    @if(isset($forecastWeather))
    <div class="forecast">
        <h2>5-Day Forecast for {{ $selectedCity }}</h2>

        <div class="forecast-container" id="forecastContainer">
            @foreach($forecastWeather['list'] as $forecast)
            <div class="forecast-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ \Carbon\Carbon::parse($forecast['dt_txt'])->format('D, M d H:i') }}</h5>
                        <i class="fas fa-cloud-sun weather-icon"></i>
                        <p><strong>Temp:</strong> {{ $forecast['main']['temp'] ?? 'N/A' }}°C</p>
                        <p><strong>Humidity:</strong> {{ $forecast['main']['humidity'] ?? 'N/A' }}%</p>
                        <p><strong>Wind:</strong> {{ $forecast['wind']['speed'] ?? 'N/A' }} m/s</p>
                        <p><strong>Pressure:</strong> {{ $forecast['main']['pressure'] ?? 'N/A' }} hPa</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


            <h2>Visualization on Forecast for <span class="text-info">{{ $selectedCity }}</span></h2>



     <div class="chart-container row">
         <canvas id="temperatureChart" class="col-12"></canvas>
         <canvas id="humidityChart" class="col-6"></canvas>
         <canvas id="windSpeedChart" class="col-6"></canvas>
     </div>

    @endif
</div>

@endsection
@push('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
   const forecastContainer = document.getElementById('forecastContainer');
   let scrollAmount = 0;
   const scrollStep = 2; // Adjust the scroll speed
   const scrollInterval = 20; // Adjust the scroll interval (lower value = faster)

   function autoScroll() {
   scrollAmount += scrollStep;
   if (scrollAmount >= forecastContainer.scrollWidth - forecastContainer.clientWidth) {
   scrollAmount = 0; // Reset scroll amount to start from the beginning
   }
   forecastContainer.scrollTo({
   left: scrollAmount,
   behavior: 'smooth'
   });
   }

   setInterval(autoScroll, scrollInterval);

   @if(isset($currentWeather) && isset($currentWeather['coord']) && isset($currentWeather['weather'][0]))
   var map = L.map('map').setView([{{ $currentWeather['coord']['lat'] }}, {{ $currentWeather['coord']['lon'] }}], 10);

   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
   }).addTo(map);

   L.marker([{{ $currentWeather['coord']['lat'] }}, {{ $currentWeather['coord']['lon'] }}]).addTo(map)
   .bindPopup('<b>{{ $selectedCity }}</b><br>Weather: {{ $currentWeather['weather'][0]['description'] ?? 'N/A' }}<br>Temperature: {{ $currentWeather['main']['temp'] ?? 'N/A' }}°C')

   .openPopup();
   @endif
   @if(isset($forecastWeather))
   const labels = @json(array_map(function($forecast) {
   return \Carbon\Carbon::parse($forecast['dt_txt'])->format('D H:i');
   }, $forecastWeather['list']));

   const temperatureData = @json(array_map(function($forecast) {
   return $forecast['main']['temp'];
   }, $forecastWeather['list']));

   const humidityData = @json(array_map(function($forecast) {
   return $forecast['main']['humidity'];
   }, $forecastWeather['list']));

   const windSpeedData = @json(array_map(function($forecast) {
   return $forecast['wind']['speed'];
   }, $forecastWeather['list']));

   const temperatureChartCtx = document.getElementById('temperatureChart').getContext('2d');
   const humidityChartCtx = document.getElementById('humidityChart').getContext('2d');
   const windSpeedChartCtx = document.getElementById('windSpeedChart').getContext('2d');

   new Chart(temperatureChartCtx, {
   type: 'line',
   data: {
   labels: labels,
   datasets: [{
   label: 'Temperature (°C)',
   data: temperatureData,
   borderColor: 'rgba(255, 99, 132, 1)',
   backgroundColor: 'rgba(255, 99, 132, 0.2)',
   fill: true
   }]
   },
   options: {
   responsive: true,
   scales: {
   x: {
   title: {
   display: true,
   text: 'Time'
   }
   },
   y: {
   title: {
   display: true,
   text: 'Temperature (°C)'
   }
   }
   }
   }
   });

   new Chart(humidityChartCtx, {
   type: 'line',
   data: {
   labels: labels,
   datasets: [{
   label: 'Humidity (%)',
   data: humidityData,
   borderColor: 'rgba(54, 162, 235, 1)',
   backgroundColor: 'rgba(54, 162, 235, 0.2)',
   fill: true
   }]
   },
   options: {
   responsive: true,
   scales: {
   x: {
   title: {
   display: true,
   text: 'Time'
   }
   },
   y: {
   title: {
   display: true,
   text: 'Humidity (%)'
   }
   }
   }
   }
   });

   new Chart(windSpeedChartCtx, {
   type: 'line',
   data: {
   labels: labels,
   datasets: [{
   label: 'Wind Speed (m/s)',
   data: windSpeedData,
   borderColor: 'rgba(75, 192, 192, 1)',
   backgroundColor: 'rgba(75, 192, 192, 0.2)',
   fill: true
   }]
   },
   options: {
   responsive: true,
   scales: {
   x: {
   title: {
   display: true,
   text: 'Time'
   }
   },
   y: {
   title: {
   display: true,
   text: 'Wind Speed (m/s)'
   }
   }
   }
   }
   });
   @endif

   });

</script>
@endpush
