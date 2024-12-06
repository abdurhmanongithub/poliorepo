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

    #map {
        height: 500px;
        width: 100%;
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
                <div id="quarterDataChart" class="large-chart"></div>
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Timeliness of reporting and investigation</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="chart" class="large-chart">
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Distribution of Final Cell Culture Results</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="bar-chart" class="large-chart">
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b reduce-margin">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Data Disperse on Map</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="map" class="large-chart"></div>
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
{!! $chart->script() !!}
{{ $datasetByCategory->script() }}
{{-- {{ $exportTrendChart->script() }} --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    < script >
        $(document).ready(function() {
            $('#category-select').on('change', function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '/bar-category-data',
                        method: 'GET',
                        data: {
                            category_id: categoryId,
                            // _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.barChart) {
                                var chartConfig = response.barChart;
                                var chart = new ApexCharts(document.querySelector("#bar-chart"),
                                    chartConfig);
                                chart.render();
                                // console.log(response.chart);

                                // $('#chart').html(response.chart);
                            } else {
                                $('#bar-chart').html(
                                    '<p>No data available for this category.</p>');
                            }
                        },
                        error: function() {
                            $('#bar-chart').html('<p>Failed to load chart data.</p>');
                        }
                    });
                }
            });
        });
</script>
<script>
    $(document).ready(function() {
        $('#category-select').on('change', function() {
            var categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '/category-data',
                    method: 'GET',
                    data: {
                        category_id: categoryId,
                        // _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.chart) {
                            var chartConfig = response.chart;
                            var chart = new ApexCharts(document.querySelector("#chart"),
                                chartConfig);
                            chart.render();
                            // console.log(response.chart);

                            // $('#chart').html(response.chart);
                        } else {
                            $('#chart').html('<p>No data available for this category.</p>');
                        }
                    },
                    error: function() {
                        $('#chart').html('<p>Failed to load chart data.</p>');
                    }
                });
            }
        });
    });
</script>
<script>
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function clusterCoordinates(coords, radius = 10) {
        const clusters = [];
        const visited = new Array(coords.length).fill(false);

        for (let i = 0; i < coords.length; i++) {
            if (visited[i]) continue;
            const cluster = [];
            for (let j = 0; j < coords.length; j++) {
                if (!visited[j] && getDistance(coords[i].latitude, coords[i].longitude, coords[j].latitude, coords[j]
                        .longitude) <= radius) {
                    cluster.push(coords[j]);
                    visited[j] = true;
                }
            }
            clusters.push(cluster);
        }

        return clusters;
    }

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the Earth in kilometers
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
            0.5 - Math.cos(dLat) / 2 +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            (1 - Math.cos(dLon)) / 2;
        return R * 2 * Math.asin(Math.sqrt(a));
    }

    function initMap() {
        var ethiopia = {
            lat: 9.145,
            lng: 40.489673
        };
        var mapOptions = {
            zoom: 6,
            center: new google.maps.LatLng(9.145, 40.489673),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        $('#category-select').on('change', function() {
            var categoryId = this.value;
            if (categoryId) {
                fetch('/fetch-coordinates/' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing markers
                        map.markers.forEach(marker => marker.setMap(null));
                        map.markers = [];

                        // Process and add new markers
                        var markers = {};


                        data.forEach(item => {
                            if (item.position.latitude && item.position.longitude) {
                                var position = new google.maps.LatLng(item.position.latitude, item
                                    .position.longitude);
                                var key = `${item.position.latitude}-${item.position.longitude}`;
                                if (!markers[key]) {
                                    markers[key] = {
                                        count: 0,
                                        position: position
                                    };
                                }
                                markers[key].count++;
                            }
                        });

                        for (var key in markers) {
                            var marker = new google.maps.Marker({
                                position: markers[key].position,
                                map: map,
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    scale: 8,
                                    fillColor: getRandomColor(),
                                    fillOpacity: 1,
                                    strokeWeight: 1,
                                    strokeColor: '#000'
                                },
                                title: `Count: ${markers[key].count}` // Display count on hover
                            });
                            map.markers.push(marker);
                        }
                    });
            }
        });

        // Initialize map markers array
        map.markers = [];
    }
</script>
<script>
    let initialQuarterData = @json($initialDataPerSeasons['quarterData']);
    let quarterDataChart = new ApexCharts(document.querySelector("#quarterDataChart"), {
        chart: {
            type: 'pie',
            height: 500 // Set a height to ensure it displays
        },
        series: initialQuarterData, // initial quarter data
        labels: ['Fall', 'Summer', 'Spring', 'Winter'], // quarters
        colors: ['#00008B', '#FF0000', '#006400', '#FF8C00'] // adjust as necessary
    });

    quarterDataChart.render().then(() => {
        console.log('Quarter Data Chart rendered successfully'); // Confirm rendering
    }).catch((error) => {
        console.error('Error rendering quarter data chart:', error); // Log any errors
    });

    $('#category-select').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: '{{ route('
                getSeasonChartData ') }}',
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function(response) {
                    if (response.categoryData) {
                        quarterDataChart.updateOptions({
                            series: response.categoryData.series,
                            labels: response.categoryData.labels,
                            colors: response.categoryData.colors
                        }, true);

                        quarterDataChart.updateOptions({
                            series: response.categoryData.quarterData,
                            labels: ['Fall', 'Summer', 'Spring', 'Winter']
                        }, true);
                    } else {
                        console.error('Invalid response structure');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        var exportTrendChartOptions = {
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
        var exportTrendChart = new ApexCharts(document.querySelector("#exportTrendChart"),
            exportTrendChartOptions);
        exportTrendChart.render();

        $('#category-select').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{ route('
                    getSubCategoriesExportTrendData ') }}',
                    type: 'GET',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        if (response.categoryData && response.exportTrendData) {
                            exportTrendChart.updateOptions({
                                series: response.categoryData.series,
                                labels: response.categoryData.labels,
                                colors: response.categoryData.colors
                            }, true);

                            exportTrendChart.updateOptions({
                                series: response.exportTrendData.series,
                                xaxis: {
                                    categories: response.exportTrendData.xAxis
                                },
                                colors: response.exportTrendData.colors
                            }, true);
                        } else {
                            console.error('Invalid response structure');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        });
    });
</script>
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
                    url: '{{ route('
                    getSubCategoriesData ') }}',
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

{{-- <script>
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
    </script> --}}
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
