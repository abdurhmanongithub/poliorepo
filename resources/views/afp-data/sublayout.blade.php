@extends('base')
@section('content')
    @php
        $miniSide = true;
    @endphp
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <div class="d-flex">
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin: Title-->
                    <div class="flex-wrap d-flex align-items-center justify-content-between">
                        <div class="mr-3">
                            <!--begin::Name-->
                            <a href="#"
                                class="mr-3 d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold">
                                {{ 'AFP - EPHI Data' }}
                                - <span> Data Schema</span>
                                <i class="ml-2 flaticon2-correct text-success icon-md"></i></a>
                            <!--end::Name-->
                            <div class="flex-wrap my-2 d-flex">
                                <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                    <span class="mr-1 svg-icon svg-icon-md svg-icon-gray-500">
                                        <i class="fa fa-location"></i>
                                    </span>
                                    {{-- {{ $dataSchema->subCategory?->name }} / {{ $dataSchema->subCategory?->category?->name }} --}}
                                </a>
                            </div>
                        </div>
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Take Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fal fa-download"></i>
                                                </span>
                                                <span class="navi-text">Download Import Form</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Title-->
                    <!--begin: Content-->
                    {{-- <div class="flex-wrap d-flex align-items-center justify-content-between">
                        <div class="py-5 mr-5 flex-grow-1 font-weight-bold text-dark-50 py-lg-2 w-100">
                            There is no description of the center
                            <br>
                        </div>
                    </div>  --}}
                    <!--end: Content-->
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            <div class="flex-wrap d-flex align-items-center">
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Total Datas</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalDatas }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Number of Attributes</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $columnCount }}</span>
                    </div>

                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Models</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>0</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column flex-lg-fill">
                        <span class="text-dark-75 font-weight-bolder font-size-sm">Total Resource</span>
                        <a href="#" class="text-primary font-weight-bolder">0</a>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-users icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column flex-lg-fill">
                        <span class="text-dark-75 font-weight-bolder font-size-sm">Total Community</span>
                        <a href="#" class="text-primary font-weight-bolder">{{ 0 }}</a>


                    </div>
                </div>
                <!--end: Item-->

            </div>
            <!--begin: Items-->
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="p0 flex-row-auto col-md-3 offcanvas-mobile" style="padding: 0" id="kt_profile_aside">
            <div class="card card-custom card-stretch">
                <div class="card-body pt-6 py-0" style="padding-left: 2px; padding-right: 2px;">
                    <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                        <div class="navi-item mb-2">
                            <a href="{{ route('afp-data.index') }}"
                                class="navi-link  {{ strpos(Route::currentRouteName(), 'afp-data.index') === 0 ? 'active' : '' }} py-4">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Dashboard</span>
                            </a>
                        </div>
                        {{-- <div class="navi-item mb-2">
                            <a href="0"
                                class="navi-link  {{ strpos(Route::currentRouteName(), 'data_schema.manage') === 0 ? 'active' : '' }} py-4">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Schema Management</span>
                            </a>
                        </div> --}}

                        <div class="navi-item mb-2">
                            <a href="{{ route('afp-data.data-management') }}"
                                class="navi-link {{ strpos(Route::currentRouteName(), 'afp-data.data-management') === 0 ? 'active' : '' }} py-4">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Data Management</span>
                            </a>
                        </div>

                        <div class="navi-item mb-2">
                            <a href="{{ route('afp-data.import.view', []) }}"
                                class="navi-link {{ strpos(Route::currentRouteName(), 'afp-data.import.view') === 0 ? 'active' : '' }} py-4">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Import Data</span>
                            </a>
                        </div>
                        <div class="navi-item mb-2">
                            <a href=""
                                class="navi-link {{ strpos(Route::currentRouteName(), 'data_schema.data.source') === 0 ? 'active' : '' }} py-4">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Source Management</span>
                            </a>
                        </div>
                        {{-- <!--<div class="navi-item mb-2">-->
                        <!--    <a href="{{ route('data_schema.dashboard.management', $dataSchema->id) }}" class="navi-link {{ strpos(Route::currentRouteName(), 'data_schema.dashboard.management') === 0 ? 'active' : '' }} py-4">-->
                        <!--        <span class="navi-icon mr-2">-->
                        <!--            <i class="fa fa-circle"></i>-->
                        <!--        </span>-->
                        <!--        <span class="navi-text font-size-lg">Dashboard Management</span>-->
                        <!--    </a>-->
                        <!--</div>-->
                        <!--<div class="navi-item mb-2">-->
                        <!--    <a href="{{ route('data_schema.resource.management', $dataSchema->id) }}" class="navi-link {{ strpos(Route::currentRouteName(), 'data_schema.resource.management') === 0 ? 'active' : '' }} py-4">-->
                        <!--        <span class="navi-icon mr-2">-->
                        <!--            <i class="fa fa-circle"></i>-->
                        <!--        </span>-->
                        <!--        <span class="navi-text font-size-lg">Resource Management</span>-->
                        <!--    </a>-->
                        <!--</div>--> --}}

                        <div class="navi-item mb-2">
                            <a href=""
                                class="navi-link {{ strpos(Route::currentRouteName(), 'data_schema.community.management') === 0 ? 'active' : '' }} py-4">

                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Community Management</span>
                            </a>
                        </div>
                        <div class="navi-item mb-2">
                            <a href="" class="navi-link  py-4">


                                <span class="navi-icon mr-2">
                                    <i class="fa fa-circle"></i>
                                </span>
                                <span class="navi-text font-size-lg">Sms Managent</span>
                            </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!--end::Aside-->
        <!--begin::Content-->
        <div class="flex-row-fluid ml-md-9" style="margin-left: 5px!important;">
            <!--begin::Card-->
            @yield('nav_content')
        </div>
        <!--end::Content-->
    </div>
@endsection
