@extends('admin.layouts.app')
@section('page_title', __('Page SEO'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Frontend')</li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Page SEO')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Page SEO')</h1>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title h4">@lang('Edit SEO Meta')</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.page.seo.update', $pageSEO->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="PageTitleLabel" class="form-label">@lang('Page Title')</label>
                                        <input type="text"
                                               class="form-control @error('page_title') is-invalid @enderror"
                                               name="page_title" id="PageTitleLabel"
                                               placeholder="@lang("Page Title")" aria-label="@lang("Page Title")"
                                               value="{{ old('page_title', $pageSEO->page_title) }}" autocomplete="off">
                                        @error('page_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="SeoTitleLabel" class="form-label">@lang('Meta Title')</label>
                                        <input type="text"
                                               class="form-control @error('meta_title') is-invalid @enderror"
                                               name="meta_title" id="SeoTitleLabel"
                                               placeholder="@lang("Meta Title")" aria-label="@lang("Meta Title")"
                                               value="{{ old('meta_title', $pageSEO->meta_title) }}">
                                        @error('meta_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label for="metaKeywordLabel" class="form-label">@lang('Meta Keywords')</label>
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" name="meta_keywords[]"
                                                    autocomplete="off" multiple
                                                    data-hs-tom-select-options='{
                                                        "create": true,
                                                        "placeholder": "Meta Keywords"
                                                    }'>
                                                @if($pageSEO->meta_keywords)
                                                    @foreach($pageSEO->meta_keywords as $key => $data)
                                                        <option value="@lang($data)" selected>@lang($data)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error("meta_keywords")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-4">
                                        <label for="metaDescription"
                                               class="form-label">@lang('Meta Description')</label>
                                        <textarea id="metaDescription" class="form-control" name="meta_description" placeholder="@lang("Meta Description")" rows="5">{{ old("meta_description", $pageSEO->meta_description) }}
                                        </textarea>
                                        @error('meta_description')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <label for="ogDescription"
                                               class="form-label">@lang('OG Description')</label>
                                        <textarea id="ogDescription" class="form-control" name="og_description" placeholder="@lang("OG Description")" rows="4">{{ old("og_description", $pageSEO->og_description) }}</textarea>
                                        @error('og_description')
                                        <span class="invalid-feedback d-block">{{ $message }}</span >
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label">@lang("Meta Robots")</label>
                                    <div class="tom-select-custom tom-select-custom-with-tags">
                                        <select class="js-select form-select meta-robot-select2" autocomplete="off"
                                                name="meta_robots[]" multiple
                                                data-hs-tom-select-options='{
                                                    "placeholder": "Select Meta Robots"
                                                  }'>
                                            <option
                                                value="index" {{ in_array("index", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('Index')
                                            </option>
                                            <option
                                                value="noindex" {{ in_array("noindex", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('No index')
                                            </option>
                                            <option
                                                value="follow" {{ in_array("follow", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('Follow')
                                            </option>
                                            <option
                                                value="nofollow" {{ in_array("nofollow", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('No follow')
                                            </option>
                                            <option
                                                value="noarchive" {{ in_array("noarchive", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('No archive')
                                            </option>
                                            <option
                                                value="nosnippet" {{ in_array("nosnippet", $pageSEO->metaRobots()) ? 'selected' : '' }}>
                                                @lang('No snippet')
                                            </option>
                                        </select>
                                    </div>
                                    <!-- End Select -->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <label class="form-label">@lang("Meta Image")</label>
                                        <label class="form-check form-check-dashed" for="imageUploader">
                                            <img id="SeoImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($pageSEO->meta_image_driver, $pageSEO->meta_image, true) }}"
                                                 alt="Image Description" data-hs-theme-appearance="default">
                                            <img id="SeoImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($pageSEO->meta_image_driver, $pageSEO->meta_image, true) }}"
                                                 alt="Image Description" data-hs-theme-appearance="dark">
                                            <span class="d-block">@lang("Browse your file here")</span>
                                            <input type="file" class="js-file-attach form-check-input"
                                                   id="imageUploader" name="meta_image"
                                                   data-hs-file-attach-options='{
                                                  "textTarget": "#SeoImg",
                                                  "mode": "image",
                                                  "targetAttr": "src",
                                                  "allowTypes": [".png", ".jpeg", ".jpg", ".json"]
                                               }'>
                                        </label>
                                        @error('meta_image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">@lang('Save changes')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSTomSelect.init('.js-select')
        })
    </script>
@endpush
