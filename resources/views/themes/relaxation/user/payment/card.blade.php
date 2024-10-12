@extends($theme.'layouts.user')
@section('title')
    {{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
    @push('style')
        <link href="{{ asset('assets/admin/css/card-js.min.css') }}" rel="stylesheet" type="text/css"/>

    @endpush

    <section>
        <main id="main" class="main mt-0 pt-0" >
            <div class="pagetitle">
                <h3 class="mb-1">@lang('Dashboard')</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-capitalize"
                                                       href="{{ route('page','/') }}">@lang('home')</a></li>
                        <li class="breadcrumb-item active">@lang($deposit->gateway->name)</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12">
                <div class="row g-4 justify-content-center">
                    <div class="col-8 cardPaymentOption">
                        <div class="card p-0">
                            <div class="card-body ">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <h4 class="card-title text-center mb-4"> @lang('Your Card Information')</h4>
                                    </div>
                                    <div class="col-md-3 mb-10">
                                        <div class="card">
                                            <img
                                                src="{{ getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image) }}"
                                                class="card-img-top gateway-img" alt="..">
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <form class="form-horizontal" id="example-form"
                                              action="{{ route('ipn', [optional($deposit->gateway)->code ?? '', $deposit->trx_id]) }}"
                                              method="post">
                                            <div class="card-js form-group --payment-card">
                                                <input class="card-number form-control"
                                                       name="card_number"
                                                       placeholder="@lang('Enter your card number')"
                                                       autocomplete="off"
                                                       required>
                                                <input class="name form-control"
                                                       id="the-card-name-id"
                                                       name="card_name"
                                                       placeholder="@lang('Enter the name on your card')"
                                                       autocomplete="off"
                                                       required>
                                                <input class="expiry form-control"
                                                       autocomplete="off"
                                                       required>
                                                <input class="expiry-month" name="expiry_month">
                                                <input class="expiry-year" name="expiry_year">
                                                <input class="cvc form-control"
                                                       name="card_cvc"
                                                       autocomplete="off"
                                                       required>
                                            </div>
                                            <div class="cardPaymentSubmit">
                                                <button type="submit" class="cmn-btn mt-2">@lang('Submit')</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>


    @push('script')
        <script src="{{ asset('assets/admin/js/card-js.min.js') }}"></script>
    @endpush

@endsection

@push('style')
    <style>
        .card-js .icon{
            top: 3px !important;
        }
    </style>
@endpush
