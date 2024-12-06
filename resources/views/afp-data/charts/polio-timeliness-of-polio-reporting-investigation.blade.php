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
<script>
    $(document).ready(function() {
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
</script>
