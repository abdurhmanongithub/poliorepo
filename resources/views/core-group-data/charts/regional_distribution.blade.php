<div class="col-lg-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Regional Data Distribution: Proportions by Area</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="regional-distribution-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('js')
    <script>
        var regionalDistributionChart = function() {
            $.ajax({
                url: '/regional-distribution', // The route that returns the data
                type: 'GET',
                success: function(data) {
                    // Prepare the data for the chart
                    var regionLabels = data.map(function(item) {
                        return item.region; // Region name (e.g., Somali, Oromia)
                    });
                    var regionCounts = data.map(function(item) {
                        return item.count; // Count of non-null entries
                    });

                    // Initialize the chart
                    var options = {
                        series: regionCounts,
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        labels: regionLabels,
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }],
                    };

                    var chart = new ApexCharts(document.querySelector("#regional-distribution-chart"),
                        options);
                    chart.render();
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching regional distribution data:", error);
                }
            });
            //     const apexChart = "#regional-distribution-chart";
            //     var options = {
            //         series: [44, 55, 13, 43, 22],
            //         chart: {
            //             width: 380,
            //             type: 'pie',
            //         },
            //         labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            //         responsive: [{
            //             breakpoint: 480,
            //             options: {
            //                 chart: {
            //                     width: 200
            //                 },
            //                 legend: {
            //                     position: 'bottom'
            //                 }
            //             }
            //         }],
            //     };

            //     var chart = new ApexCharts(document.querySelector(apexChart), options);
            //     chart.render();
        }

        $(function() {
            regionalDistributionChart();
        })
    </script>
@endpush
