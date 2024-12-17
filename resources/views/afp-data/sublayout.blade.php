<?php $disableContianer = true; ?>
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
                        </div>
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Take Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="{{ route('afp-import.template.download', []) }}" class="navi-link">
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
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            {{-- <div class="flex-wrap d-flex align-items-center">
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

            </div> --}}
            <div class="flex-wrap d-flex align-items-center">
                <ul class="nav nav-tabs nav-tabs-line">
                    <li class="nav-item">
                        <a class="nav-link {{ strpos(Route::currentRouteName(), 'afp-data.index') === 0 ? 'active' : '' }}"
                            href="{{ route('afp-data.index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ strpos(Route::currentRouteName(), 'afp-data.data-management') === 0 ? 'active' : '' }}"
                            href="{{ route('afp-data.data-management') }}">Data Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ strpos(Route::currentRouteName(), 'afp-data.import.view') === 0 ? 'active' : '' }}"
                            href="{{ route('afp-data.import.view', []) }}">Import Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ strpos(Route::currentRouteName(), 'afp-data.source') === 0 ? 'active' : '' }}" href="{{ route('afp-data.source', ['id'=>1]) }}">Source Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ strpos(Route::currentRouteName(), 'afp-data.source') === 0 ? 'active' : '' }}" href="{{ route('afp-data.source', ['id'=>1]) }}">Knowledge Store</a>
                    </li>
                </ul>
            </div>
            <!--begin: Items-->
        </div>
    </div>
    <div class="d-flex flex-row">
        {{-- <div class="p0 flex-row-auto col-md-3 offcanvas-mobile" style="padding: 0" id="kt_profile_aside">
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
        </div> --}}
        <!--end::Aside-->
        <!--begin::Content-->
        <div class="flex-row-fluid ml-md-12" style="margin-left: 5px!important;">
            <!--begin::Card-->
            @yield('nav_content')
        </div>
        <!--end::Content-->
    </div>
@endsection
