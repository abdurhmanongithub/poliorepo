<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Correlation of GPS Latitude and Longitude for Clusters</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="chart-id" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/core-gps-data-chart',
                method: 'GET',
                success: function(data) {
                    let latitude = [];
                    let longitude = [];
                    data.forEach(function(item) {
                        latitude.push(item.gps_latitude);
                        longitude.push(item.gps_longitude);
                    });

                    var options = {
                        chart: {
                            height: 350,
                            type: 'scatter',
                        },
                        series: [{
                            name: 'GPS Data',
                            data: latitude.map((lat, index) => [lat, longitude[index]]),
                        }],
                        xaxis: {
                            title: {
                                text: 'Latitude'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Longitude'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-id"), options);
                    chart.render();
                }
            });
        });
    </script>
@endpush
