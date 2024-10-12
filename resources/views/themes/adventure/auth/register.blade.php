@extends(template().'layouts.app')
@section('title',trans('Register'))
@section('content')
    <section class="login-signup-page pt-0 pb-0 min-vh-100 h-100">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                @include(template().'sections.account_partials')
                @foreach($content->contentDetails as $item)
                    <div class="col-md-6 p-0 d-flex align-items-center">
                        <div class="login-signup-form">
                            <form action="{{ route('register') }}" method="post">
                                @csrf

                                <div class="section-header">
                                    <h3>{{ optional($item->description)->heading }}!</h3>
                                    <div class="description">{{ optional($item->description)->sub_heading }}</div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="fname" id="fname"
                                               value="{{ old('fname', request()->fname)  }}"
                                               placeholder="@lang('First Name')">
                                        @error('fname')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="lname"
                                               value="{{ old('lname', request()->lname)  }}" id="lname"
                                               placeholder="@lang('Last Name')">
                                        @error('lname')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="username"
                                               value="{{ old('username', request()->username)  }}" id="username"
                                               placeholder="@lang('User Name')">
                                        @error('username')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <input type="email" class="form-control" name="email"
                                               value="{{ old('email', request()->email) }}" id="email"
                                               placeholder="@lang('Email')">
                                        @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 regItem">
                                        <input id="telephone" class="form-control phoneInput" name="phone"
                                               value="{{ old('phone', request()->phone)  }}" type="tel">
                                        <input type="hidden" name="code" id="phoneCode"/>
                                        <input type="hidden" name="country" id="countryName"/>
                                        <input type="hidden" name="countryCode" id="countryCode"/>
                                        @error('phone')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="password-box">
                                            <input type="password" class="form-control password" name="password"
                                                   id="password" value="{{ old('password', request()->password)  }}"
                                                   placeholder="@lang('Password')">
                                            <i id="password-icon" class="password-icon fa-regular fa-eye"></i>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="password-box">
                                            <input type="password" class="form-control password"
                                                   name="password_confirmation" id="password_confirmation"
                                                   value="{{ old('password_confirmation', request()->password_confirmation)  }}"
                                                   placeholder="@lang('Confirm Password')">
                                            <i id="password-confirmation-icon"
                                               class="password-icon fa-regular fa-eye"></i>
                                        </div>
                                        @error('password_confirmation')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_register == 1)
                                        <div class="row mt-4 mb-4">
                                            <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                                 data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                            @error('g-recaptcha-response')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_register === 1)
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <div class="input-group input-group-merge">
                                                    <img src="{{ route('captcha') . '?rand=' . rand() }}"
                                                         id="captcha_image" class="img-fluid rounded"
                                                         alt="Captcha Image">
                                                    <div class="input-group-append ps-3 d-flex">
                                                        <input type="text" tabindex="2" class="form-control"
                                                               name="captcha" id="captcha" autocomplete="off"
                                                               placeholder="@lang('Enter Captcha')" required>
                                                        <a href="javascript: refreshCaptcha();"
                                                           class="input-group-text">
                                                            <i class="fas fa-sync-alt text-primary pb-2"
                                                               aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                @error('captcha')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit"
                                        class="btn cmn-btn2 mt-30 w-100">@lang(optional($item->description)->sign_up_button)</button>
                                <div class="pt-20 text-center">
                                    @lang("Don't have an account?")
                                    <p class="mb-0 highlight"><a
                                            href="{{ route('login') }}">@lang(optional($item->description)->login_button )</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/intlTelInput.min.css') }}">
    <style>
        .iti {
            width: 100% !important;
        }

        .input-group-text {
            height: 44px !important;
        }

        .regItem .phoneInput {
            padding-left: 95px !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/intlTelInput.min.js')}}"></script>
    @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_register == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        const input = document.querySelector("#telephone");
        const iti = window.intlTelInput(input, {
            initialCountry: "bd",
            separateDialCode: true,
        });

        function updateCountryInfo() {
            const selectedCountryData = iti.getSelectedCountryData();
            const phoneCode = selectedCountryData.dialCode;
            const countryName = selectedCountryData.name;
            const countryCode = selectedCountryData.iso2;
            $('#phoneCode').val(phoneCode)
            $('#countryName').val(countryName)
            $('#countryCode').val(countryCode)
        }

        input.addEventListener("countrychange", updateCountryInfo);
        updateCountryInfo();


        function refreshCaptcha() {
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }

        $(document).ready(function () {
            $('#password-icon').click(function () {
                let $input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#password-confirmation-icon').click(function () {
                var $input = $(this).prev('input');
                var type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
@endpush

