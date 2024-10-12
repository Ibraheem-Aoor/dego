@extends($theme.'layouts.app')
@section('title', trans('Reset Password'))

@section('content')
    <section class="login-signup-page pt-0 pb-0 min-vh-100 h-100">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                @include(template().'sections.account_partials')

                <div class="col-md-6 p-0 d-flex justify-content-center flex-column">
                    <div class="login-signup-form">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="login-form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="section-header">
                                <h3 class="title mb-30">@lang('Reset Password')</h3>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="email" class="form-label">@lang('Email Address')</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn2 mt-30 w-100">@lang('Send Password Reset Link')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
