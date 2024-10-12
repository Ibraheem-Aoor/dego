<div class="col-lg-12">
    <div class="card-body">
        <h4>@lang('Popular Package By Visitor')</h4>

        <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
            <div class="col-sm mb-3 mb-sm-0">
                <span class="display-5 text-dark me-2">{{ $totalVisitor }}</span>
            </div>
            <div class="col-sm-auto">
                @if($growthVisitor < 0)
                    <span class="h3 text-danger">
                        <i class='bi-graph-down'></i> {{ number_format($growthVisitor, 2) . '%' }}
                    </span>
                @else
                    <span class="h3 text-success">
                        <i class="bi-graph-up"></i> {{ number_format($growthVisitor, 2) . '%' }}
                    </span>
                @endif

                <span class="d-block">{{ $uniqueVisitor .' unique'}}  <span
                            class="badge bg-soft-dark text-dark rounded-pill ms-1">{{'+new ' .$VisitorToday }}</span>
              </span>
            </div>
        </div>

        <div id="VisitorCard">
            <canvas id="PackagesVisitors"></canvas>
        </div>
        <div class="row justify-content-center pt-3">
            <div class="col-auto">
                <span class="legend-indicator bg-primary"></span> @lang('Visited')
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        Notiflix.Block.standard('#VisitorCard')
        const packagesVisitorsHistory = new Chart("PackagesVisitors", {
            "type": "line",
            "data": {
                "labels": [],
                "datasets": [{
                    "data": [],
                    label: "Visited",
                    "backgroundColor": "transparent",
                    "borderColor": "#377dff",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "hoverBorderColor": "#377dff",
                    "pointBackgroundColor": "#377dff",
                    "pointBorderColor": "#fff",
                    "pointHoverRadius": 0,
                    "tension": 0.4
                }]
            },
            "options": {
                "scales": {
                    "y": {
                        "grid": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                        },
                        "ticks": {
                            "beginAtZero": true,
                            "stepSize": 1000,
                            "color": "#97a4af",
                            "font": {
                                "size": 12,
                                "family": "Open Sans, sans-serif"
                            },
                            "padding": 10,
                            "postfix": "k"
                        }
                    },
                    "x": {
                        "grid": {
                            "display": false,
                            "drawBorder": false
                        },
                        "ticks": {
                            "color": "#97a4af",
                            "font": {
                                "size": 12,
                                "family": "Open Sans, sans-serif"
                            },
                            "padding": 5
                        }
                    }
                },
                "plugins": {
                    "tooltip": {
                        "postfix": "k",
                        "hasIndicator": true,
                        "mode": "index",
                        "intersect": false,
                        "lineMode": true,
                        "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                    }
                },
                "hover": {
                    "mode": "nearest",
                    "intersect": true
                },
                maintainAspectRatio: false,
                responsive: true,
                aspectRatio: 1,
                width: 600,
                height: 700,
            }
        });

        getVisitors();
        async function getVisitors() {
            let url = "{{ route('admin.package.visitor.history') }}";
            try {
                const res = await axios.get(url);
                packagesVisitorsHistory.data.labels = res.data.labels;
                packagesVisitorsHistory.config.data.datasets[0].data = res.data.currentMonthVisitsData;
                packagesVisitorsHistory.config.data.labels = res.data.labels;
                packagesVisitorsHistory.update();
                Notiflix.Block.remove('#VisitorCard')
            } catch (err) {
                console.error(err);
            }
        }
    </script>
@endpush
