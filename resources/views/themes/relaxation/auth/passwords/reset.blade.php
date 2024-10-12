@extends($theme.'layouts.app')
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
                                <form class="login-form" method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="row mb-4">
                                        <div class="sign-in-form-group">
                                            <h3 class="title mb-30">@lang('Reset Password')</h3>
                                        </div>
                                        <div class="sign-in-form-group">
                                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                                            <div class="password-box">
                                                <input id="password" type="password" class="sign-in-input" name="password" required autocomplete="new-password">
                                                <i id="password-icon" class="password-icon fa-regular fa-eye"></i>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="sign-in-form-group ">
                                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                            <div class="password-box">
                                                <input id="password_confirmation" type="password" class="sign-in-input" name="password_confirmation">
                                                <i id="password-confirmation-icon" class="password-icon fa-regular fa-eye"></i>
                                            </div>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-1 mt-30 w-100">@lang('Reset Password')</button>
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

@push('script')
    <script>
        $(document).ready(function() {
            $('#password-icon').click(function() {
                let $input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#password-confirmation-icon').click(function() {
                let $input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            $('#current-password-icon').click(function() {
                let $input = $(this).prev('input');
                let type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
@endpush
