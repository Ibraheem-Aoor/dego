<div class="col-xl-5">
    <div class="row g-5">
        <!-- Transaction Record Card -->
        <div class="col-xl-12 col-sm-12 col-lg-12">
            <a class="card user-card card-hover-shadow h-100" href="#" id="transactionRecord">
                <div class="card-body">
                    <div class="card-title-top">
                        <i class="fa-light fa-credit-card"></i>
                        <h6 class="card-subtitle">@lang('This Month Transactions')</h6>
                    </div>
                    <div class="row align-items-center gx-2 mb-1">
                        <div class="col-6">
                            <h2 class="card-title text-inherit transaction-total"></h2>
                        </div>
                        <div class="col-6">
                            <div class="chartjs-custom">
                                <canvas id="chartTransactionGraph"></canvas>
                            </div>
                        </div>
                    </div>
                    <span class="badge transaction-followup-class">
                        <i class="bi-graph-up"></i> <span class="transaction-followup"></span>%
                    </span>
                    <span class="text-body fs-6 ms-1 transaction-percentage-change"></span>
                </div>
            </a>
        </div>

        <!-- Company Record Card -->
        <div class="col-xl-12 col-sm-12 col-lg-12">
            <a class="card user-card card-hover-shadow h-100" href="#" id="companyRecord">
                <div class="card-body">
                    <div class="card-title-top">
                        <i class="fa-light fa-credit-card"></i>
                        <h6 class="card-subtitle">@lang('This Month Companies')</h6>
                    </div>
                    <div class="row align-items-center gx-2 mb-1">
                        <div class="col-6">
                            <h2 class="card-title text-inherit company-total"></h2>
                        </div>
                        <div class="col-6">
                            <div class="chartjs-custom">
                                <canvas id="chartCompanyGraph"></canvas>
                            </div>
                        </div>
                    </div>
                    <span class="badge company-followup-class">
                        <i class="bi-graph-up"></i> <span class="company-followup"></span>%
                    </span>
                    <span class="text-body fs-6 ms-1 company-percentage-change"></span>
                </div>
            </a>
        </div>
    </div>
</div>

@push('script')
<script>
    // Initialize charts and fetch data for Transaction and Company Records
    initChart('#transactionRecord', 'chartTransactionGraph', "{{ route('agent.chartTransactionRecords') }}", 'transaction');
    initChart('#companyRecord', 'chartCompanyGraph', "{{ route('agent.chartCompanyRecords') }}", 'company');

    function initChart(container, chartId, url, prefix) {
        Notiflix.Block.standard(container);

        const chart = HSCore.components.HSChartJS.init(document.querySelector(`#${chartId}`), {
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
                    y: { display: false },
                    x: { display: false }
                },
                hover: { mode: "nearest", intersect: false },
                plugins: {
                    tooltip: {
                        postfix: "",
                        hasIndicator: true,
                        intersect: false
                    }
                }
            }
        });

        updateChartData(chart, url, prefix, container);
    }

    async function updateChartData(chart, url, prefix, container) {
        try {
            const response = await axios.get(url);
            const data = response.data[`${prefix}Record`];

            $(`.${prefix}-total`).text(data.totalTransaction);
            $(`.${prefix}-followup-class`).addClass(data.followupGrapClass);
            $(`.${prefix}-followup`).text(data.followupGrap);
            $(`.${prefix}-percentage-change`).text(`from ${data.chartPercentageIncDec}`);

            chart.data.labels = response.data.current_month_data_dates;
            chart.data.datasets[0].data = response.data.current_month_datas;
            chart.update();
        } catch (error) {
            console.error("Error updating chart:", error);
        } finally {
            Notiflix.Block.remove(container);
        }
    }
</script>
@endpush
