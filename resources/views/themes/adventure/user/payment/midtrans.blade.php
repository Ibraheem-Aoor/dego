@extends($theme.'layouts.user')
@section('title')
	{{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang($deposit->gateway->name)</li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="row g-4 justify-content-center midteansPaymentOption">
                <div class="col-8">
                    <div class="card p-0">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-3">
                                    <img
                                        src="{{getFile(optional($deposit->gateway)->driver,optional($deposit->gateway)->image)}}"
                                        class="card-img-top gateway-img">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="my-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
                                    <button type="button"
                                            class="cmn-btn"
                                            id="pay-button">@lang('Pay Now')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@push('script')
	@if($data->environment == 'test')
		<script type="text/javascript"
				src="https://app.sandbox.midtrans.com/snap/snap.js"
				data-client-key="{{ $data->client_key }}"></script>
	@else
		<script type="text/javascript"
				src="https://app.midtrans.com/snap/snap.js"
				data-client-key="{{ $data->client_key }}"></script>
	@endif
    <script defer>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay("{{ $data->token }}", {
                onSuccess: function (result) {
                    let route = '{{ route('ipn', ['midtrans']) }}/';
                    window.location.href = route + result.order_id;
                },
                onPending: function (result) {
                    let route = '{{ route('ipn', ['midtrans']) }}/';
                    window.location.href = route + result.order_id;
                },
                onError: function (result) {
                    window.location.href = '{{ route('failed') }}';
                },
                onClose: function () {
                    window.location.href = '{{ route('failed') }}';
                }
            });
        });
    </script>
@endpush



