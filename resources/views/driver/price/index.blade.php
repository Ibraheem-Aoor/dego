@extends('admin.layouts.app')
@section('page_title', __('Edit User'))
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="javascript:void(0)">@lang('My Prices')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Edit Prices')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('')</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('agent.company.view.profile', $user->id) }}">
                        <i class="bi-eye-fill me-1"></i> @lang('View Profile')
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-3">
                <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                    <div class="d-grid">
                        <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse"
                            data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false"
                            aria-controls="navbarVerticalNavMenu">
                            <span class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">@lang('Menu')</span>
                                <span class="navbar-toggler-default">
                                    <i class="bi-list"></i>
                                </span>
                                <span class="navbar-toggler-toggled">
                                    <i class="bi-x"></i>
                                </span>
                            </span>
                        </button>
                    </div>

                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings"
                            class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical"
                            data-hs-sticky-block-options='{
                             "parentSelector": "#navbarVerticalNavMenu",
                             "targetSelector": "#header",
                             "breakpoint": "lg",
                             "startPoint": "#navbarVerticalNavMenu",
                             "endPoint": "#stickyBlockEndPoint",
                             "stickyOffsetTop": 20
                           }'>
                            <li class="nav-item">
                                <a class="nav-link active" href="#content">
                                    <i class="bi-cash nav-icon"></i> @lang('Airport Price')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">
                    <form action="{{ route($base_route_path . 'update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="profile-cover">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title h4">@lang('Airport Price Rate information')</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <label for="firstNameLabel"
                                            class="col-sm-3 col-form-label form-label">@lang('From Airport')</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="number" class="form-control wid1" name="from_airport_price"
                                                    id="from_airport_price" value="{{ old('from_airport_price' , $user->from_airport_price) }}"
                                                    placeholder="e.g 50" aria-label="price">
                                                <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>

                                            </div>
                                            @error('from_airport_price')
                                                <span class="invalid-feedback d-inline">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="firstNameLabel"
                                            class="col-sm-3 col-form-label form-label">@lang('To Airport')</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="number" class="form-control wid1" name="to_airport_price"
                                                    id="to_airport_price" value="{{ old('to_airport_price' , $user->to_airport_price) }}"
                                                    placeholder="e.g 50" aria-label="price">
                                                <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>
                                            </div>
                                            @error('to_airport_price')
                                                <span class="invalid-feedback d-inline">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- End Card -->
                            <button type="submit" class="btn btn-primary w-100">@lang('Save')</button>

                    </form>



                </div>
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush
