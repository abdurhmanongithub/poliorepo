@extends('base')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
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
    </div>
    <div class="row">
        @include('core-group-data.charts.index')
        @include('afp-data.charts.index')
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/some-other-library@3.35.3/dist/library.min.js"></script>
@endpush
