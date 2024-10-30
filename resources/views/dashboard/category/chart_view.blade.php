@push('css')
    <style>
        .reduce-margin {
            margin-bottom: 10px;
            /* Adjust this value as needed */
        }

        .large-chart {
            width: 100%;
            /* Adjust as needed */
            height: auto;
            /* Adjust as needed */
        }
    </style>
@endpush
<div class="row">
    <div class="col-lg-12">
        <select id="category-select" class="form-control select2" style="width: 100%;">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datasets by Category</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="large-chart">
                    {!! $datasetByCategory->container() !!}
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Dataset by Category &amp; Date</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div class="large-chart">
                    <div id="exportTrendChart" class="large-chart"></div>
                    {{-- {!! $exportTrendChart->container() !!} --}}
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Dataset by Sub-Category</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div class="large-chart">
                    <div id="agriculturalInputChart" class="large-chart"></div>
                    {{-- {!! $agriculturalInputChart->container() !!} --}}
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Dataset by Data Type</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="livestockMarketChart" class="large-chart"></div>
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/some-other-library@3.35.3/dist/library.min.js"></script>

    {{-- <script src="{{ $datasetByCategory->cdn() }}"></script>
    <script src="{{ $agriculturalInputChart->cdn() }}"></script> --}}
    {{-- <script src="{{ $exportTrendChart->cdn() }}"></script> --}}
    {{ $agriculturalInputChart->script() }}
    {{ $datasetByCategory->script() }}
    {{-- {{ $exportTrendChart->script() }} --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

    <script>
        $(document).ready(function() {
            $('#category-select').select2();

            let initialSeries = @json($initialData['series']);
            let initialLabels = @json($initialData['labels']);
            let initialColors = @json($initialData['colors']);

            let agriculturalInputChart = new ApexCharts(document.querySelector("#agriculturalInputChart"), {
                chart: {
                    type: 'pie',
                    height: 500 // Set a height to ensure it displays
                },
                series: initialSeries, // initial data
                labels: initialLabels, // initial labels
                colors: initialColors // initial colors
            });

            agriculturalInputChart.render().then(() => {
                console.log('Chart rendered successfully'); // Confirm rendering
            }).catch((error) => {
                console.error('Error rendering chart:', error); // Log any errors
            });

            $('#category-select').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('getSubCategoriesData') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(response) {
                            if (response.series && response.labels) {
                                agriculturalInputChart.updateOptions({
                                    series: response.series,
                                    labels: response.labels,
                                    colors: response.colors // Update colors if needed
                                }, true);
                            } else {
                                console.error('Invalid response structure');
                            }
                        }
                    });
                }
            });
        });
    </script>

    <script>
        var options = {
            series: @json($exportTrendData['series']),
            chart: {
                type: 'bar',
                height: 350,
                stacked: true
            },
            colors: @json($exportTrendData['colors']),
            xaxis: {
                categories: @json($exportTrendData['xAxis'])
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#exportTrendChart"), options);
        chart.render();
    </script>
    <script>
        var options = {
            series: [{
                name: 'Domestic Market',
                type: 'column',
                data: @json($livestockMarketData['domestic'])
            }, {
                name: 'Exported',
                type: 'line',
                data: @json($livestockMarketData['exported'])
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false
            },
            stroke: {
                width: [0, 2],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            colors: ['#004c6d', '#b6fb80'],
            xaxis: {
                categories: @json($livestockMarketData['xAxis'])
            },
            yaxis: [{
                title: {
                    text: 'Domestic Market'
                },
            }, {
                opposite: true,
                title: {
                    text: 'Exported'
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#livestockMarketChart"), options);
        chart.render();
    </script>
@endpush
