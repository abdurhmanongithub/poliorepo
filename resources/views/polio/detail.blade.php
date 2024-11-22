@extends('base')
@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Polio Data for </h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $table }}</span>
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
                                @foreach ($columns as $column)
                                    <th scope="col" style="background-color: #0067b8;color:#ffffff;">{{ $column }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach ($row as $item)
                                        <td>{{ $item }}</td>
                                    @endforeach
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
