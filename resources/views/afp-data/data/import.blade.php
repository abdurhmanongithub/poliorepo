@extends('afp-data.sublayout')
@section('title', 'Import Page')
@section('nav_content')
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
                    <form method="POST" action="{{ route('afp-data.import.preview') }}"
                        enctype="multipart/form-data">
                        @csrf
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
                            <a href="" class="btn btn-primary">Download Import From</a>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="api_tab_pane" role="tabpanel" aria-labelledby="api_tab_pane">
                    <form method="POST"
                        action="">
                        @csrf
                        <div class="form-group">
                            <label for="api_endpoint">API Endpoint</label>
                            <input type="text" class="form-control" id="api_endpoint" name="api_endpoint"
                                placeholder="Enter API Endpoint URL">
                        </div>
                        <!-- You can add more input fields here if needed -->
                        <button type="submit" class="btn btn-primary">Sync from API</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
