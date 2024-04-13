@extends('layouts.sublayout')
@section('title', 'Create a new data schema')
@push('js')
    <script src="{{ asset('assets/js/pages/features/charts/apexcharts.min.js') }}"></script>
@endpush
@section('nav_content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header h-auto">
                        <div class="card-title py-5">
                            <h3 class="card-label">Line Chart</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-primary">Choose</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart_1"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Area Chart</h3>
                        </div>

                        <div class="card-toolbar">
                            <a href="#" class="btn btn-primary">Choose</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart_2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
