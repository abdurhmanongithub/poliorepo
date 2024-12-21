@if (Auth::check())
@include('core-group-data.charts.missing-data')
@endif
@include('core-group-data.charts.regional_distribution')
@include('core-group-data.charts.gps-corelation')
@include('core-group-data.charts.get-case-counts')

@include('core-group-data.charts.core-map-chart')
