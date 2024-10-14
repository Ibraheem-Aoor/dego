@extends('admin.layouts.app')
@section('page_title',__('View Profile'))
@section('content')

    <!-- Content -->
    <div class="content container-fluid">
        <div class="row justify-content-lg-center">
            <div class="col-lg-10">

                @include('admin.agent_management.components.header_user_profile')

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3 mb-lg-5">
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">@lang('Profile')</h4>
                            </div>

                            <div class="card-body">
                                <ul class="list-unstyled list-py-2 text-dark mb-0">
                                    <li class="pb-0"><span class="card-subtitle">@lang('About')</span></li>
                                    <li>
                                        <i class="bi-person dropdown-item-icon"></i> @lang($user->name)
                                    </li>
                                    <li><i class="bi-briefcase dropdown-item-icon"></i> @lang('@' . $user->username)
                                    </li>
                                    @if(isset($user->country))
                                    <li><i class="bi-geo-alt dropdown-item-icon"></i> @lang($user->country)</li>
                                    @endif


                                    <li class="pt-4 pb-0"><span class="card-subtitle">@lang('Contacts')</span></li>
                                    <li>
                                        <i class="bi-at dropdown-item-icon"></i> {{ $user->email }}
                                        <i
                                            class="bi-patch-check-fill text-{{ $user->email_verification == 1 ? 'success' : 'danger' }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            aria-label="{{ $user->email_verification == 1 ? 'Email Verified' : 'Email Unverified' }}"
                                            data-bs-original-title="{{ $user->email_verification == 1 ? 'Email Verified' : 'Email Unverified' }}">
                                        </i>
                                    </li>
                                    <li><i class="bi-phone dropdown-item-icon"></i> {{ $user->phone }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card -->
                    </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.user_management.components.login_as_user')
    @include('admin.user_management.components.block_profile_modal')

@endsection


@push('script')
    <script>
        'use strict';
        $(document).on('click', '.loginAccount', function () {
            let route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });

        $(document).on('click', '.blockProfile', function () {
            let route = $(this).data('route');
            $('.blockProfileAction').attr('action', route)
        });

    </script>
@endpush







