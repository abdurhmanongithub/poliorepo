@extends('base')
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
    <div class="row">
        <div class="col-12">
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Data Per Category</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm">More than
                            {{ number_format($totalData, 0, '.', ',') }} data available</span>
                    </h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#category_chart_view">Chart
                                    View</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4" data-toggle="tab" href="#category_tabular_view">Tabular
                                    View</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2 pb-0">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="category_tabular_view">
                            @include('dashboard.category.tabular_view')
                        </div>
                        <div class="tab-pane fade active show" id="category_chart_view">
                            @include('dashboard.category.chart_view')
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
@endsection
