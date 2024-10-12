@extends($theme.'layouts.user')
@section('title',trans('Notification Settings'))
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
                            <a class="nav-link" href="{{ route('user.change.password') }}"><i
                                    class="fa-light fa-key"></i>@lang('Password')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('user.notification.permission.list') }}"><i
                                    class="fa-light fa-link"></i>@lang('Notification')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.kyc.settings') }}"><i
                                    class="fa-light fa-link"></i>@lang('Identity Verification') </a>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('user.notification.permission') }}" method="post">
                    @csrf

                    <div class="account-settings-profile-section">
                        <div class="card">
                            <div class="card-header border-0">
                                <h5 class="card-title">@lang('Recent Devices')</h5>
                            </div>
                            <div class="card-body pt-0">
                                <p>@lang('We need permission from your browser to show notifications.') <strong>@lang('Request Permission')</strong>
                                </p>
                                <div class="cmn-table mt-20">
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th class="w1" scope="col">@lang('type')</th>
                                                <th class="w2" scope="col">✉️@lang('email')</th>
                                                <th class="w2" scope="col">🖥 @lang('browser')</th>
                                                <th class="w2" scope="col">🖥 @lang('sms')</th>
                                                <th class="w3" scope="col">👩🏻‍💻 @lang('app')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($notificationTemplates as $key => $item)
                                                <tr>
                                                    <td data-label="Type" class="text-center">
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ $item->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="✉️ Email">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="email_key[]"
                                                                   value="{{$item->template_key ?? ""}}"
                                                                   {{ !$item->email ? 'disabled':'' }}
                                                                   id="emailSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_email_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td data-label="🖥 Browser">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="sms_key[]"
                                                                   value="{{ $item->template_key ?? "" }}"
                                                                   {{ !$item->sms ? 'disabled' : '' }}
                                                                   id="pushSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_sms_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td data-label="🖥 Browser">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="push_key[]"
                                                                   value="{{ $item->template_key ?? "" }}"
                                                                   {{ !$item->push ? 'disabled' : '' }}
                                                                   id="pushSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_push_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>

                                                    <td data-label="👩🏻‍💻 App">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="in_app_key[]"
                                                                   value="{{$item->template_key ?? ""}}"
                                                                   id="appSwitch"
                                                                {{!$item->in_app ? 'disabled':''}}
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_in_app_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <th colspan="100%" class="text-center text-dark">
                                                        <div class="no_data_iamge text-center">
                                                            <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                                        </div>
                                                        <p class="text-center">@lang('Notification Template List is empty here!.')</p>
                                                    </th>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="cmn-btn mt-3">@lang('Save Changes')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
