@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('dashboard')</li>
                </ol>
            </nav>
        </div>
        <div class="section dashboard">

            @include(template().'user.partials.dashboard.top')
            @include(template().'user.partials.dashboard.favouriteList')

        </div>
    </main>
    @include(template().'user.partials.dashboard.modal')
    @include(template().'user.partials.dashboard.offcanvas')


@endsection
