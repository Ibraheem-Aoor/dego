@extends($theme.'layouts.app')

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
                        <form class="login-form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="section-header">
                                <h3 class="title mb-30">@lang('Reset Password')</h3>
                            </div>
                            <div class="row g-4">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="col-12">
                                    <label for="password" class="form-label">@lang('New Password')</label>
                                    <div class="password-box">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                        <i id="password-icon" class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">@lang('Confirm Password')</label>
                                    <div class="password-box">
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                                        <i id="password-confirmation-icon" class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn2 mt-30 w-100">@lang('Reset Password')</button>
                        </form>
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
