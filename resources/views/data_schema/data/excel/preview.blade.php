@extends('layouts.sublayout')

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
                <form action="{{ route('data_schema.data.sync.excel', ['data_schema' => $dataSchema->id]) }}" id="importForm"
                    method="POST">

                    <a href="#" class="btn btn-light-primary font-weight-bolder mr-2">
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
        <div class="card-body">
            @if ($excelData)
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                    <thead>
                        <tr>
                            @foreach ($excelData[0][0] as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($excelData[0]->slice(1, 10) as $row)
                            <tr>
                                @foreach ($row as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
