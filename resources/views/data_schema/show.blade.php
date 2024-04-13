@extends('layouts.sublayout')
@section('nav_content')
<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Dashboard</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $dataSchema->name }}</span>
        </div>
        <div class="card-toolbar">
            {{-- <button type="reset" class="btn btn-success mr-2">Export Report</button>  --}}
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-4">
                <!--begin: Stats Widget 19-->
                <div class="card card-custom bg-light-success card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-3">
                        <a href="#" class="card-title font-weight-bolder text-success text-hover-state-dark font-size-h6 mb-4 d-block">Available
                            Data</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                            <span class="text-dark-75 font-size-h2 font-weight-bolder mr-2">{{ $dataSchema->datas()->count() }}</span> Records
                        </div>
                        <div class="progress progress-xs mt-7 bg-success-o-60">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end:: Body-->
                </div>
                <!--end: Stats:Widget 19-->
            </div>
            <div class="col-xl-4">
                <!--begin::Stats Widget 20-->
                <div class="card card-custom bg-light-warning card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-warning font-size-h6 mb-4 text-hover-state-dark d-block">Available Attributes</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                            @if ($dataSchema->structure)

                            <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ count($dataSchema->structure) }}</span>

                            @endif

                        </div>
                        <div class="progress progress-xs mt-7 bg-warning-o-60">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 87%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 20-->
            </div>
            <div class="col-xl-4">
                <!--begin::Stats Widget 21-->
                <div class="card card-custom bg-light-info card-stretch gutter-b">
                    <!--begin::ody-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">Available Models</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                            <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">0</span>
                        </div>
                        <div class="progress progress-xs mt-7 bg-info-o-60">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 52%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 21-->
            </div>
        </div>
    </div>
</div>
@endsection
