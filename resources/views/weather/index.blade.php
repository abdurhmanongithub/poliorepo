@extends('base')
@section('title', 'Historical weather Datas')
@push('js')

@endpush
@section('content')
<div class="card card-custom">
    @if ($errors->any())
    <div class="alert alert-danger">
        <p><strong>Oops Something went wrong</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">
                <span>Total: {{ $items->total() }}</span>
                Historical Weather Datas

                <span class="d-block text-muted pt-2 font-size-sm">All Historical Weather Datas</span>

                <div class="">
                </div>
            </h3>
        </div>
        <div class="card-tools">
            <a class="btn btn-outline-info" href="#" data-toggle="modal" data-target="#modal-import">
                <i class="fas fa-file-import"></i> Import
            </a>
            <a class="btn btn-outline-info" href="#" data-toggle="modal" data-target="#modal-import">
                <i class="fas fa-download"></i> Download Template
            </a>
        </div>
    </div>
    <thead>
        <p class="text-center"><strong>Filter</strong></p>

        <th>
            <tr>

                <form action="{{ route('weather.index') }}">

                    <div class="row">
                        <td>
                            <div class="form-group col-md-4 mx-2">
                                <label class="col-sm-5 control-label no-padding-right">Location </label>
                                <input type="text" class="form-control" name="location">
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-2">
                                <label class="col-sm-5 control-label no-padding-right">Year </label>
                                <select name="year" id="" class="form-control select2">
                                    <option value="" selected disabled>select option</option>
                                    @for ($i =now()->format('Y'); $i >=1981 ; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-2">
                                <label class="col-sm-5 control-label no-padding-right">Month </label>
                                <select name="month" id="" class="form-control select2">
                                    <option value="" selected disabled>select option</option>
                                    @for ($i =1; $i <=12 ; $i++) <option value="{{$i}}">{{$i}}</option>

                                        @endfor
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-2">
                                <label class="col-sm-5 control-label no-padding-right">date </label>

                                <select name="month" id="" class="form-control select2">
                                    <option value="" selected disabled>select option</option>
                                    @for ($i =1; $i <=30 ; $i++) <option>{{$i}}</option>
                                        @endfor
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-2 mx-2">
                                <button class=" btn btn-outline-primary" type="submit" name="type" value="filter"><i class="fa fa-search"></i></button>
                            </div>
                        </td>
                    </div>

                </form>


            </tr>
        </th>
    </thead>
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="table table-bordered table-responsive">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Location</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Day</th>
                        <th title="MERRA-2 Temperature at 2 Meters (C)">t2m</th>
                        <th title="MERRA-2 Dew/Frost Point at 2 Meters (C)">t2mdew</th>
                        <th title="MERRA-2 Wet Bulb Temperature at 2 Meters (C)">t2mwet</th>
                        <th title="MERRA-2 Earth Skin Temperature (C)">ts</th>
                        <th title="MERRA-2 Temperature at 2 Meters Range (C)">t2m_range</th>
                        <th title="MERRA-2 Temperature at 2 Meters Maximum (C)">t2m_max</th>
                        <th title="MERRA-2 Temperature at 2 Meters Minimum (C)">t2m_min</th>
                        <th title="MERRA-2 Specific Humidity at 2 Meters (g/kg)">qv2m</th>
                        <th title="MERRA-2 Relative Humidity at 2 Meters (%)">rh2m</th>
                        <th title="MERRA-2 Precipitation Corrected (mm/day)">prectotcorr</th>

                    </tr>
                </thead>
                <tbody class="datatable-body">

                    @foreach ($items as $key=>$data)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $data->location }}</td>
                        <td>{{ $data->year }}</td>

                        <td>{{ $data->mo }}</td>
                        <td>{{ $data->dy }}</td>
                        <td>{{ $data->t2m }}</td>
                        <td>{{ $data->t2mdew }}</td>
                        <td>{{ $data->t2mwet }}</td>
                        <td>{{ $data->ts }}</td>
                        <td>{{ $data->t2m_range }}</td>
                        <td>{{ $data->t2m_max }}</td>
                        <td>{{ $data->t2m_min }}</td>
                        <td>{{ $data->qv2m }}</td>
                        <td>{{ $data->rh2m }}</td>
                        <td>{{ $data->prectotcorr }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            {{$items->withQueryString()}}
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
<div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('weather.import') }}" id="file-upload" enctype="multipart/form-data">

            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import The Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-sm-5 control-label no-padding-right">Select File: </label>
                            <input type="file" class="form-control" name="file" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-sm-5 control-label no-padding-right">Location </label>
                            <input type="text" class="form-control" name="location" required>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
