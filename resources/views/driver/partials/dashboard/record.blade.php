<div class="col-xl-5">
    <div class="row g-5">
        <div class="col-xl-12 col-sm-12 col-lg-12">
            <a class="card user-card card-hover-shadow h-100" href="#" id="transactionRecord">
                <div class="card-body">
                    <div class="card-title-top">
                        <i class="fa-light fa-credit-card"></i>
                        <h6 class="card-subtitle">@lang('This Month Transactions')</h6>
                    </div>
                    <div class="row align-items-center gx-2 mb-1">
                        <div class="col-6">
                            <h2 class="card-title text-inherit transactionRecord-totalTransaction"></h2>
                        </div>
                        <div class="col-6">
                            <div class="chartjs-custom recordChart">
                                <canvas class="" id="chartTransactionRecordsGraph">
                                </canvas>
                            </div>
                        </div>
                    </div>
                    <span class="badge transactionRecord-followupGrapClass">
                        <i class="bi-graph-up"></i> <span class="transactionRecord-followupGrap"></span>%
                    </span>
                    <span class="text-body fs-6 ms-1 transactionRecord-chartPercentageIncDec"></span>
                </div>
            </a>
        </div>
    </div>
</div>

@push('script')
    <script>
        Notiflix.Block.standard('#transactionRecord');
        HSCore.components.HSChartJS.init(document.querySelector('#chartTransactionRecordsGraph'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                    borderColor: "#377dff",
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: false
                },
                plugins: {
                    tooltip: {
                        postfix: "",
                        hasIndicator: true,
                        intersect: false
                    }
                }
            },
        });
        const chartTransactionRecordsGraph = HSCore.components.HSChartJS.getItem('chartTransactionRecordsGraph');

        updateChartTransactionRecordsGraph();

        async function updateChartTransactionRecordsGraph() {
            let $url = "{{ route('driver.chartTransactionRecords') }}"
            await axios.get($url)
                .then(function(res) {
                    $('.transactionRecord-totalTransaction').text(res.data.transactionRecord.totalTransaction);
                    $('.transactionRecord-followupGrapClass').addClass(res.data.transactionRecord
                    .followupGrapClass);
                    $('.transactionRecord-followupGrap').text(res.data.transactionRecord.followupGrap);
                    $('.transactionRecord-chartPercentageIncDec').text(
                        `from ${res.data.transactionRecord.chartPercentageIncDec}`);

                    chartTransactionRecordsGraph.data.labels = res.data.current_month_data_dates
                    chartTransactionRecordsGraph.data.datasets[0].data = res.data.current_month_datas
                    chartTransactionRecordsGraph.update();
                    Notiflix.Block.remove('#transactionRecord');
                })
                .catch(function(error) {

                });
        }
    </script>
@endpush
