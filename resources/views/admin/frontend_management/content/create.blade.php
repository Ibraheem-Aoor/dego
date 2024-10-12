@extends('admin.layouts.app')
@section('page_title', __('Manage Content'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <h1 class="page-header-title">@lang('Create ' . stringToTitle($content) . ' Item')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Manage Content')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang(stringToTitle($content))</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if($multipleContent)
            <div>
                <ul class="nav nav-segment mb-2" role="tablist">
                    @foreach($languages as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link @error('errActive') @if($language->id == $message) active @endif @else @if($loop->first) active @endif  @enderror"
                               id="nav-one-eg1-tab"
                               href="#nav-one-{{ $key }}"
                               data-bs-toggle="pill"
                               data-bs-target="#nav-one-{{ $key }}"
                               role="tab" aria-controls="nav-one-{{ $key }}"
                               aria-selected="@error('errActive') @if($language->id == $message) true @else false @endif @else @if($loop->first) true @else false @endif  @enderror">
                                @lang($language->name)
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content">
                @foreach($languages as $key => $language)
                    <div
                        class="tab-pane fade @error('errActive') @if($language->id == $message) show active @endif @else @if($loop->first) show active @endif  @enderror"
                        id="nav-one-{{ $key }}"
                        role="tabpanel" aria-labelledby="nav-one-{{ $key }}-tab">
                        <div class="row justify-content-lg-center">
                            <form action="{{ route('admin.content.multiple.store', [$content, $language->id]) }}"
                                  enctype="multipart/form-data"
                                  method="post">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="card card-lg mb-3 mb-lg-5">
                                        <div class="card-body">
                                            @foreach($multipleContent['field_name'] as $name => $type)
                                                <div class="row justify-content-md-between">
                                                    @if($type == "text")
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                   for="@lang($name)">@lang(stringToTitle($name))
                                                            </label>
                                                            <input type="@lang($type)" id="@lang($name)"
                                                                   name="{{ $name }}[{{ $language->id }}]"
                                                                   class="form-control @error($name.'.'.$language->id) is-invalid @enderror"
                                                                   value="{{ old($name.'.'.$language->id) }}"
                                                                   placeholder="@lang(stringToTitle($name))" autocomplete="off">
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                    @if($type == "date" && $language->default_status == 1)
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                   for="@lang($name)">@lang(stringToTitle($name))
                                                            </label>
                                                            <input type="text"
                                                                   class="js-flatpickr form-control flatpickr-custom @error($name.'.'.$language->id) is-invalid @enderror"
                                                                   name="{{ $name }}[{{ $language->id }}]"
                                                                   value="{{ old($name.'.'.$language->id) }}"
                                                                   placeholder="Select dates"
                                                                   data-hs-flatpickr-options='{
                                                                     "dateFormat": "d/m/Y",
                                                                     "enableTime": false
                                                                   }'>
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    @if($type == "textarea")
                                                        <div class="col-md-12 mb-4">
                                                            <label class="form-label">
                                                                @lang(stringToTitle($name))
                                                            </label>
                                                            <textarea
                                                                class="summernote @error($name.'.'.$language->id) is-invalid @enderror"
                                                                name="{{ $name }}[{{ $language->id }}]">{{ old($name.'.'.$language->id) }}
                                                            </textarea>
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    @if($type == "number" && $language->default_status == 1)
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                   for="@lang($name)">@lang(stringToTitle($name))</label>
                                                            <input type="@lang($type)" id="@lang($name)"
                                                                   name="{{ $name }}[{{ $language->id }}]"
                                                                   class="form-control @error($name.'.'.$language->id) is-invalid @enderror"
                                                                   value="{{ old($name.'.'.$language->id) }}"
                                                                   placeholder="@lang(stringToTitle($name))">
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    @if($type == "url" && $language->default_status == 1)
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                   for="@lang($name)">@lang(stringToTitle($name))</label>
                                                            <input type="@lang($type)" id="@lang($name)"
                                                                   name="{{ $name }}[{{ $language->id }}]"
                                                                   value="{{ old($name.'.'.$language->id) }}"
                                                                   class="form-control @error($name.'.'.$language->id) is-invalid @enderror"
                                                                   placeholder="@lang(stringToTitle($name))">
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                    @if($type == 'icon' && $language->default_status == 1 )
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="{{ $name }}">@lang(stringToTitle($name))</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="{{ $name }}[{{ $language->id }}]"
                                                                           class="form-control icon @error($name.'.'.$language->id) is-invalid @enderror"
                                                                           value="{{ old($name.'.'.$language->id, isset($singleContentData[$language->id]) ? @$singleContentData[$language->id][0]->content->media->{$name} : '') }}">
                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-outline-primary iconPicker"
                                                                                data-icon="{{ old($name.'.'.$language->id, isset($singleContentData[$language->id]) ? @$singleContentData[$language->id][0]->content->media->{$name} : '') }}"
                                                                                role="iconpicker"></button>
                                                                    </div>

                                                                    <div class="invalid-feedback">
                                                                        @error($name.'.'.$language->id) @lang($message)
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($type == "file" && $language->default_status == 1)

                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                   for="@lang($name)">@lang(stringToTitle($name))</label>
                                                            <label class="form-check form-check-dashed" for="logoUploader{{$loop->index}}" id="content_img">
                                                                <img id="contentImg{{ $loop->index }}"
                                                                     class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                     src="{{ asset("assets/admin/img/oc-browse-file.svg") }}"
                                                                     alt="Image Description" data-hs-theme-appearance="default">
                                                                <img id="contentImg{{$loop->index}}"
                                                                     class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                     src="{{ asset("assets/admin/img/oc-browse-file-light.svg") }}"
                                                                     alt="Image Description" data-hs-theme-appearance="dark">
                                                                <span class="d-block">@lang("Browse your file here")</span>
                                                                <input type="file" class="js-file-attach form-check-input" name="{{ $name }}"
                                                                       id="logoUploader{{$loop->index}}" data-hs-file-attach-options='{
                                                                      "textTarget": "#contentImg{{$loop->index}}",
                                                                      "mode": "image",
                                                                      "targetAttr": "src",
                                                                      "allowTypes": [".png", ".jpeg", ".jpg"]
                                                                   }'>
                                                            </label>
                                                            @error($name.'.'.$language->id)
                                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                </div>
                                            @endforeach
                                            <div class="d-flex justify-content-start align-items-center gap-3 mt-4">
                                                <button type="submit"
                                                        class="btn btn-primary">@lang('Save changes')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker-iconset-all.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker-iconset-all.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {

            new HSFileAttach('.js-file-attach')
            HSCore.components.HSFlatpickr.init('.js-flatpickr')

            $('.summernote').summernote({
                height: 200,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
            $('.iconPicker').iconpicker({
                align: 'center', // Only in div tag
                arrowClass: 'btn-danger',
                arrowPrevIconClass: 'fas fa-angle-left',
                arrowNextIconClass: 'fas fa-angle-right',
                cols: 10,
                footer: true,
                header: true,
                icon: 'fas fa-bomb',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search icon',
                selectedClass: 'btn-success',
                unselectedClass: ''
            }).on('change', function (e) {
                $(this).parent().siblings('.icon').val(`${e.icon}`);
            }).on('dblclick', function() {
                $('.dropdown').removeClass('show'); // Close the dropdown
            });

        });
    </script>
@endpush






