@extends('layouts/admin_main')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Status Pemilihan</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Status Pemilihan Kandidat
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Page level plugins -->
        <script src="{{ asset('/') }}assets/vendor/sb-admin/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            var namaCalon = []
            var hasilVote = []
            $(function() {
                setInterval(function() {
                    updateChart()
                }, 1000)
            })

            function updateChart() {
                $.get("{{ route('get_data_pemilihan') }}", function(data) {
                    namaCalon = []
                    hasilVote = []
                    data.forEach(d => {
                        namaCalon.push(Object.keys(d)[0])
                        hasilVote.push(Object.values(d)[0])
                    });
                    // Set new default font family and font color to mimic Bootstrap's default styling
                    Chart.defaults.global.defaultFontFamily = 'Nunito',
                        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                    Chart.defaults.global.defaultFontColor = '#858796';

                    function number_format(number, decimals, dec_point, thousands_sep) {
                        // *     example: number_format(1234.56, 2, ',', ' ');
                        // *     return: '1 234,56'
                        number = (number + '').replace(',', '').replace(' ', '');
                        var n = !isFinite(+number) ? 0 : +number,
                            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                            s = '',
                            toFixedFix = function(n, prec) {
                                var k = Math.pow(10, prec);
                                return '' + Math.round(n * k) / k;
                            };
                        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                        if (s[0].length > 3) {
                            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                        }
                        if ((s[1] || '').length < prec) {
                            s[1] = s[1] || '';
                            s[1] += new Array(prec - s[1].length + 1).join('0');
                        }
                        return s.join(dec);
                    }

                    // Bar Chart Example
                    var ctx = document.getElementById("myBarChart");
                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: namaCalon,
                            datasets: [{
                                label: "Jumlah Vote",
                                backgroundColor: "#4e73df",
                                hoverBackgroundColor: "#2e59d9",
                                borderColor: "#4e73df",
                                data: hasilVote,
                                maxBarThickness: 25,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'month'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 6
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                        max: Math.max(...hasilVote) < 5 ? 5 : Math.max(...
                                            hasilVote),
                                        maxTicksLimit: 10,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex]
                                            .label || '';
                                        return datasetLabel + ': ' + number_format(tooltipItem
                                            .yLabel);
                                    }
                                }
                            },
                            animation: {
                                duration: 0
                            }
                        }
                    });
                })
            }
        </script>
    @endpush
@endsection
