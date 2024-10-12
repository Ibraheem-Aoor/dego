@extends('layouts.app')
@section('title', trans('Confirm'))
@section('content')
    <section class="sign-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="sign-in-container">
                        <div class="sign-in-container-inner">
                            <div class="sign-in-form">
                                <h4>@lang('Confirm Password')</h4>

                                @lang('Please confirm your password before continuing.')

                                <form class="login-form" action="{{ route('password.confirm') }}"  method="post">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">@lang('Password')</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('Confirm Password')
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    @lang('Forgot Your Password?')
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>>
@endsection
