<div class="col-lg-6">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Trend of Cases Over Time</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-trend" class="d-flex justify-content-center"></div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('afp.get.case.trends') }}',
                method: 'GET',
                success: function(data) {
                    let months = [];
                    let counts = [];
                    data.forEach(function(item) {
                        months.push(item.month_name); // Use month_name instead of month
                        counts.push(item.case_count);
                    });

                    var options = {
                        chart: {
                            type: 'line',
                            height: 350
                        },
                        series: [{
                            name: 'Cases',
                            data: counts
                        }],
                        xaxis: {
                            categories: months, // Use month names as categories
                            title: {
                                text: 'Month'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Cases'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-trend"), options);
                    chart.render();
                }
            });
        });
    </script>
@endpush
