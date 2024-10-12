@extends($theme.'layouts.app')
@section('title', trans('Reset Password'))
@section('content')
    <section class="sign-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="sign-in-container">
                        <div class="sign-in-container-inner">
                            <div class="sign-in-form">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="login-form" action="{{ route('password.email') }}"  method="post">
                                    @csrf

                                    <div class="row mb-4">
                                        <div class="sign-in-form-group">
                                            <h3 class="title mb-30">@lang('Reset Password')</h3>
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                            <input id="email" type="email" class="sign-in-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn-1 mt-30 w-100">@lang('Send Password Reset Link')</button>
                                </form>
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
@endsection
