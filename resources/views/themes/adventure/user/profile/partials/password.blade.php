@extends($theme.'layouts.user')
@section('title',trans('Password Settings'))
@section('content')
    <main id="main" class="main bg-color2">

        <div class="pagetitle">
            <h3 class="mb-1">@lang('Profile')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Profile')</li>
                </ol>
            </nav>
        </div>

        <div class="section dashboard">
            <div class="row">
                <div class="account-settings-navbar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('user.profile') }}"><i
                                    class="fa-light fa-user"></i>@lang('profile')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('user.change.password') }}"><i
                                    class="fa-light fa-key"></i>@lang('Password')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.notification.permission.list') }}"><i
                                    class="fa-light fa-link"></i>@lang('Notification')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.kyc.settings') }}"><i
                                    class="fa-light fa-link"></i>@lang('Identity Verification') </a>
                        </li>
                    </ul>
                </div>
                <div class="account-settings-profile-section">
                    <div class="card">
                        <form action="{{ route('user.updatePassword') }}" method="post">
                            @csrf
                            <div class="card-body pt-0">
                                <div class="profile-form-section">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="current_password" class="form-label">@lang('Current Password')</label>
                                            <div class="password-box">
                                                <input type="password" class="form-control current_password" value="{{ request()->current_password }}" name="current_password" id="current_password">
                                                <i class="password-icon fa-regular fa-eye current_password_icon"></i>
                                            </div>
                                            @if($errors->has('current_password'))
                                                <div class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">@lang('New Password')</label>
                                            <div class="password-box">
                                                <input type="password" class="form-control password" value="{{ request()->password }}" name="password" id="password">
                                                <i class="password-icon fa-regular fa-eye password_icon"></i>
                                            </div>
                                            @if($errors->has('current_password'))
                                                <div class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">@lang('Confirm Password')</label>
                                            <div class="password-box">
                                                <input type="password" class="form-control password_confirmation" value="{{ request()->password_confirmation }}" name="password_confirmation" id="password_confirmation">
                                                <i class="password-icon fa-regular fa-eye password_confirmation_icon"></i>
                                            </div>
                                            @if($errors->has('password_confirmation'))
                                                <div class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="btn-area d-flex g-3">
                                        <button type="submit" class="cmn-btn">@lang('save changes')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('style')
    <style>
        .password-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-box .form-control {
            padding-right: 35px;
        }

        .password-box .password-icon {
            position: absolute;
            right: 15px;
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            function togglePasswordVisibility(icon, input) {
                icon.toggleClass('fa-eye fa-eye-slash');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
            }

            $('.current_password_icon').click(function(){
                togglePasswordVisibility($(this), $(this).prev('input'));
            });

            $('.password_icon').click(function(){
                togglePasswordVisibility($(this), $(this).prev('input'));
            });

            $('.password_confirmation_icon').click(function(){
                togglePasswordVisibility($(this), $(this).prev('input'));
            });
        });
    </script>
@endpush
