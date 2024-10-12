@extends($theme.'layouts.user')
@section('title',trans('Favourite List'))
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1 text-capitalize">@lang('dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize"
                                                   href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang('Favourite List')</li>
                </ol>
            </nav>
        </div>
        <div class="card mt-50">
            <div class="card-header d-flex justify-content-between border-0">
                <h4>@lang('Favourite List')</h4>
                <div class="btn-area">
                    <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                            class="fa-regular fa-filter"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL No.')</th>
                                <th scope="col">@lang('Package')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Added At')</th>
                                <th class="text-capitalize" scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($favouriteList as $item)
                                <tr>
                                    <td data-label="@lang('Serial')"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></td>
                                    <td data-label="@lang('Package')">
                                        <a href="{{ route('package.details', optional($item->package)->slug)}}">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                <img class="favouriteImage"
                                                     src="{{ getFile(optional($item->package)->thumb_driver, optional($item->package)->thumb) }}"/>
                                                <p class="mb-0">@lang(optional($item->package)->title)</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td data-label="@lang('Package') Title"><span>{{ currencyPosition(optional($item->package)->adult_price) }}</span></td>
                                    <td data-label="@lang('Added At')"><span>{{ dateTime($item->created_at) }}</span></td>
                                    <td  data-label="@lang('Action')">
                                        <a class="btn btn-outline-light btn-sm text-dark"
                                           href="{{ route('package.details', optional($item->package)->slug)}}"
                                        > <i class="fa-regular fa-eye"></i> @lang('Details')
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="100%" class="text-center text-dark">
                                        <div class="no_data_iamge text-center">
                                            <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                        </div>
                                        <p class="text-center">@lang('Favourite List is empty here!.')</p>
                                    </th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $favouriteList->appends(request()->query())->links($theme.'partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include(template().'user.favouriteList.offcanvas')
@endsection
