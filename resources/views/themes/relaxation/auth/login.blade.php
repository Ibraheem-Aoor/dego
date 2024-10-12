@extends($theme.'layouts.app')
@section('title',trans('Login'))
@section('content')
    @foreach($content->contentDetails as $item)
        <section class="sign-in">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="sign-in-container">
                            <div class="sign-in-container-inner">
                                <div class="sign-in-logo mb_30">
                                    <a href="{{ route('page', '/') }}"><img src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="logo"></a>
                                </div>
                                <div class="sign-in-title">
                                    <h3 class="mb_15">{{ optional($item->description)->title }}</h3>
                                    <p>{{ optional($item->description)->sub_title }}</p>
                                </div>
                                <div class="sign-in-form">
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf

                                        <div class="sign-in-form-group">
                                            <label>@lang('Username')</label>
                                            <input type="text" class="sign-in-input" name="username" value="{{ old('username') }}" placeholder="@lang('Username')">
                                            @error('username')
                                            <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label for="password">@lang('Password')</label>
                                            <div class="password-box">
                                                <input type="password" name="password" id="password" class="sign-in-input password" value="{{ old('password') }}" placeholder="@lang('Password...')">
                                                <i class="password-icon fa-regular fa-eye"></i>
                                            </div>
                                            @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_login == 1)
                                            <div class="sign-in-form-group">
                                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                                @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                        @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_login === 1)
                                            <div class="sign-in-form-group">
                                                <div class="mb-4">
                                                    <div class="input-group input-group-merge">
                                                        <img src="{{ route('captcha') . '?rand=' . rand() }}" id="captcha_image" class="img-fluid rounded" alt="Captcha Image">
                                                        <div class="input-group-append ps-3 d-flex">
                                                            <input type="text" tabindex="2" class="form-control" name="captcha" id="captcha" autocomplete="off" placeholder="@lang('Enter Captcha')" required>
                                                            <a href="javascript: refreshCaptcha();" class="input-group-text">
                                                                <i class="fas fa-sync-alt text-primary" aria-hidden="true"></i>
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
                                        <div class="rember">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheck1">@lang('Remember me')</label>
                                            </div>
                                            <div class="rember-password">
                                                <a href="{{ route('password.request') }}">@lang('Forget Password?')</a>
                                            </div>
                                        </div>
                                        <div class="sign-in-btn">
                                            <button type="submit" class="btn-1">@lang('Sign In') <span></span></button>
                                        </div>
                                    </form>
                                    <div class="media-login">
                                        @if(config('socialite.google_status') || config('socialite.facebook_status') || config('socialite.github_status'))
                                            <div class="media-login-border"><h5>@lang('OR')</h5></div>
                                        @endif

                                        <ul class="justify-content-center">
                                            @if(config('socialite.google_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','google')}}"><img src="{{ asset($themeTrue. 'img/icons/google.png') }}" alt="icon"></a></li>
                                            @endif
                                            @if(config('socialite.facebook_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','facebook')}}"><img src="{{ asset('assets/admin/facebook.png') }}" alt="icon"></a></li>
                                            @endif
                                            @if(config('socialite.github_status'))
                                                <li class="pe-2"><a href="{{route('socialiteLogin','github')}}"><img src="{{ asset($themeTrue. 'img/icons/github.png') }}" alt="icon"></a></li>
                                            @endif
                                        </ul>
                                        <div class="signup-account">
                                            <p>@lang('Don’t have an account ?') <a href="{{ route('register') }}">@lang('Sign Up')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="sign-in-image text-end">
                            <img src="{{ getFile($content->media->image->driver,  $content->media->image->path)}}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
@push('style')
    <style>
        .input-group-text{
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
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

