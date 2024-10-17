@extends('admin.layouts.app')
@section('page_title', __('Add User'))
@section('content')
    <div class="content container-fluid">
        <form class="js-step-form py-md-5"
            data-hs-step-form-options='{
              "progressSelector": "#addUserStepFormProgress",
              "stepsSelector": "#addUserStepFormContent",
              "endSelector": "#addUserFinishBtn",
              "isValidate": false
            }'
            action="{{ route('admin.agents.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-lg-center">
                <div class="col-lg-8">
                    <ul id="addUserStepFormProgress"
                        class="js-step-progress step step-sm step-icon-sm step step-inline step-item-between mb-3 mb-md-5">
                        <li class="step-item">
                            <a class="step-content-wrapper " href="javascript:void(0)"
                                data-hs-step-form-next-options='{
                                    "targetSelector": "#addUserStepProfile"
                                  }'>
                                <span class="step-icon step-icon-soft-dark">1</span>
                                <div class="step-content">
                                    <span class="step-title">@lang('Profile')</span>
                                </div>
                            </a>
                        </li>
                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:void(0);"
                                data-hs-step-form-next-options='{
                                    "targetSelector": "#addUserStepConfirmation"
                                  }'>
                                <span class="step-icon step-icon-soft-dark">2</span>
                                <div class="step-content">
                                    <span class="step-title">@lang('Confirmation')</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div id="addUserStepFormContent">
                        <div id="addUserStepProfile" class="card card-lg active">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label form-label">@lang('Profile Image')</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex align-items-center">
                                            <label class="avatar avatar-xl avatar-circle avatar-uploader me-5"
                                                for="avatarUploader">
                                                <img id="avatarImg" class="avatar-img"
                                                    src="{{ asset('assets/admin/img/img-profile-avatar.jpg') }}"
                                                    alt="Image Description">
                                                <input type="file" class="js-file-attach avatar-uploader-input"
                                                    name="image" id="avatarUploader"
                                                    data-hs-file-attach-options='{
                                                        "textTarget": "#avatarImg",
                                                        "mode": "image",
                                                        "targetAttr": "src",
                                                        "resetTarget": ".js-file-attach-reset-img",
                                                        "resetImg": "{{ asset('assets/admin/img/img-profile-avatar.jpg') }}",
                                                        "allowTypes": [".png", ".jpeg", ".jpg"]
                                                     }'>
                                                <span class="avatar-uploader-trigger">
                                                    <i class="bi-pencil avatar-uploader-icon shadow-sm"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="firstNameLabel"
                                        class="col-sm-3 col-form-label form-label">@lang('Name')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control input-field" name="name"
                                            id="firstNameLabel" placeholder="Name" aria-label="Name"
                                            data-target=".full_name" value="{{ old('name') }}" autocomplete="off">
                                        @error('name')
                                            <span class="invalid-feedback d-inline">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <label for="userNameLabel"
                                        class="col-sm-3 col-form-label form-label">@lang('Username')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="username" id="userNameLabel"
                                            value="{{ old('username') }}" placeholder="@lang('Username')"
                                            aria-label="@lang('Username')" autocomplete="off">
                                        @error('username')
                                            <span class="invalid-feedback d-inline">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="emailLabel"
                                        class="col-sm-3 col-form-label form-label">@lang('Email')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" id="emailLabel"
                                            placeholder="@lang('Email')" aria-label="@lang('Email')"
                                            autocomplete="off" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="phoneLabel"
                                        class="col-sm-3 col-form-label form-label">@lang('Phone')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="js-input-mask form-control" name="phone"
                                            id="phoneLabel" placeholder="Phone" aria-label="Phone"
                                            value="{{ old('phone') }}" autocomplete="off">
                                        @error('phone')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="locationLabel"
                                        class="col-sm-3 col-form-label form-label">@lang('Country')</label>
                                    <div class="col-sm-9">
                                        <div class="tom-select-custom mb-4">
                                            <select class="js-select form-select" id="locationLabel" name="country">
                                                <option value="country">@lang('Select Country')</option>
                                                @forelse($allCountry as $country)
                                                    <option value="{{ $country['name'] }}"
                                                        {{ old('country') == $country['name'] ? 'selected' : '' }}
                                                        data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ asset($country['flag']) }}" alt="Flag" /><span class="text-truncate">{{ $country['name'] }}</span></span>'>
                                                        @lang($country['name'])
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('country')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>




                                <label class="row form-check form-switch mb-4" for="userStatusSwitch">
                                    <span class="col-8 col-sm-3 ms-0">
                                        <span class="d-block text-dark">@lang('Status')</span>
                                    </span>
                                    <span class="col-4 col-sm-3">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="form-check-input" name="status"
                                            id="userStatusSwitch" value="1" checked>
                                    </span>
                                </label>
                                @error('status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-primary nextButton"
                                    data-hs-step-form-next-options='{
                                    "targetSelector": "#addUserStepConfirmation"
                                  }'>
                                    @lang('Next') <i class="bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <div id="addUserStepConfirmation" class="card card-lg">
                            <div class="profile-cover">
                                <div class="profile-cover-img-wrapper">
                                    <img class="profile-cover-img" src="{{ asset('assets/admin/img/img1.jpg') }}"
                                        alt="Image Description">
                                </div>
                            </div>

                            <div class="avatar avatar-xxl avatar-circle avatar-border-lg profile-cover-avatar">
                                <img class="avatar-img" src="{{ asset('assets/admin/img/img-profile-avatar.jpg') }}"
                                    alt="Image Description">
                            </div>

                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-6 text-sm-end mb-2">@lang('Name:')</dt>
                                    <dd class="col-sm-6 full_name">-</dd>

                                    <dt class="col-sm-6 text-sm-end mb-2">@lang('Username:')</dt>
                                    <dd class="col-sm-6 username">-</dd>

                                    <dt class="col-sm-6 text-sm-end mb-2">@lang('Email:')</dt>
                                    <dd class="col-sm-6 email">-</dd>

                                    <dt class="col-sm-6 text-sm-end mb-2">@lang('Phone:')</dt>
                                    <dd class="col-sm-6 phone">-</dd>
                                    <dt class="col-sm-6 text-sm-end mb-2">@lang('Country:')</dt>
                                    <dd class="col-sm-6 country">-</dd>


                                </dl>
                            </div>

                            <div class="card-footer d-sm-flex align-items-sm-center">
                                <button type="button" class="btn btn-ghost-secondary mb-2 mb-sm-0"
                                    data-hs-step-form-prev-options='{
                                           "targetSelector": "#addUserStepProfile"
                                         }'>
                                    <i class="bi-chevron-left"></i> @lang('Previous step')
                                </button>
                                <div class="ms-auto">
                                    <button id="addUserFinishBtn" type="submit"
                                        class="btn btn-primary addUserBtn">@lang('Add user')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-step-form.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-add-field.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
