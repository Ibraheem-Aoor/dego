@extends(template().'layouts.app')
@section('title',trans('Register'))
@section('content')
    @foreach($content->contentDetails as $item)
        <section class="sign-in">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="sign-in-container">
                            <div class="sign-in-container-inner">
                                <div class="sign-in-logo mb_30">
                                    <a href="{{ route('page','/') }}"><img
                                            src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}"
                                            alt="logo"></a>
                                </div>
                                <div class="sign-in-title">
                                    <h3 class="mb_15">{{ optional($item->description)->heading }}</h3>
                                    <p>{{ optional($item->description)->sub_heading }}</p>
                                </div>
                                <div class="sign-in-form">
                                    <form action="{{ route('register') }}" method="post">
                                        @csrf

                                        <div class="sign-in-form-name">
                                            <div class="sign-in-form-group">
                                                <label class="form-label" for="fname">@lang('First Name')</label>
                                                <input type="text" class="sign-in-input" name="fname" id="fname"
                                                       value="{{ old('fname', request()->fname)  }}"
                                                       placeholder="@lang('First Name')">
                                                @error('fname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="sign-in-form-group">
                                                <label class="form-label" for="lname">@lang('Last Name')</label>
                                                <input type="text" class="sign-in-input" name="lname"
                                                       value="{{ old('lname', request()->lname)  }}" id="lname"
                                                       placeholder="@lang('Last Name')">
                                                @error('lname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label class="form-label" for="username">@lang('Username')</label>
                                            <input type="text" class="sign-in-input" name="username"
                                                   value="{{ old('username', request()->username)  }}" id="username"
                                                   placeholder="@lang('User Name')">
                                            @error('username')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label class="form-label text-capitalize" for="email">@lang('email')</label>
                                            <input type="email" class="sign-in-input" name="email"
                                                   value="{{ old('email', request()->email)  }}" id="email"
                                                   placeholder="@lang('Email')">
                                            @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label class="form-label text-capitalize"
                                                   for="telephone">@lang('phone')</label>
                                            <input id="telephone" class="sign-in-input" name="phone"
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
                                        <div class="sign-in-form-group">
                                            <label class="form-label" for="password">@lang('Password')</label>
                                            <div class="password-box">
                                                <input type="password" class="sign-in-input password" name="password"
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
                                        <div class="sign-in-form-group">
                                            <label class="form-label"
                                                   for="password_confirmation">@lang('Confirm Password')</label>
                                            <div class="password-box">
                                                <input type="password" class="sign-in-input password"
                                                       name="password_confirmation" id="password_confirmation"
                                                       value="{{ old('password_confirmation', request()->password_confirmation)  }}"
                                                       placeholder="@lang('Confirm Password')">
                                                <i id="password-confirmation-icon"
                                                   class="password-confirmation-icon fa-regular fa-eye"></i>
                                            </div>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_register == 1)
                                            <div class="sign-in-form-group">
                                                <div
                                                    class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                                    data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                                @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                        @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_register === 1)
                                            <div class="sign-in-form-group">
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
                                        <div class="sign-in-btn">
                                            <button type="submit" class="btn-1">@lang('Create Account')<span></span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="media-login">
                                        @if(config('socialite.google_status') || config('socialite.facebook_status') || config('socialite.github_status'))
                                            <div class="media-login-border"><h5>@lang('OR')</h5></div>
                                        @endif

                                        <ul class="justify-content-center">
                                            @if(config('socialite.google_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','google')}}"><img
                                                            src="{{ asset($themeTrue. 'img/icons/google.png') }}"
                                                            alt="icon"></a></li>
                                            @endif
                                            @if(config('socialite.facebook_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','facebook')}}"><img
                                                            src="{{ asset('assets/admin/facebook.png') }}"
                                                            alt="icon"></a></li>
                                            @endif
                                            @if(config('socialite.github_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','github')}}"><img
                                                            src="{{ asset($themeTrue. 'img/icons/github.png') }}"
                                                            alt="icon"></a></li>
                                            @endif
                                        </ul>
                                        <div class="signup-account">
                                            <p>@lang('Already have an account ?') <a
                                                    href="{{ route('login') }}">@lang('Sign In')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="sign-in-image text-end">
                            <img
                                src="{{ getFile(optional(optional($content->media)->image)->driver,  optional($content->media)->image->path)}}"
                                alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
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
                let input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#password-confirmation-icon').click(function () {
                let input = $(this).prev('input');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
@endpush

