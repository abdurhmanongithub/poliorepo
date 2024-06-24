@extends('base')
@section('title','Nasa Cimate view')
@section('content')
<div class="container mt-5">
    <h1>NASA Data API Request</h1>
    <form action="{{ route('fetch.data') }}" method="POST" id="data-form">
        @csrf
        <div class="mb-3">
            <label for="start" class="form-label">Start Date (YYYYMMDD)</label>
            <input type="text" class="form-control" id="start" name="start" required>
        </div>
        <div class="mb-3">
            <label for="end" class="form-label">End Date (YYYYMMDD)</label>
            <input type="text" class="form-control" id="end" name="end" required>
        </div>
        <div class="mb-3">
            <label for="temporal" class="form-label">Temporal</label>
            <select class="form-control" id="temporal" name="temporal" required>
                <option value="hourly">Hourly</option>
                <option value="daily" selected>Daily</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="spatial" class="form-label">Spatial</label>
            <select class="form-control" id="spatial" name="spatial" required>
                <option value="point">Point</option>
                <option value="regional" selected>Regional</option>
            </select>
        </div>
        <div id="point-inputs">
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude">
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude">
            </div>
        </div>
        <div id="regional-inputs">
            <div class="mb-3">
                <label for="latitude-min" class="form-label">Latitude Min</label>
                <input type="text" class="form-control" id="latitude-min" name="latitude-min">
            </div>
            <div class="mb-3">
                <label for="latitude-max" class="form-label">Latitude Max</label>
                <input type="text" class="form-control" id="latitude-max" name="latitude-max">
            </div>
            <div class="mb-3">
                <label for="longitude-min" class="form-label">Longitude Min</label>
                <input type="text" class="form-control" id="longitude-min" name="longitude-min">
            </div>
            <div class="mb-3">
                <label for="longitude-max" class="form-label">Longitude Max</label>
                <input type="text" class="form-control" id="longitude-max" name="longitude-max">
            </div>
        </div>
        <div class="mb-3">
            <label for="community" class="form-label">Community</label>
            <input type="text" class="form-control" id="community" name="community" required>
        </div>
        <div class="mb-3">
            <label for="parameters" class="form-label">Parameters
                (comma-separated)</label>
            <input type="text" class="form-control" id="parameters" name="parameters" required>
        </div>
        <div class="mb-3">
            <label for="format" class="form-label">Format</label>
            <input type="text" class="form-control" id="format" name="format">
        </div>
        <div class="mb-3">
            <label for="user" class="form-label">User</label>
            <input type="text" class="form-control" id="user" name="user">
        </div>
        <div class="mb-3">
            <label for="header" class="form-label">Header</label>
            <select class="form-control" id="header" name="header">
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="time-standard" class="form-label">Time Standard</label>
            <select class="form-control" id="time-standard" name="time-standard">
                <option value="lst" selected>LST</option>
                <option value="utc">UTC</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="mt-5" id="result"></div>
</div>


@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const spatialSelect = document.getElementById('spatial');
        const pointInputs = document.getElementById('point-inputs');
        const regionalInputs = document.getElementById('regional-inputs');

        function toggleInputs() {
            if (spatialSelect.value === 'point') {
                pointInputs.style.display = 'block';
                regionalInputs.style.display = 'none';
            } else {
                pointInputs.style.display = 'none';
                regionalInputs.style.display = 'block';
            }
        }

        spatialSelect.addEventListener('change', toggleInputs);
        toggleInputs();
    });

</script>

@endpush
