@extends('layouts.sublayout')
@section('nav_content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Data Management</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">{{ $dataSchema->datas()->count() }} Datas
                    Available</span>
            </div>
            <div class="card-toolbar">

                <div class="my-1 my-lg-0">
                    <div class="dropdown dropdown-inline">
                        <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Take Action</a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                            <ul class="navi navi-hover">

                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-shopping-cart-1"></i>
                                        </span>
                                        <span class="navi-text">Import Data</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-shopping-cart-1"></i>
                                        </span>
                                        <span class="navi-text">Export Data</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
    </div>
@endsection
