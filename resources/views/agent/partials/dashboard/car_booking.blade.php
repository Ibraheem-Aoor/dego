<div class="card mb-3 mb-lg-5">
    <div class="card-header card-header-content-sm-between">
        <h4 class="card-header-title mb-2 mb-sm-0">@lang('Car Booking')<i class="bi-question-circle text-body ms-1"
                                                                         data-bs-toggle="tooltip"
                                                                         data-bs-placement="top"
                                                                         aria-label="@lang('Total Package Booking History.')"
                                                                         title="@lang('Total Package Booking History.')"></i>
        </h4>
    </div>
    <div class="card-body">
        <div class="row col-lg-divider">
            <div class="col-lg-9 mb-5 mb-lg-0">
                <div class="chartjs-custom mb-4 bar-chart-height" id="CarBooking">
                    <canvas id="CarBookingChart" class="js-chart"></canvas>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <span class="legend-indicator"></span> @lang('Booking Amount')
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> @lang('Car Booking')
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-6 col-lg-12">
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle">@lang('Total Property Booking')</h6>
                            <span class="d-block display-4 text-dark mb-1 me-3">{{ $car_booking. ' Unit' }}</span>
                        </div>
                        <hr class="d-none d-lg-block my-0">
                    </div>

                    <div class="col-sm-6 col-lg-12">
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle">@lang('Total Booking Amount')</h6>
                            <span class="d-block display-4 text-dark mb-1 me-3">{{ currencyPosition($car_booking_totalAmount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('style')
    <style>
        .sales-chart-height {
            height: 15rem;
        }

        .aside-sales-chart-height {
            min-height: 9rem;
        }

        .bar-chart-height {
            height: 18rem;
        }
    </style>
@endpush
@push('script')
    <script>
        Notiflix.Block.standard('#CarBooking')
        const CarBookingChart = new Chart("CarBookingChart", {
            type: "bar",
            data: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        label: "Total Booking",
                        backgroundColor: "#e7eaf3",
                        hoverBackgroundColor: "#377dff",
                        borderColor: "#377dff",
                        maxBarThickness: "10"
                    },
                    {
                        data: [],
                        label: "Total Price",
                        backgroundColor: "#377dff",
                        borderColor: "#e7eaf3",
                        maxBarThickness: "10"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        grid: {
                            color: "#e7eaf3",
                            drawBorder: false,
                            zeroLineColor: "#e7eaf3"
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1000,
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 5
                        },
                        categoryPercentage: 0.5,
                        maxBarThickness: "10"
                    }
                },
                cornerRadius: 2,
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: "index",
                        intersect: false
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });

        getData();
        async function getData() {
            let url = "{{ route('agent.booking.History') }}";
            try {
                const res = await axios.get(url , {
                    params: {
                        model: "{{ CarBooking::class }}",
                    }
                });
                CarBookingChart.data.labels = res.data.labels;
                CarBookingChart.config.data.datasets[0].data = res.data.Unit;
                CarBookingChart.config.data.datasets[1].data = res.data.Price;
                CarBookingChart.update();
                Notiflix.Block.remove('#CarBooking')
            } catch (err) {
                console.error(err);
            }
        }

        $(document).ready(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
