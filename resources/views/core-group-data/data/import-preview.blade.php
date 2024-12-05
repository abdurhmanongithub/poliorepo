@extends('core-group-data.sublayout')

@section('nav_content')
    <div class="card card-custom card-sticky" id="kt_page_sticky_card">
        <div class="card-header" style="">
            <div class="card-title">
                <h3 class="card-label">Excel Preview
                    <i class="mr-2"></i>
                    <small class="">make sure the data is correct</small>
                </h3>
            </div>
            <div class="card-toolbar">
                <form action="{{ route('core-group-data.import', []) }}" id="importForm"
                    method="POST">
                    <a href="{{ route('core-group-data.import.view', []) }}" class="btn btn-light-primary font-weight-bolder mr-2">
                        <i class="ki ki-long-arrow-back icon-xs"></i>Back</a>
                    <input type="hidden" name="file_path" value="{{ $filePath }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault();$('#importForm').submit()"
                        class="btn btn-light-primary font-weight-bolder mr-2">
                        <i class="fal fa-file-import icon-xs"></i>Continue Import
                    </a>
                </form>

            </div>
        </div>
        <div class="card-body table-responsive">
            @if ($excelData)
                <table class="table table-sm table-bordered table-hover table-checkable" id="kt_datatable">
                    <thead>
                        <tr>
                            @foreach ($keys as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($excelData[0] as $row)
                            <tr>
                                @foreach ($keys as $key)
                                    <td>{{ array_key_exists($key,$row) ? $row[$key] : '' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
