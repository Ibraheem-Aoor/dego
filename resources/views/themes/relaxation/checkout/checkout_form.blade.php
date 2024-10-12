@extends($theme.'layouts.app')
@section('title',trans('Checkout'))

@section('content')
    @include(template().'partials.breadcrumb')
    @include(template().'checkout.partials.form')

    @include(template().'sections.footer')
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <style>
        .support_form{
            width: 230%;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        'use strict';
        document.addEventListener("DOMContentLoaded", function() {
            const editButton = document.querySelector('.edit-btn');
            const scheduleDiv = document.querySelector('.schedule');
            const dateInput = document.querySelector('.schedule-form input[name="date"]');
            const csrfToken = '{{ csrf_token() }}';

            editButton.addEventListener('click', function (event) {
                event.preventDefault();
                scheduleDiv.classList.toggle('d-none');
            });
            flatpickr('#myID', {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: 'today',
                disableMobile: "true"
            });

            flatpickr(dateInput, {
                enableTime: false,
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disableMobile: "true",
                onClose: function (selectedDates, dateStr) {
                    $.ajax({
                        url: '{{ route("user.date.update") }}',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': csrfToken},
                        data: {
                            id: "{{ $instant->id }}",
                            date: dateStr
                        },
                        success: function (response) {
                            document.querySelector('.updated-date').textContent = dateStr;
                            const url = new URL(window.location.href);
                            url.searchParams.set('date', dateStr);
                            history.pushState({}, '', url.toString());
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            document.getElementById('checkoutForm').addEventListener('submit', function(event) {
                const totalPrice = document.getElementById('amount').value;
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'amount';
                hiddenInput.value = totalPrice;
                this.appendChild(hiddenInput);
            });

        });
        $(document).ready(function () {

            const currencySymbol = '{{ basicControl()->currency_symbol }}';

            function handleDiscountErrors(message, color) {
                $('.discountMessage').text(message).css({'color': color});
            }

            $('#grossAmount').text(currencySymbol + parseFloat($('#amount').val()).toFixed(0));

            $('#apply-coupon-btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('user.coupon.check') }}',
                    type: 'GET',
                    data: {
                        coupon: $('#coupon-input').val(),
                        instantId: "{{ $instant->id }}",
                        amount: "{{$instant->total_price}}"
                    },
                    success: function(response) {
                        if (response) {
                            const discount = response.data.discount_amount;
                            const currentTotal = response.data.total_price;
                            $('#amount').val(currentTotal);
                            $('#totalDiscount').text(currencySymbol + discount.toFixed(0));
                            handleDiscountErrors(`You got ${currencySymbol}${discount} discount`, 'green');
                            $('#grossAmount').text(currencySymbol + currentTotal.toFixed(0));
                        } else {
                            handleDiscountErrors(response.message, 'red');
                        }
                    },
                    error: function() {
                        handleDiscountErrors('The Coupon is invalid.', 'red');
                    }
                });
            });

            $('.crypto-select').select2();
            $('.select2').select2();


            let amountField = $('#amount');
            let amountStatus = false;
            let selectedGateway = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            let isGatewayChecked = $(".select-payment-method").is(":checked");
            if (isGatewayChecked) {
                selectedGateway = $('.select-payment-method').val();
                supportCurrency(selectedGateway);
            }

            $(document).on('click', '.select-payment-method', function () {
                selectedGateway = $(this).val();

                $('.crypto-currency').removeClass('d-none');
                $('.fiat-currency').removeClass('d-none');
                supportCurrency(selectedGateway);
            });

            function supportCurrency(selectedGateway) {
                if (!selectedGateway) {
                    console.error('Selected Gateway is undefined or null.');
                    return;
                }
                $('#supported_currency').empty();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.payment.supported.currency') }}",
                    data: {gateway: selectedGateway},
                    type: "GET",
                    success: function (response) {
                        if (response.data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let markup = '<option value="">Selected Currency</option>';
                        $('#supported_currency').append(markup);

                        if (response.currencyType == 1) {
                            $('.fiat-currency').show();
                            $('.crypto-currency').hide();
                            $(response.data).each(function (index, value) {
                                let selected = index == 0 ? ' selected' : '';
                                let markup = `<option value="${value}"${selected}>${value}</option>`;
                                $('#supported_currency').append(markup);

                            });
                            let amount = amountField.val();
                            checkAmount(amount, response.currency, selectedGateway)
                        } else {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }


                        if (response.currencyType === 0) {
                            $('.fiat-currency').hide();
                            $('.crypto-currency').show();
                            let markupCrypto = ` <label class="form-label">@lang("Select Crypto Currency")</label>
                                        <select class="form-control crypto-select"
                                                name="supported_crypto_currency"
                                                id="supported_crypto_currency">
                                              <option value="">@lang("Selected Crypto Currency")</option>
                                        </select>`;
                            $('.crypto-currency').empty().append(markupCrypto);

                            $(response.data).each(function (index, value) {
                                let selected = index == 0 ? ' selected' : '';
                                let markupOption = `<option value="${value}" ${selected}>${value}</option>`;
                                $('#supported_crypto_currency').append(markupOption);
                            });

                            $('#supported_crypto_currency').select2({
                                placeholder: "@lang('Select Crypto Currency')",
                            });

                            amountField.val(response.min_amount);
                            $(amountField).addClass('is-valid');
                            let amount = amountField.val();
                            checkAmount(amount, response.currency, selectedGateway, response.currency)
                        }
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            $(document).on('change, input', "#amount, #supported_currency, .select-payment-method, #supported_crypto_currency", function (e) {

                let amount = amountField.val();
                let selectedCurrency = $('#supported_currency').val() ?? 'USD';
                let selectedCryptoCurrency = $('#supported_crypto_currency').val();
                let currency_type = 1;
                if (!isNaN(amount) && amount > 0) {
                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;

                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        amountField.val(amount);
                    }
                    checkAmount(amount, selectedCurrency, selectedGateway, selectedCryptoCurrency)
                } else {
                    clearMessage(amountField)
                }
            });

            function checkAmount(amount, selectedCurrency, selectGateway, selectedCryptoCurrency = null) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('user.payment.check-amount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'select_gateway': selectGateway,
                        'selectedCryptoCurrency': selectedCryptoCurrency,
                    }
                }).done(function (response) {
                    let amountField = $('#amount');
                    if (response.status) {

                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        $('.confirmBtn').removeClass('d-none').addClass('d-block');
                        $('.form-check').removeClass('d-none').addClass('d-block');
                        amountStatus = true;
                        let base_currency = "{{ basicControl()->base_currency }}"
                        showSummery(response, base_currency);
                    } else {
                        amountStatus = false;
                        clearMessage(amountField);
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
                    }


                });
            }


            function showSummery(response, currency) {
                let formattedAmount = response.amount;
                let formattedChargeAmount = response.charge;
                let formattedPayableAmount = response.payable_amount;
                let payableAmountInBase = response.amount_in_base_currency;

                let paymentSummery = `
                                    <h5 class="title">@lang("Payment Summery")</h5>
                                    <li class="item">
                                        <span class="item-name">Amount</span>
                                        <span class="item-value">${formattedAmount} ${response.currency}</span>
                                    </li>
                                    <li class="item text-danger">
                                        <span class="item-name">Charge</span>
                                        <span class="item-value">${formattedChargeAmount} ${response.currency}</span>
                                    </li>
                                    <li class="item">
                                        <span class="item-name"><a href="javascript:void(0)">Payable Amount</a></span>
                                        <span
                                        <span class="item-value ">${formattedPayableAmount} ${response.currency}</span>
                                   </li>`;
                $('.show-deposit-summery').html(paymentSummery)
            }
        });

        isAgree();

        $(document).on('click', '.agree-checked', function () {
            isAgree();
        });

        function isAgree() {
            let isAgreeChecked = $(".agree-checked").is(":checked");
            $('.payment-btn-group .cmn-btn').attr('disabled', !isAgreeChecked);
        }
    </script>
@endpush
