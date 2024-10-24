<div class="profile-cover">
    <div class="profile-cover-img-wrapper">
        <img id="profileCoverImg" class="profile-cover-img" src="{{ asset('assets/admin/img/img1.jpg') }}"
             alt="Image Description"/>
    </div>
</div>

<div class="text-center mb-5">
    <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar"
           for="editAvatarUploaderModal">
        <img id="editAvatarImgModal" class="avatar-img"
             src="{{ getFile($user->image_driver, $user->image) }}" alt="Image Description"/>
        <span class="avatar-uploader-trigger"><i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i></span>
    </label>

    <h1 class="page-header-title">
        @lang($user->firstname. ' ' . $user->lastname)
        @if($user->email_verification && $user->sms_verification)
            <i class="bi-patch-check-fill fs-2 text-primary" data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Verified Profile"></i>
        @endif
    </h1>

    <ul class="list-inline list-px-2">
        @if(isset($user->country))
            <li class="list-inline-item">
                <i class="bi-geo-alt me-1"></i>
                @if($user->city)
                    <span>@lang($user->city),</span>
                @endif
                <span>@lang($user->country)</span>
            </li>
        @endif

        <li class="list-inline-item">
            <i class="bi-calendar-week me-1"></i>
            <span>{{ 'Joined ' . dateTime($user->created_at, 'M Y') }}</span>
        </li>
    </ul>
</div>

<div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
                <span class="hs-nav-scroller-arrow-prev display-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:void(0)">
                        <i class="bi-chevron-left"></i>
                    </a>
                </span>

    <span class="hs-nav-scroller-arrow-next display-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:void(0)">
                        <i class="bi-chevron-right"></i>
                    </a>
                </span>

    <ul class="nav nav-tabs align-items-center">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs($base_route_path.'view.profile') ? 'active' : '' }}"
               href="{{ route($base_route_path.'view.profile', ['id' => $user->id , 'model' => $base_model_name]) }}">@lang('Profile')</a>
        </li>

        <li class="nav-item ms-auto">
            <div class="d-flex gap-2">
                <a class="btn btn-white btn-sm" href="{{ route($base_route_path.'edit', ['id' => $user->id , 'model' => $base_model_name]) }}"> <i
                        class="bi-person-plus-fill me-1"></i> @lang('Edit profile') </a>
                <div class="dropdown nav-scroller-dropdown">
                    <button type="button" class="btn btn-white btn-icon btn-sm" id="profileDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-three-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="profileDropdown">
                        <span class="dropdown-header">@lang('Settings')</span>
                        <a class="dropdown-item" href="{{ route($base_route_path.'send.email', ['id' => $user->id , 'model' => $base_model_name]) }}"> <i
                                class="bi-envelope dropdown-item-icon"></i> @lang('Send Mail') </a>
                        <a class="dropdown-item blockProfile" href="javascript:void(0)"
                           data-route="{{ route($base_route_path.'block.profile', ['id' => $user->id , 'model' => $base_model_name]) }}"
                           data-bs-toggle="modal" data-bs-target="#blockProfileModal">
                            <i class="bi-person dropdown-item-icon"></i> @lang('Block Profile') </a>
                        <a class="dropdown-item loginAccount d-none" href="javascript:void(0)"
                           data-route="{{ route('admin.login.as.user', ['id' => $user->id , 'model' => $base_model_name]) }}"
                           data-bs-toggle="modal" data-bs-target="#loginAsUserModal">
                            <i class="bi bi-box-arrow-in-right dropdown-item-icon"></i>
                            @lang('Login As User')
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

@push("script")
    <script>
        "use script";
        $(document).on('click', '.addBalance', function () {
            $('.setBalanceRoute').attr('action', $(this).data('route'));
            $('.user-balance').text($(this).data('balance'));
        })
    </script>
@endpush