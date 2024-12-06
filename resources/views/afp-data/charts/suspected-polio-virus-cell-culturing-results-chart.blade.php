<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Suspected Polio Virus: Distribution of Cell Culturing Results</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="suspected-polio-virus-cell-culturing-results-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getSuspectedPolioVirusResults = function() {
            $.ajax({
                url: '/suspected-polio-virus-cell-culturing-results-chart', // The route that returns the season data
                type: 'GET',
                success: function(response) {
                    // Ensure the response format is correct
                    if (response && response.maleData && response.femaleData) {
                        // Prepare the chart options
                        var options = {
                            series: [{
                                    name: 'Male',
                                    data: response.maleData, // Male data for each result category
                                },
                                {
                                    name: 'Female',
                                    data: response
                                        .femaleData, // Female data for each result category
                                }
                            ],
                            chart: {
                                type: 'bar',
                                height: 350,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '50%',
                                    endingShape: 'rounded',
                                },
                            },
                            xaxis: {
                                categories: response
                                    .labels, // Categories: "Missing", "Negative", "WPV-polio"
                            },
                            title: {
                                text: 'Suspected Polio Virus (Cell Culturing Result)',
                                align: 'center'
                            },
                            yaxis: {
                                title: {
                                    text: 'Number of Cases'
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " cases";
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'center',
                                floating: true,
                            }
                        };

                        // Render the bar chart
                        var chart = new ApexCharts(
                            document.querySelector(
                                "#suspected-polio-virus-cell-culturing-results-chart"),
                            options
                        );
                        chart.render();
                    } else {
                        console.error("Unexpected response format. Check your backend:", response);
                        alert("The data could not be loaded due to an unexpected format.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching polio emerging seasons data:", error);
                    alert("Failed to load data. Please try again later.");
                }
            });
        }

        $(function() {
            getSuspectedPolioVirusResults();
        })
    </script>
@endpush
