<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Polio Virus Reporting by Gender: Case Proportions</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="polio-virus-distribution-by-gender-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var getPolioVirusDistributionByGender = function() {
            $.ajax({
                url: '/polio-virus-distribution-by-gender-chart', // The route that returns the season data
                type: 'GET',
                success: function(response) {
                    // Ensure the response format is correct
                    if (response && Array.isArray(response.series) && Array.isArray(response.labels)) {
                        // Prepare the chart options
                        const series = response.series.map(Number);
                        var options = {
                            series: series, // Data for the number of cases per gender
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            labels: response.labels, // Gender labels
                            title: {
                                text: 'Polio Virus Distribution by Gender',
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
                            document.querySelector("#polio-virus-distribution-by-gender-chart"),
                            options
                        );
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
            getPolioVirusDistributionByGender();
        })
    </script>
@endpush
