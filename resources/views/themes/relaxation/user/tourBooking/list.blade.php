@extends($theme.'layouts.user')
@section('title',trans('Tour History'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1 text-capitalize">@lang('dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Tour History')</li>
                </ol>
            </nav>
        </div>
        <div class="card mt-50">
            <div class="card-header d-flex justify-content-between border-0">
                <h4>@lang('Tour History')</h4>
                <div class="btn-area">
                    <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                            class="fa-regular fa-filter"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Booking ID')</th>
                                <th scope="col">@lang('Destination')</th>
                                <th scope="col">@lang('Paid Amount')</th>
                                <th scope="col">@lang('Total Person')</th>
                                <th scope="col">@lang('Tour Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bookings as $item)
                                <tr>
                                    <td data-label="@lang('Transaction ID')"><span>{{$item->trx_id }}</span></td>
                                    <td data-label="@lang('Destination')">
                                        <a href="{{ route('package.details', optional($item->package)->slug) }}">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                <img class="favouriteImage"
                                                     src="{{ getFile(optional($item->package)->thumb_driver, optional($item->package)->thumb) }}"/>
                                                <p class="mb-0">@lang($item->package_title)</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td data-label="@lang('Paid Amount')"><span>{{ currencyPosition($item->total_price) }}</span></td>
                                    <td data-label="@lang('Total Person')"><span>{{ $item->total_person . ' People' }}</span>
                                    </td>
                                    <td data-label="@lang('Tour Date')"><span>{{ dateTime($item->date) }}</span></td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1 && $item->date > now())
                                            <span class="badge text-bg-warning">@lang('Pending')</span>
                                        @elseif($item->status == 2 && $item->date > now())
                                            <span class="badge text-bg-success">@lang('Completed')</span>
                                        @elseif($item->status == 4)
                                            <span class="badge text-bg-info">@lang('Refunded')</span>
                                        @elseif($item->date < now())
                                            <span class="badge text-bg-danger">@lang('Expired')</span>
                                        @endif
                                    </td>
                                    <td class="text-center" data-label="@lang('Action')">
                                        <a class="btn btn-outline-light btn-sm text-dark bookingView pointer"
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="@lang("Booking Details")"
                                           data-package="{{ route('package.details', optional($item->package)->slug ?? '') }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#viewInformation"
                                           data-title="{{ $item->package_title }}"
                                           data-date="{{ dateTime($item->date) }}"
                                           data-start_price="{{ currencyPosition($item->start_price) }}"
                                           data-total_adult="{{ $item->total_adult }}"
                                           data-total_children="{{ $item->total_children }}"
                                           data-total_infant="{{ $item->total_infant }}"
                                           data-total_person="{{ $item->total_person }}"
                                           data-total_price="{{ currencyPosition($item->total_price) }}"
                                           data-trx_id="{{ $item->trx_id }}"
                                           data-status="{{ $item->status }}"
                                        ><i class="fa-regular fa-eye pe-1"></i>@lang('Details')</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="100%" class="text-center text-dark">
                                        <div class="no_data_iamge text-center">
                                            <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                        </div>
                                        <p class="text-center">@lang('Tour History is empty here!.')</p>
                                    </th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $bookings->appends(request()->query())->links($theme.'partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include(template().'user.tourBooking.offcanvas')
    <div class="modal fade" id="viewInformation" tabindex="-1" aria-labelledby="viewInformationLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInformationLabel">@lang('Booking Information')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">@lang('Package Title: ')</th>
                            <td><a href="#" id="modal-package-title"></a></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Date:')</th>
                            <td id="modal-date"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Start Price:')</th>
                            <td id="modal-start-price"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Total Adults:')</th>
                            <td id="modal-total-adult"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Total Children:')</th>
                            <td id="modal-total-children"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Total Infants:')</th>
                            <td id="modal-total-infant"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Total Persons:')</th>
                            <td id="modal-total-person"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Total Price:')</th>
                            <td id="modal-total-price"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Transaction ID:')</th>
                            <td id="modal-trx-id"></td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('Status:')</th>
                            <td id="modal-status"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            color: white;
            padding: 15px;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            --bs-table-accent-bg: none !important;
        }

        .modal-header .btn-close {
            color: white;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 15px;
            border-top: 1px solid #e5e5e5;
        }

        .modal-footer .btn {
            border-radius: 5px;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        table tbody tr:last-child {
            border-bottom: 0px solid white;
        }

        #viewInformation {
            backdrop-filter: blur(10px);
        }

        .modal-body p {
            font-size: 1rem;
            margin: 10px 0;
        }

        .packageButton {
            padding: 5px 8px;
        }

        .pointer {
            cursor: pointer;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('.bookingView').on('click', function() {
                let packageTitle = $(this).data('title');
                let packageUrl = $(this).data('package');

                $('#modal-package-title').text(packageTitle).attr('href', packageUrl);

                let date = $(this).data('date');
                let startPrice = $(this).data('start_price');
                let totalAdult = $(this).data('total_adult');
                let totalChildren = $(this).data('total_children');
                let totalInfant = $(this).data('total_infant');
                let totalPerson = $(this).data('total_person');
                let totalPrice = $(this).data('total_price');
                let trxId = $(this).data('trx_id');
                let status = $(this).data('status');

                $('#modal-date').text(date);
                $('#modal-start-price').text(startPrice);
                $('#modal-total-adult').text(totalAdult);
                $('#modal-total-children').text(totalChildren);
                $('#modal-total-infant').text(totalInfant);
                $('#modal-total-person').text(totalPerson);
                $('#modal-total-price').text(totalPrice);
                $('#modal-trx-id').text(trxId);

                let statusBadge;
                if (status == 1) {
                    statusBadge = '<span class="badge text-bg-warning">@lang("Pending")</span>';
                } else if (status == 2) {
                    statusBadge = '<span class="badge text-bg-success">@lang("Completed")</span>';
                } else if (status == 4) {
                    statusBadge = '<span class="badge text-bg-info">@lang("Refunded")</span>';
                } else {
                    statusBadge = '<span class="badge text-bg-danger">@lang("Expired")</span>';
                }

                $('#modal-status').html(statusBadge);

                $('#viewInformation').modal('show');
            });
        });
    </script>
@endpush

