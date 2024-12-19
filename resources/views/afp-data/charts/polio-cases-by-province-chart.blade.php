<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Polio Case Distribution by Region: A Geographical Overview</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-cases-by-province-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getPolioCasesByProvince = function() {
            $.ajax({
                url: '/polio-cases-by-province', // The route that returns the season data
                type: 'GET',
                success: function(response) {
                    // Ensure the response format is correct
                    if (response) {
                        // Prepare the chart options
                        var options = {
                            series: [{
                                name: 'Polio Cases Detected',
                                data: response.series[0].data // Data for each province
                            }],
                            chart: {
                                type: 'bar', // Bar chart type
                                height: 350
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: true, // Horizontal bars for easier readability
                                    dataLabels: {
                                        position: 'top',
                                    },
                                },
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val) {
                                    return val + " cases";
                                }
                            },
                            xaxis: {
                                categories: response.categories, // Province names
                                title: {
                                    text: 'Number of Cases'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Provinces'
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " cases";
                                    }
                                }
                            }
                        };

                        // Render the chart
                        var chart = new ApexCharts(document.querySelector("#polio-cases-by-province-chart"),
                            options);
                        chart.render();
                    } else {
                        console.error("Unexpected response format. Check your backend:", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching polio emerging seasons data:", error);
                }
            });
        }

        $(function() {
            getPolioCasesByProvince();
        })
    </script>
@endpush
