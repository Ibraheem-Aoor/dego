@extends($theme.'layouts.user')
@section('title',trans('Profile'))
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
        <!-- End Page Title -->

        <div class="section dashboard">
            <div class="row">
                <div class="account-settings-navbar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('user.profile') }}"><i
                                    class="fa-light fa-user"></i>@lang('profile')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.change.password') }}"><i
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
                <!-- Account settings navbar end -->
                <div class="account-settings-profile-section">
                    <div class="card">
                        <form action="{{ route('user.profile.update.image') }}"  method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                            <h5 class="card-title">@lang('Profile Details')
                            </h5>
                            <div class="profile-details-section">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="image-area">
                                        <img id="previewImage" src="{{ getFile(Auth::user()->image_driver, Auth::user()->image) }}" alt="{{ auth()->user()->firstname .' '.auth()->user()->lastname }}">
                                    </div>
                                    <div class="btn-area">
                                        <div class="btn-area-inner d-flex">
                                            <div class="cmn-file-input">
                                                <label for="formFile" class="form-label"><i class="fa-regular fa-camera pe-2"></i>@lang('Select')</label>
                                                <input class="form-control"
                                                       type="file"
                                                       id="formFile"
                                                       name="image"
                                                       accept="image/*"
                                                       onchange="previewFile()"
                                                >
                                            </div>
                                            <button type="submit" class="cmn-btn3">@lang('Upload')</button>
                                        </div>
                                        <small>@lang('Allowed JPG, GIF or PNG. Max size of 4Mb')</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <form action="{{ route('user.profile.update') }}"  method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body pt-0">
                                <div class="profile-form-section">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstname" class="form-label">@lang('First Name')</label>
                                            <input type="text" class="form-control" value="{{ old('lname', auth()->user()->firstname)  }}" name="fname" id="firstname">

                                            @error('fname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname" class="form-label">@lang('Last Name')</label>
                                            <input type="text" class="form-control" value="{{ old('lname', auth()->user()->lastname)  }}" name="lname" id="lastname">

                                            @error('lname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="e-mail" class="form-label">@lang('Email Address')</label>
                                            <input type="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" name="email" id="e-mail">

                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 regItem">
                                            <label for="telephone" class="form-label">@lang('Phone Number')</label>
                                            <input id="telephone" class="form-control phoneInput" name="phone" value="{{ old('phone', auth()->user()->phone) }}" type="tel">
                                            <input type="hidden" name="code" id="phoneCode" />
                                            <input type="hidden" name="country" id="countryName" />
                                            <input type="hidden" name="countryCode" id="countryCode" />
                                            @error('phone')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">@lang('Full Address')</label>
                                            <input type="text" class="form-control" value="{{ old('address', auth()->user()->address_one) }}" name="address" id="address">
                                            @error('address')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="zipcode" class="form-label">@lang('Zip Code')</label>
                                            <input type="text" class="form-control" value="{{ old('zipcode', auth()->user()->zip_code)  }}" name="zipcode" id="zipcode">
                                            @error('zipcode')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">@lang('Language')</label>
                                            <select class="cmn-select2-dropdown" name="language">
                                                <option value="">@lang('Select Language')</option>
                                                @foreach($languages as $item)
                                                    <option value="{{ $item->id }}" {{ ( auth()->user()->language_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('language')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">@lang('Country')</label>
                                            <select id="country" class="cmn-select2-dropdown" name="country">
                                                <option value="">@lang('Select')</option>
                                                @foreach($countries as $item)
                                                    <option value="{{ $item->id }}" {{ ( auth()->user()->country == $item->name) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state" class="form-label">@lang('State')</label>
                                            <select class="cmn-select2-dropdown" name="state" id="state">
                                                <option value="{{ old('state', auth()->user()->state) }}" {{ ( auth()->user()->state ) ? 'selected' : '' }}>@lang(auth()->user()->state)</option>
                                            </select>
                                            @error('state')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="city" class="form-label">@lang('City')</label>
                                            <select class="cmn-select2-dropdown" name="city" id="city">
                                                <option value="{{ old('city', auth()->user()->city) }}" {{ ( auth()->user()->city ) ? 'selected' : '' }}>@lang(auth()->user()->city)</option>
                                            </select>
                                            @error('city')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-8">
                                            <label for="about" class="form-label">@lang('About Me')</label>
                                            <textarea
                                                    class="form-control"
                                                    name="about"
                                                    cols="30"
                                                    rows="5"
                                                    id="about"
                                            >{{ old('about', auth()->user()->about_me)  }}</textarea>
                                            @error('about')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="btn-area d-flex g-3">
                                        <button type="submit" class="cmn-btn save_button">@lang('Save Changes')</button>
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
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/intlTelInput.min.css') }}">
    <style>
        .iti{
            width: 100% !important;
        }
        .input-group-text{
            height: 44px !important;
        }
        .save_button{
             margin-right: 10px;
         }
        .regItem .phoneInput{
            padding-left: 95px !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/intlTelInput.min.js')}}"></script>
    <script>
        const input = document.querySelector("#telephone");
        const iti = window.intlTelInput(input, {
            initialCountry: "bd",
            separateDialCode: true,
        });
        input.addEventListener("countrychange", updateCountryInfo);
        updateCountryInfo();
        function updateCountryInfo() {
            const selectedCountryData = iti.getSelectedCountryData();
            const phoneCode = '+' + selectedCountryData.dialCode;
            const countryCode = selectedCountryData.iso2;
            const countryName = selectedCountryData.name;
            $('#phoneCode').val(phoneCode);
            $('#countryCode').val(countryCode);
            $('#countryName').val(countryName);
        }

        const initialPhone = "{{ old('phone', auth()->user()->phone) }}";
        const initialPhoneCode = "{{ old('phone_code', auth()->user()->phone_code) }}";
        const initialCountryCode = "{{ old('country_code', auth()->user()->country_code) }}";
        const initialCountry = "{{ old('country', auth()->user()->country) }}";

        initialPhoneCode ? iti.setNumber(initialPhoneCode) : null;
        initialCountryCode ? iti.setNumber(initialCountryCode) : null;
        initialCountry ? iti.setNumber(initialCountry) : null;
        initialPhone ? iti.setNumber(initialPhone) : null;

        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
        $(document).ready(function(){
            $('#country').on('change', function () {
                let idCountry = this.value;
                $("#state").html('');
                $.ajax({
                    url: "{{route('user.fetch.state')}}",
                    type: "POST",
                    data: {
                        "country_id": idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
            $('#state').on('change', function () {
                let idState = this.value;
                $("#city").html('');
                $.ajax({
                    url: "{{route('user.fetch.city')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endpush


