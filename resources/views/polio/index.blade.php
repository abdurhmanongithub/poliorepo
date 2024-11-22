@extends('base')
@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Polio Data available tables </h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">{{ count($tablesWithRowCount) }}</span>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="table-responsive">

                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Rows</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tablesWithRowCount as $table)
                                <tr>
                                    <td>
                                        {{ $table['table_name'] }}
                                    </td>

                                    <td>
                                        {{ $table['row_count'] }}
                                    </td>

                                    <td>
                                        <a href="{{ route('polio-table.show',['table'=>$table['table_name']]) }}" class="btn btn-primary btn-sm">View Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
