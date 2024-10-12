@extends($theme.'layouts.user')
@section('title',trans('Payment Log'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1 text-capitalize">@lang('dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize"
                                                   href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payment Log')</li>
                </ol>
            </nav>
        </div>
        <div class="card mt-50">
            <div class="card-header d-flex justify-content-between border-0">
                <h4>@lang('Payment Log')</h4>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Transaction ID')</th>
                                <th scope="col">@lang('Method')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td data-label="@lang('Transaction ID')">
                                        <span>{{$log->trx_id}}</span>
                                    </td>
                                    <td data-label="@lang('Method')">
                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                            <img class="favouriteImage"
                                                 src="{{getFile($log->gateway?->driver,$log->gateway?->image)}}"/>
                                            <p class="mb-0">{{$log->gateway?->name}}</p>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Amount')" class="name-data">
                                        <span
                                            class="name">{{currencyPosition($log->payable_amount_in_base_currency)}}</span>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($log->status == 1)
                                            <span class="badge text-bg-success">@lang('Successful')</span>
                                        @elseif($log->status == 2)
                                            <span class="badge text-bg-secondary">@lang('Pending')</span>
                                        @elseif($log->status == 3)
                                            <span class="badge text-bg-danger">@lang('Rejected')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Date')">
                                        <span>{{dateTime($log->created_at,basicControl()->date_time_format)}}</span>
                                    </td>
                                    <td data-label="@lang('Action')" class="td-btn">
                                        @php
                                            $details = null;
                                            if ($log->information) {
                                                $details = [];
                                                foreach ($log->information as $k => $v) {
                                                    if ($v->type == "file") {
                                                        $details[kebab2Title($k)] = [
                                                            'type' => $v->type,
                                                            'field_name' => $v->field_name,
                                                            'field_value' => getFile(config('filesystems.default'), $v->field_value),
                                                        ];
                                                    } else {
                                                        $details[kebab2Title($k)] = [
                                                            'type' => $v->type,
                                                            'field_name' => $v->field_name,
                                                            'field_value' => @$v->field_value ?? $v->field_name
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($log->payment_method_id > 999)
                                            <button type="button" class="btn btn-outline-light btn-sm text-dark bookingView pointer edit_btn"
                                                    data-detailsinfo="{{json_encode($details)}}"
                                                    data-feedback="{{$log->note}}" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"><i class="fa-regular fa-eye"></i> @lang('Details')
                                                <span></span>
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="100%" class="text-center text-dark">
                                        <div class="no_data_iamge text-center">
                                            <img class="no_image_size"
                                                 src="{{ asset('assets/global/img/oc-error.svg') }}">
                                        </div>
                                        <p class="text-center">@lang('Payment List is empty here!.')</p>
                                    </th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $logs->appends(request()->query())->links($theme.'partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang("Payment Information")</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <ul class="list-group mb-4 payment_information">
                            </ul>
                            <label>@lang('Admin Feedback')</label>
                            <textarea class="form-control" id="feedBack"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn3" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        $(document).on("click", '.edit_btn', function (e) {
            $('#feedBack').text();
            $('.payment_information').html('');
            let details = Object.entries($(this).data('detailsinfo'));
            let feedback = $(this).data('feedback');
            let list = details.map(([key, value]) => {

                let field_name = value.field_name;
                let field_value = value.field_value;
                let field_name_text = field_name.replace(/_/g, ' ');


                if (value.type === 'file') {
                    return `<li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <a href="${field_value}" target="_blank"><img src="${field_value}" alt="${field_name_text}" class="rounded-1" width="100"></a>
                                    </div>
                                </li>`;
                } else {
                    return `<li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <span>${field_value}</span>
                                    </div>
                                </li>`;
                }
            })

            $('#feedBack').text(feedback);
            $('.payment_information').html(list);

        });
    </script>
@endpush
