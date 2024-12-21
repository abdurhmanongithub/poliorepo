<div class="col-lg-6">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Case or Contact Counts by Province/District</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-bar" class="d-flex justify-content-center"></div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('core.get.case.counts') }}',
                method: 'GET',
                success: function(data) {
                    let regions = [];
                    let counts = [];
                    data.forEach(function(item) {
                        regions.push(item.area_name_region);
                        counts.push(item.case_count);
                    });

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Case Counts',
                            data: counts
                        }],
                        xaxis: {
                            categories: regions,
                            title: {
                                text: 'Region'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Case Counts'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-bar"), options);
                    chart.render();
                }
            });
        });
    </script>
@endpush
