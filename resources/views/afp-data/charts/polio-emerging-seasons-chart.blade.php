<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Top Seasons for Polio Outbreaks</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-emerging-seasons-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getTopPolioEmergingSeasons = function() {
            $.ajax({
                url: '/polio-emerging-seasons-chart', // The route that returns the season data
                type: 'GET',
                success: function(response) {
                    // Ensure the response format is correct
                    if (response && Array.isArray(response.series) && Array.isArray(response.labels)) {
                        // Prepare the chart options
                        var options = {
                            series: response.series, // Series data (counts)
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            labels: response.labels, // Labels (seasons)
                            title: {
                                text: 'Top Seasons for Polio Outbreaks',
                                align: 'center'
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " cases";
                                    }
                                }
                            }
                        };

                        // Render the pie chart
                        var chart = new ApexCharts(
                            document.querySelector("#polio-emerging-seasons-chart"),
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
            getTopPolioEmergingSeasons();
        })
    </script>
@endpush
