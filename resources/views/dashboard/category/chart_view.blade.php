<div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Data Bar</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="category_chart_view_canva" class="d-flex justify-content-center"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Data Chart</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="category_pie_chart_canva" class="d-flex justify-content-center"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>

@push('js')
    <script>
        function getDataStat() {
            var categoryStats = @json($categoryStats);
            var dataPerCategory = [];
            categoryStats.forEach(value => {
                dataPerCategory.push(value['data_count']);
            });
            return dataPerCategory;
        }
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';
        var chart = function() {
            // Private functions
            var _categoryChartView = function() {
                const apexChart = "#category_chart_view_canva";
                var options = {
                    series: [{
                        name: 'Total Data',
                        data: getDataStat()
                    }, ],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
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
                        categories: @json($categories->pluck('name')),
                    },
                    yaxis: {
                        title: {
                            text: 'Data'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "$ " + val + " data"
                            }
                        }
                    },
                    colors: [primary, success, warning]
                };
                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _categoryPieView = function() {
                const apexChart = "#category_pie_chart_canva";
                var options = {
                    series: getDataStat(),
                    chart: {
                        width: 380,
                        type: 'donut',
                    },
                    labels: @json($categories->pluck('name')),

                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    colors: [primary, success, warning, danger, info]
                };
                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            return {
                init: function() {
                    _categoryPieView();
                    _categoryChartView();
                }
            };
        }();
        jQuery(document).ready(function() {
            chart.init();
        });
    </script>
@endpush
