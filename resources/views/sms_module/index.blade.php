@extends('base')
@section('title', 'Create a new Region')
@section('content')
<div class="d-flex flex-row">
    <div class="p0 flex-row-auto col-md-3 offcanvas-mobile" style="padding: 0" id="kt_profile_aside">
        <div class="card card-custom card-stretch">
            <div class="card-body pt-6 py-0" style="padding-left: 2px; padding-right: 2px;">
                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1" class="navi-link   py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Send custom sms</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/manage" class="navi-link   py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Schema Management</span>
                        </a>
                    </div>

                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/data" class="navi-link  py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Data Management</span>
                        </a>
                    </div>

                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/data/import/view" class="navi-link active py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Import Data</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/data/source" class="navi-link  py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Source Management</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/dashboard_management" class="navi-link  py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Dashboard Management</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="http://127.0.0.1:8000/data_schema/1/resource_management" class="navi-link  py-4">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-circle"></i>
                            </span>
                            <span class="navi-text font-size-lg">Resource Management</span>
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
        <div class="card card-custom">
            <div class="card-header card-header-tabs-line">
                <div class="card-title">
                    <h3 class="card-label">Import Data</h3>
                </div>
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#excel_tab_pane">
                                <span class="nav-icon">
                                    <i class="flaticon2-chat-1"></i>
                                </span>
                                <span class="nav-text">Excel</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#api_tab_pane">
                                <span class="nav-icon">
                                    <i class="flaticon2-drop"></i>
                                </span>
                                <span class="nav-text">API</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="excel_tab_pane" role="tabpanel" aria-labelledby="excel_tab_pane">
                        <form method="POST" action="http://127.0.0.1:8000/data_schema/1/data/import/excel/preview" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="A24yegMSNJEskEHoWwHWw1Vs8H23Lz8jvCN1rLyj" autocomplete="off">
                            <div class="form-group">
                                <label>Choose Excel File</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="excel_file" name="excel_file">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Import From Excel</button>
                                <a href="http://127.0.0.1:8000/data_schema/1/data/import/template/download" class="btn btn-primary">Download Import From</a>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="api_tab_pane" role="tabpanel" aria-labelledby="api_tab_pane">
                        <form method="POST" action="http://127.0.0.1:8000/data_schema/1/data/import/api">
                            <input type="hidden" name="_token" value="A24yegMSNJEskEHoWwHWw1Vs8H23Lz8jvCN1rLyj" autocomplete="off">
                            <div class="form-group">
                                <label for="api_endpoint">API Endpoint</label>
                                <input type="text" class="form-control" id="api_endpoint" name="api_endpoint" placeholder="Enter API Endpoint URL">
                            </div>
                            <!-- You can add more input fields here if needed -->
                            <button type="submit" class="btn btn-primary">Sync from API</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end::Content-->
</div>

@endsection
