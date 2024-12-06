<div class="col-lg-12">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Annual Polio Virus Detection Trends by Line Chart</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-virus-detection-by-year-line-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getPolioVirusDetectionByYearLineChart = function() {
            $.ajax({
                url: '/polio-virus-detection-by-year-line-chart', // The route that returns the data
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    // Prepare the data for the chart
                    if (response && Array.isArray(response.categories) && Array.isArray(response.series)) {
                        // Prepare the chart options
                        var options = {
                            series: response.series, // Series data from the response
                            chart: {
                                type: 'line',
                                height: 350,
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            title: {
                                text: 'Polio Virus Detection by Year',
                                align: 'center',
                            },
                            xaxis: {
                                categories: response.categories, // X-axis categories (years)
                                title: {
                                    text: 'Year',
                                },
                            },
                            yaxis: {
                                title: {
                                    text: 'Number of Detected Polio Cases',
                                },
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: function(val) {
                                        return val + " cases";
                                    },
                                },
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'center',
                            },
                        };

                        // Render the chart
                        var chart = new ApexCharts(
                            document.querySelector("#polio-virus-detection-by-year-line-chart"),
                            options
                        );
                        chart.render();
                    } else {
                        // If data format is not expected, log the response for debugging
                        console.error("Unexpected response format. Check your backend:", response);
                        alert("The data could not be loaded due to an unexpected format.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching regional distribution data:", error);
                }
            });
        }

        $(function() {
            getPolioVirusDetectionByYearLineChart();
        })
    </script>
@endpush
