@extends($theme.'layouts.user')
@section('title',__('2 Step Security'))

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('2 Step Security')</li>
                </ol>
            </nav>
        </div>
        <div class="row ms-1">
            @if(auth()->user()->two_fa ==1)
                <div class="col-lg-6 col-md-6 mb-3 coin-box-wrapper">
                    <div class="card text-center py-2 two-factor-authenticator">
                        <h3 class="card-title golden-text">@lang('Two Factor Authenticator')</h3>
                        <div class="card-body">
                            <div class="box refferal-link">
                                <div class="password-box mt-0">
                                    <input
                                        type="text"
                                        value="{{$secret}}"
                                        class="form-control"
                                        id="referralURL"
                                        readonly
                                    />
                                    <button class="gold-btn copytext password-icon" id="copyBoard" onclick="copyFunction()"><i class="fal fa-copy"></i></button>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center py-4">
                                    <img src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{$qrCodeUrl}}" alt="QR Code">
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="cmn-btn"
                                   data-bs-toggle="modal" data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-6 col-md-6 mb-3 coin-box-wrapper">
                    <div class="card text-center py-2 two-factor-authenticator">
                        <h3 class="card-title golden-text mt-4">@lang('Two Factor Authenticator')</h3>
                        <div class="card-body">
                            <div class="box refferal-link">
                                <div class="password-box mt-0">
                                    <input
                                        type="text"
                                        value="{{$secret}}"
                                        class="form-control"
                                        id="referralURL"
                                        readonly
                                    />
                                    <button class="gold-btn copytext password-icon" id="copyBoard" onclick="copyFunction()"><i class="fal fa-copy"></i></button>
                                </div>
                            </div>

                            <div class="form-group mx-auto text-center py-4">
                                <img src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{$qrCodeUrl}}" alt="QR Code">
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="cmn-btn"
                                   data-bs-toggle="modal"
                                   data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                            </div>
                        </div>

                    </div>
                </div>

            @endif


            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card text-center py-2 two-factor-authenticator h-100">
                        <h3 class="card-title golden-text pt-4">@lang('Google Authenticator')</h3>
                    <div class="card-body">

                        <h6 class="text-uppercase my-3">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h6>

                        <p class="py-3">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                        <a class=" cmn-btn btn-md mt-3"
                           href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                           target="_blank">@lang('DOWNLOAD APP')</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enable Modal -->
        <div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="planModalLabel">@lang('Verify Your OTP')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <form action="{{route('user.twoStepEnable')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                                <div class="row g-4">
                                    <div class="input-box col-12">
                                        <input type="hidden" name="key" value="{{$secret}}">
                                        <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                            <button class="cmn-btn" type="submit">@lang('Verify')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Disable Modal -->
        <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="planModalLabel">@lang('Verify Your OTP to Disable')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <form action="{{route('user.twoStepDisable')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="input-box col-12">
                                    <input type="password" class="form-control" name="password" placeholder="@lang('Enter Your Password')">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                            <button class="cmn-btn" type="submit">@lang('Verify')</button>
                        </div>
                    </form>
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
        function copyFunction() {
            let copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush

