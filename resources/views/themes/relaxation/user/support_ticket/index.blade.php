@extends($theme.'layouts.user')
@section('title',trans('Support Ticket'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Support Ticket List')</li>
                </ol>
            </nav>
        </div>
        <div class="row card">
            <div class="col-12">
                <div class="card-header ticketList">
                    <a class="cmn-btn2 float-end" href="{{ route('user.ticket.create') }}">@lang('Create Ticket')</a>
                </div>
                <div class="card-body">
                    <div class="cmn-table">
                        <div class="table-responsive overflow-hidden">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('SI')</th>
                                        <th scope="col">@lang('Subject')</th>
                                        <th scope="col">@lang('status')</th>
                                        <th scope="col">@lang('Last Reply')</th>
                                        <th scope="col">@lang('Created At')</th>
                                        <th scope="col">@lang('action')</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                @forelse($tickets as $key => $ticket)
                                    <tr>
                                        <td data-label="@lang('Serial')">

                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td data-label="@lang('Subject')">
                                            <span class="font-weight-bold">
                                                [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }}
                                            </span>
                                        </td>
                                        <td data-label="Status">
                                            @if($ticket->status == 0)
                                                <span class="badge text-bg-primary">@lang('Open')</span>
                                            @elseif($ticket->status == 1)
                                                <span class="badge text-bg-success">@lang('Answered')</span>
                                            @elseif($ticket->status == 2)
                                                <span class="badge text-bg-warning">@lang('Replied')</span>
                                            @elseif($ticket->status == 3)
                                                <span class="badge text-bg-danger">@lang('Closed')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Last Reply')">
                                            {{diffForHumans($ticket->last_reply) }}
                                        </td>
                                        <td data-label="@lang('Created At')">
                                            <span class="font-weight-bold">
                                                {{ dateTime($ticket->created_at) }}
                                            </span>
                                        </td>



                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('user.ticket.view', $ticket->ticket) }}"
                                               class="btn btn-outline-light btn-sm text-dark"
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="@lang("Ticket Details.")"
                                            >
                                                <i class="fa-regular fa-eye pe-1"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="100%" class="text-center text-dark">
                                            <div class="no_data_iamge text-center">
                                                <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                            </div>
                                            <p class="text-center">@lang('Ticket List is empty here!.')</p>
                                        </th>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $tickets->appends(request()->query())->links($theme.'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('css')
    <style>
        .card-header{
            border-bottom: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
