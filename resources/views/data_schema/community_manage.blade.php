@extends('layouts.sublayout')
@section('nav_content')
<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Community Members</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $dataSchema->name }}</span>
        </div>
        <div class="card-toolbar">
            {{-- <button type="reset" class="btn btn-success mr-2">Export Report</button>  --}}
        </div>
    </div>
    <div class="card-body">
        <div class="card-body">
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>Woreda</th>
                            <th>Gender</th>
                            <th>Phone</th>

                            <th> Actions</th>
                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">
                        @foreach ($dataSchema->subCategory->communities as $key => $comm)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $comm?->full_name }}</td>
                            <td>{{ $comm->woreda?->name }}</td>
                            <td>{{ $comm->gender }}</td>
                            <td>{{ $comm->phone }}</td>
                            <td><span class="badge badge-info badge-sm">{{$comm->communityType->name}}</span>
                            </td>
                        </tr>
                        @endforeach
                        @if (count($dataSchema->subCategory->communities) < 1) <tr>

                            <td class="text-capitalize text-danger text-center font-size-h4" colspan="5">No Record
                                Found</td>
                            </tr>
                            @endif
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
@endsection
