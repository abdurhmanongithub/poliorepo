@extends('layouts.sublayout')
@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script>
        function eraseData() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#eraseForm').submit();
                }
            });
        }
    </script>

    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @include('data_schema.data.table_script')
@endpush
@section('nav_content')
    @include('data_schema.data.export_modal')
    <form action="{{ route('data_schema.data.erase', ['data_schema' => $dataSchema->id]) }}" method="POST" id="eraseForm">
        @csrf</form>
    {{--  <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Data Management</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $dataSchema->datas()->count() }} Datas
                    Available</span>
            </div>
            <div class="card-toolbar">

                <div class="my-1 my-lg-0">

                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        @foreach ($dataSchema->getListOfAttributes() as $attribute)
                            <th>{{ $attribute['name'] }}</th>
                        @endforeach
                        <th> Actions</th>
                    </tr>
                </thead>
                <tbody style="" class="datatable-body">
                    @foreach ($dataSchema->datas as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            @foreach (json_decode($item->values, true) as $key => $value)
                                <td>{{ $value }}</td>
                            @endforeach
                            <td><a href="#" class="btn btn-danger"><i class="fal fa-trash"></i> Delete</a></td>
                        </tr>
                    @endforeach

                    @if ($dataSchema->datas()->count() < 1)
                        <tr>
                            <td class="text-capitalize text-danger text-center font-size-h4"
                                colspan="{{ count($dataSchema->getListOfAttributes()) + 2 }}">No Record
                                Found</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>  --}}
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">{{ $dataSchema->name }}</h3>
            </div>

            <div class="card-toolbar">
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Action</button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose
                                an option:</li>

                            <li class="navi-item">
                                <a href="{{ route('data_schema.data.import.view', $dataSchema->id) }}" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-file-import"></i>
                                    </span>
                                    <span class="navi-text">Import Data</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" data-toggle="modal" data-target="#exportDataModal" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-file-export"></i>
                                    </span>
                                    <span class="navi-text">Export Data</span>
                                </a>
                            </li>

                            <li class="navi-item">
                                <a href="#" onclick="eraseData()" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="fal fa-trash text-danger"></i>
                                    </span>
                                    <span class="navi-text  text-danger">Erase Data</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{--  <div class="dropdown dropdown-inline">
                    <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Take Action</a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                        <ul class="navi navi-hover">



                        </ul>
                    </div>
                </div>  --}}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-checkable" id="datatable"
                style="margin-top: 13px !important">
                <thead>
                    <tr>
                        @foreach ($dataSchema->getListOfAttributes() as $attribute)
                            <td>
                                {{ $attribute['name'] }}
                            </td>
                        @endforeach
                        <td>Actions</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
