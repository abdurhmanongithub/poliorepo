@include('afp-data.charts.polio-virus-detection-by-year-chart')
@include('afp-data.charts.polio-emerging-seasons-chart')
@include('afp-data.charts.polio-emerging-months-chart')
@include('afp-data.charts.polio-virus-distribution-by-gender-chart')
@include('afp-data.charts.suspected-polio-virus-cell-culturing-results-chart')
@include('afp-data.charts.polio-cases-by-province-chart')
@include('afp-data.charts.age-group-distribution')
@if (Auth::check())
    @include('afp-data.charts.missing-data')
@endif
@include('afp-data.charts.get-case-trends')
@include('afp-data.charts.get-histogram-data')
@include('afp-data.charts.polio-virus-detection-by-year-line-chart')
{{-- @include('afp-data.charts.polio-case-trends-over-time-chart') --}}
