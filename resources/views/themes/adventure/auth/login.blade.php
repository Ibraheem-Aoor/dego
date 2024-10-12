@extends($theme.'layouts.app')
@section('title',trans('Login'))
@section('content')
    @foreach($content->contentDetails as $item)
        <section class="login-signup-page pt-0 pb-0 min-vh-100 h-100">
            <div class="container-fluid h-100">
                <div class="row min-vh-100">
                    @include(template().'sections.account_partials')
                    <div class="col-md-6 p-0 d-flex justify-content-center flex-column">
                        <div class="login-signup-form">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="section-header">
                                    <h3>@lang(optional($item->description)->title)</h3>
                                    <div class="description">@lang(optional($item->description)->sub_title)</div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="username" value="{{old('username')}}" placeholder="@lang('Username')">
                                        @error('username')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="password-box">
                                            <input type="password" class="form-control password" name="password" value="{{old('password')}}" id="password" placeholder="@lang('Password')">
                                            <i id="password-icon" class="password-icon fa-regular fa-eye"></i>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_login == 1)
                                        <div class="row mt-4 mb-4">
                                            <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                            @error('g-recaptcha-response')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_login === 1)
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <div class="input-group input-group-merge  manual">
                                                    <img src="{{ route('captcha') . '?rand=' . rand() }}" id="captcha_image" class="img-fluid rounded" alt="Captcha Image">
                                                    <div class="input-group-append ps-3 d-flex">
                                                        <input type="text" tabindex="2" class="form-control" name="captcha" id="captcha" autocomplete="off" placeholder="@lang('Enter Captcha')" required>
                                                        <a href="javascript: refreshCaptcha();" class="input-group-text">
                                                            <i class="fas fa-sync-alt text-white" aria-hidden="true"></i>
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
                                    <div class="col-12">
                                        <div class="form-check d-flex justify-content-between">
                                            <div class="check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheck1">@lang('Remember me')</label>
                                            </div>
                                            <div class="forgot highlight">
                                                <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="cmn-btn2 mt-30 w-100">@lang(optional($item->description)->submit_button)</button>
                                @if(config('socialite.google_status') || config('socialite.facebook_status') || config('socialite.github_status'))
                                    <hr class="divider">
                                @endif
                                <div class="cmn-btn-group">
                                    <div class="row g-2 justify-content-center">
                                        @if(config('socialite.google_status'))
                                            <div class="col-sm-4">
                                                <a href="{{route('socialiteLogin','google')}}"
                                                   class="btn cmn-btn3 w-100 social-btn"><img
                                                        src="{{$themeTrue.'img/login_signup/google.png'}}"
                                                        alt="Google Icon">@lang('Google')
                                                </a>
                                            </div>
                                        @endif
                                        @if(config('socialite.facebook_status'))
                                            <div class="col-sm-4">
                                                <a href="{{route('socialiteLogin','facebook')}}"
                                                   class="btn cmn-btn3 w-100 social-btn"><img
                                                        src="{{$themeTrue.'img/login_signup/facebook.png'}}"
                                                        alt="facebook Icon">@lang('Facebook')
                                                </a>
                                            </div>
                                        @endif
                                        @if(config('socialite.github_status'))
                                            <div class="col-sm-4">
                                                <a href="{{route('socialiteLogin','github')}}"
                                                   class="btn cmn-btn3 w-100 social-btn"><img
                                                        src="{{$themeTrue.'img/login_signup/github.png'}}"
                                                        alt="Github Icon">@lang('Github')
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="pt-20 text-center">
                                    @lang("Don't have an account?")
                                    <p class="mb-0 highlight"><a href="{{ route('register') }}">@lang(optional($item->description)->create_account)</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
@push('style')
    <style>
        .manual .input-group-text{
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .manual .input-group-append .form-control{
            padding: 0 .75rem !important;
            height: 100%;
        }

    </style>
@endpush

@push('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function refreshCaptcha() {
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }

        $(document).ready(function() {
            $('#password-icon').click(function() {
                let $input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
@endpush