@endpush


@push('script')
    <script>
        "use strict";
        $(document).on('change', '#avatarUploader', function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarImg').attr('src', e.target.result);
                    $('.profile-cover-avatar .avatar-img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });


        function updateFullName() {
            let firstName = $('#firstNameLabel').val();
            let fullName = firstName;
            $('.full_name').text(fullName);

            let add = $('.addUserBtn');
            if (firstName.trim() === '') {
                add.prop('disabled', true);
            } else {
                add.prop('disabled', false);
            }
        }

        $(document).on("input", "#firstNameLabel", updateFullName);
        updateFullName();


        function updateEmailText() {
            let emailValue = $("#emailLabel").val();
            $('.email').text(emailValue);
            let add = $('.addUserBtn');
            if (emailValue.trim() === '') {
                add.prop('disabled', true);
            } else {
                add.prop('disabled', false);
            }
        }
        $(document).on("input", "#emailLabel", updateEmailText);
        updateEmailText();

        function updateUsernameText() {
            let userNameValue = $("#userNameLabel").val();
            let add = $('.addUserBtn');
            if (userNameValue.trim() === '') {
                add.prop('disabled', true);
            } else {
                add.prop('disabled', false);
            }
            $('.username').text(userNameValue);
        }

        $(document).on("input", "#userNameLabel", updateUsernameText);
        updateUsernameText();

        function updatePhoneText() {
            let phoneValue = $("#phoneLabel").val();
            let add = $('.addUserBtn');
            if (phoneValue.trim() === '') {
                add.prop('disabled', true);
            } else {
                add.prop('disabled', false);
            }
            $('.phone').text(phoneValue);
        }

        $(document).on("input", "#phoneLabel", updatePhoneText);
        updatePhoneText();


        $(document).on("change", "#locationLabel", function() {
            let countryValue = $("#locationLabel").val();
            let add = $('.addUserBtn');
            if (countryValue.trim() === '') {
                add.prop('disabled', true);
            } else {
                add.prop('disabled', false);
            }
            $('.country').text(countryValue);
        });



        $(document).ready(function() {
            new HSStepForm('.js-step-form', {
                finish: () => {
                    document.getElementById("addUserStepFormProgress").style.display = 'none'
                    document.getElementById("addUserStepProfile").style.display = 'none'
                    document.getElementById("addUserStepConfirmation").style.display = 'none'
                    scrollToTop('#header');
                    const formContainer = document.getElementById('formContainer')
                },
                onNextStep: function() {
                    scrollToTop()
                },
                onPrevStep: function() {
                    scrollToTop()
                }
            })

            function scrollToTop(el = '.js-step-form') {
                el = document.querySelector(el)
                window.scrollTo({
                    top: (el.getBoundingClientRect().top + window.scrollY) - 30,
                    left: 0,
                    behavior: 'smooth'
                })
            }

            new HSAddField('.js-add-field', {
                addedField: field => {
                    HSCore.components.HSTomSelect.init(field.querySelector('.js-select-dynamic'))
                    HSCore.components.HSMask.init(field.querySelector('.js-input-mask'))
                }
            })

            HSCore.components.HSTomSelect.init('.js-select', {
                render: {
                    'option': function(data, escape) {
                        return data.optionTemplate || `<div>${data.text}</div>>`
                    },
                    'item': function(data, escape) {
                        return data.optionTemplate || `<div>${data.text}</div>>`
                    }
                },
                maxOptions: 250
            })

        });
    </script>
@endpush
