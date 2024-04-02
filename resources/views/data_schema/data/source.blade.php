@extends('layouts.sublayout')
@section('title', 'Import Page')
@section('nav_content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Source Management</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">Make sure to sync from good source</span>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Import Batch</td>
                    <td>Action</td>
                </tr>
                @foreach ($dataSchema->datas()->distinct('import_batch')->pluck('import_batch') as $batch)
                    <tr>
                        <td>Batch {{ $batch }}</td>
                        <td>
                            <a href="" class="btn btn-danger btn-sm">
                                <i class="fal fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                @if ($dataSchema->datas()->distinct('import_batch')->count() == 0)
                    <td class="text-capitalize text-danger text-center font-size-h4" colspan="2">No Record
                        Found
                    </td>
                @endif
            </table>
        </div>
    </div>
@endsection
