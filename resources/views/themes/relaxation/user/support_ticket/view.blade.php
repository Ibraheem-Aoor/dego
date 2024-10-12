@extends($theme.'layouts.user')
@section('title',trans('View Ticket'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Support Ticket View')</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="message-wrapper card">
                    <div class="inbox-wrapper">
                        <div class="top-bar">
                            <div class="d-flex align-items-center">
                                <img class="user img-fluid" src="{{ isset($ticket->admin) ? getFile(@optional($ticket->admin)->image_driver, @optional($ticket->admin)->image) : asset('assets/global/img/user.jpg') }}" alt="{{ @optional($ticket->admin)->username }}" />
                                <div class="name">
                                    <a href="">{{ isset($ticket->admin) ? __(ucfirst(@optional($ticket->admin)->username)) : __('Admin') }}</a>
                                    <span>{{ trans('Ticket #'). $ticket->ticket }} [{{ $ticket->subject }}]</span><br>
                                    <span class="ticket-span-view">
                                        @if($ticket->status == 0)
                                                <span class="badge  text-bg-primary">@lang('Open')</span>
                                            @elseif($ticket->status == 1)
                                                <span class=" badge text-bg-success">@lang('Answered')</span>
                                            @elseif($ticket->status == 2)
                                                <span class="badge text-bg-dark">@lang('Customer Reply')</span>
                                            @elseif($ticket->status == 3)
                                                <span class="badge text-bg-danger">@lang('Closed')</span>
                                            @endif
                                    </span>
                                </div>
                            </div>
                            <div>
                                @if($ticket->status = 0 || $ticket->status = 1 || $ticket->status = 2)
                                    <button class="info-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#closeTicketModal"
                                    >
                                        <i class="fa-regular fa-close"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <!-- chats -->
                        <div class="card-body">
                            @include(template().'user.support_ticket.partials.chat')
                        </div>
                        @include(template().'user.support_ticket.partials.typing_area')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="closeTicketModal" tabindex="-1" aria-labelledby="addListingmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-black" id="editModalLabel">@lang('Close support ticket')</h4>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <form method="get" action="{{ route('user.ticket.close', $ticket->id) }}">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <p>@lang('Are you want to close ticket?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-success addCreateListingRoute" name="replayTicket"
                                value="2">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        /* Modal Background */
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Modal Header */
        .modal-header {
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Close Button */
        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #333;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .close-btn:hover {
            opacity: 1;
        }

        .close-btn i {
            pointer-events: none;
        }

        /* Modal Body */
        .modal-body {
            padding: 20px;
            font-size: 16px;
            color: #555;
        }

        /* Modal Footer */
        .modal-footer {
            border-top: 1px solid #ddd;
            padding: 10px 15px;
            display: flex;
            justify-content: flex-end;
        }

        /* Buttons */
        .btn-danger, .btn-success {
            padding: 8px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: #27ae60;
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background-color: #2ecc71;
        }
    </style>
@endpush

