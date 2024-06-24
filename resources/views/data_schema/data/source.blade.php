@extends('layouts.sublayout')
@section('title', 'Import Page')
@push('js')
    <script>
        function deleteSource(route) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteSourceForm').attr('action', route);
                    $('#deleteSourceForm').submit();
                }
            });
        }
    </script>
@endpush
@section('nav_content')
    <form action="" method="POST" id="deleteSourceForm">
        <input type="hidden" name="source" id="dataSourceValue">
        @csrf
    </form>
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
                @foreach ($dataSchema->dataSources as $dataSource)
                    <tr>
                        <td>Batch {{ $dataSource->import_batch }}</td>
                        <td>
                            <a href="#" onclick="deleteSource('{{ route('data_schema.source.delete', ['data_schema' => $dataSchema->id, 'dataSource' => $dataSource->id]) }}');" class="btn btn-danger btn-sm">
                                <i class="fal fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                @if ($dataSchema->dataSources()->count() == 0)
                    <td class="text-capitalize text-danger text-center font-size-h4" colspan="2">No Record
                        Found
                    </td>
                @endif
            </table>
        </div>
    </div>
@endsection
