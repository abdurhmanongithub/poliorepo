<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Yearly Trends in Polio Virus Detection (Up to 2022)</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-virus-detection-by-year-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
<script>
    var getPolioVirusDetectionByYear = function() {
        $.ajax({
            url: '/polio-virus-detection-by-year-chart', // The route that returns the data
            type: 'GET',
            success: function(response) {
                // Prepare the data for the chart
                if (response && response.categories && response.series) {
                    // Prepare the chart options
                    var options = {
                        series: response.series, // Series data from the response
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: response.categories, // X-axis categories (years)
                            title: {
                                text: 'Year'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Detected Polio Cases'
                            }
                        },
                        fill: {
                            opacity: 1
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
                    var chart = new ApexCharts(
                        document.querySelector("#polio-virus-detection-by-year-chart"),
                        options
                    );
                    chart.render();
                } else {
                    console.error("Invalid response format:", response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching regional distribution data:", error);
            }
        });
    }

    $(function() {
        getPolioVirusDetectionByYear();
    })
</script>
@endpush
