<div class="col-lg-6">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Age Group Distribution of Cases</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-age-group" class="d-flex justify-content-center"></div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('afp.get.age.group.distribution') }}',
                method: 'GET',
                success: function(data) {
                    let ageGroups = [];
                    let counts = [];
                    data.forEach(function(item) {
                        ageGroups.push(item.age_group);
                        counts.push(item.case_count);
                    });

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Cases',
                            data: counts
                        }],
                        xaxis: {
                            categories: ageGroups,
                            title: {
                                text: 'Age Group'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Cases'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-age-group"), options);
                    chart.render();
                }
            });
        });
    </script>
@endpush
