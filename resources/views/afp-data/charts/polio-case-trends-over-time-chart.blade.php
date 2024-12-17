<div class="col-lg-12">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Polio Case Trends Over Time: Monthly and Yearly Analysis</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-trend-line-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getPolioCaseTrendsOverTime = function() {
            $.ajax({
                url: '/polio-case-trends', // The route that returns the season data
                type: 'GET',
                success: function(response) {
                    // Ensure the response format is correct
                    if (response) {
                        var options = {
                            chart: {
                                height: 350,
                                type: 'line',
                            },
                            series: response.series, // Data series
                            xaxis: {
                                categories: response.categories, // X-axis labels (Year-Month)
                                title: {
                                    text: 'Year-Month'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Number of Cases'
                                }
                            },
                            title: {
                                text: 'Polio Case Trends Over Time',
                                align: 'center'
                            },
                            stroke: {
                                curve: 'smooth'
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#polio-case-trends-chart"),
                            options);
                        chart.render(); // Render the chart
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
            getPolioCaseTrendsOverTime();
        })
    </script>
@endpush
