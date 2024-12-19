@extends('base_fluid')
@section('title', 'Dashboard')
@section('content')
    {{-- <div class="row">
        <div class="col-xl-3">
            <!--begin::Stats Widget 29-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
                style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        @include('svg.users')
                    </span>
                    <span
                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ number_format($totalUsers, 0, '.', ',') }}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Total Users</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 29-->
        </div>
        <div class="col-xl-3">
            <!--begin::Stats Widget 29-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
                style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        @include('svg.chart')
                    </span>
                    <span
                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ number_format($totalData, 0, '.', ',') }}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Total Data Imported</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 29-->
        </div>
        <div class="col-xl-3">
            <!--begin::Stats Widget 29-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
                style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        @include('svg.briefcase')
                    </span>
                    <span
                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ number_format($totalCategories, 0, '.', ',') }}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Total Categories</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 29-->
        </div>
        <div class="col-xl-3">
            <!--begin::Stats Widget 29-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
                style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        @include('svg.group_folder')
                    </span>
                    <span
                        class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ number_format($totalSubCategories, 0, '.', ',') }}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Total Sub Categories</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 29-->
        </div>
    </div> --}}

    <div style="text-align: center; padding: 30px 20px; background-color: #0056b3; color: white; border-bottom: 5px solid #003d80;">
        <h1 style="font-size: 1.25em; margin: 0; line-height: 1.3; text-transform: capitalize;">
            Insights from Ethiopian Acute Flaccid Paralysis Surveillance Data
        </h1>
        <p style="font-size: 1em; margin: 10px 0 0; font-style: italic; color: #d0e7ff;">
            Comprehensive analysis and Trends
        </p>
        <hr style="border: 0; height: 1px; background: #d0e7ff; margin: 20px 0;">
        <ul class="nav nav-tabs nav-tabs-line" style="justify-content: center; margin-top: 10px;">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_pane_polio_lab_data_chart">Lab Data Insights</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_pane_ephi_data_chart">AFP Surveillance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#core_group_data_chart" tabindex="-1" aria-disabled="true">Other Key Data</a>
            </li>
        </ul>
    </div>

    <!--<ul class="nav nav-tabs nav-tabs-line">-->
    <!--    <li class="nav-item">-->
    <!--        <a class="nav-link active" data-toggle="tab" href="#tab_pane_polio_lab_data_chart">Lab Data Insights</a>-->
    <!--    </li>-->
    <!--    <li class="nav-item">-->
    <!--        <a class="nav-link" data-toggle="tab" href="#tab_pane_ephi_data_chart">AFP Surveillance Data</a>-->
    <!--    </li>-->
    <!--    <li class="nav-item">-->
    <!--        <a class="nav-link" data-toggle="tab" href="#core_group_data_chart" tabindex="-1" aria-disabled="true">Other Insights</a>-->
    <!--    </li>-->
    <!--</ul>-->
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="tab_pane_a_f_p_data_data_chart" role="tabpanel"
            aria-labelledby="tab_pane_a_f_p_data_data_chart">
            <div class="row">
                @include('afp-data.charts.index')
            </div>
        </div>
        <div class="tab-pane fade" id="tab_pane_ephi_data_chart" role="tabpanel" aria-labelledby="tab_pane_ephi_data_chart">
            <div class="row">
                @include('afp-data.charts.ephi-chart')
            </div>
        </div>
        <div class="tab-pane fade" id="core_group_data_chart" role="tabpanel" aria-labelledby="core_group_data_chart">
            <div class="row">
                @include('core-group-data.charts.index')
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/some-other-library@3.35.3/dist/library.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    </script>
@endpush
