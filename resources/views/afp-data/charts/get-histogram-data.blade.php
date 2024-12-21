<div class="col-lg-12">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Stool Collection to Lab Receipt Time</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-lab" class="d-flex justify-content-center"></div>
        </div>
    </div>
</div>

{{-- <div class="col-lg-12">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Stool Collection to Result Time</h3>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-result" class="d-flex justify-content-center"></div>
        </div>
    </div>
</div> --}}

@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('afp.get.histogram.data') }}',
                method: 'GET',
                success: function(data) {
                    // Stool Collection to Lab Receipt Time
                    var optionsLab = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Days to Lab Receipt',
                            data: data.counts
                        }],
                        xaxis: {
                            categories: data.bins,
                            title: {
                                text: 'Days'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Frequency'
                            }
                        },
                        title: {
                            text: 'Stool Collection to Lab Receipt Time',
                            align: 'center'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%'
                            }
                        }
                    };
                    var chartLab = new ApexCharts(document.querySelector("#chart-lab"), optionsLab);
                    chartLab.render();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('afp.get.histogram.result.time') }}',
                method: 'GET',
                success: function(data) {
                    // Stool Collection to Result Time
                    var optionsResult = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Days to Results',
                            data: data.counts
                        }],
                        xaxis: {
                            categories: data.bins,
                            title: {
                                text: 'Days'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Frequency'
                            }
                        },
                        title: {
                            text: 'Stool Collection to Result Time',
                            align: 'center'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%'
                            }
                        }
                    };
                    var chartResult = new ApexCharts(document.querySelector("#chart-result"),
                        optionsResult);
                    chartResult.render();
                }
            });
        });
    </script>
@endpush
