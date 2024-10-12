@extends('admin.layouts.app')
@section('page_title', __('Package Add'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Package')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Package Add')</h1>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <form action="{{ route('admin.package.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <a type="button" href="{{ route('admin.all.destination') }}" class="btn btn-info float-end"><i class="bi bi-arrow-left"></i>@lang('Back')</a>
                            <h4 class="card-header-title">@lang('Package information')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Name') <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Type your package name here..."></i></label>
                                        <input type="text" class="form-control" name="name" id="nameLabel" placeholder="e.g. Centipade Tour - Guided Arizona Desert Tour By ATV" aria-label="name" value="{{ old('name') }}">

                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="slugLabel" class="form-label">@lang('Slug') <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Slug will be auto-generated based on the name."></i></label>
                                        <input type="text" class="form-control" name="slug" id="slugLabel" placeholder="e.g. centipade-tour-guided-arizona-desert-tour-by-atv" aria-label="slug" value="{{ old('slug') }}">

                                        @error('slug')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="adultPriceLabel">@lang('Price For Adult')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Price for every 18+ tourist."></i></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control wid1" name="adult_price" id="adultPriceLabel" value="{{ old('adult_price') }}" placeholder="e.g 500" aria-label="price">
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>
                                        </div>
                                        @error('adult_price')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="childrenPriceLabel">@lang('Price For Children')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Price for every 12-18 year tourist."></i></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control wid1" name="children_price" id="childrenPriceLabel" value="{{ old('children_price') }}" placeholder="e.g 500" aria-label="price" >
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>
                                        </div>
                                        @error('children_price')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="infantPriceLabel">@lang('Price For Infant')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Price for every below 12 year tourist."></i></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control wid1" name="infant_price" id="infantPriceLabel" value="{{ old('infant_price') }}" placeholder="e.g 500" aria-label="price">
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>
                                        </div>
                                        @error('infant_price')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="category_id">@lang('Category')</label>
                                        <select class="form-control js-select" id="category_id" name="category_id">
                                            <option value="" disabled>@lang('Select Category')</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    @lang($category->name)
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="destination_id">@lang('Destination')</label>
                                        <select class="form-control js-select" id="destination_id" name="destination_id">
                                            <option value="" disabled>@lang('Select Destination')</option>
                                            @foreach($destinations as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('destination_id') == $item->id ? 'selected' : '' }}>
                                                    @lang($item->title)
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('destination_id')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="startPoint">@lang('Start Point')</label>
                                        <input type="text" name="startPoint" id="startPoint" class="form-control" value="{{ old('startPoint') }}" placeholder="e.g Les Corts, 08028 Barcelona, Spain">
                                        @error('startPoint')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="startMessage">@lang('Start Message')</label>
                                        <input type="text" name="startMessage" id="startMessage" class="form-control" value="{{ old('startMessage') }}" placeholder="Describe your starting message">
                                        @error('startMessage')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="endPoint">@lang('End Point')</label>
                                        <input type="text" name="endPoint" class="form-control" value="{{ old('endPoint') }}" placeholder="e.g Les Corts, 08028 Barcelona, Spain" id="endPoint">
                                        @error('endPoint')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="endMessage" class="form-label">@lang('End Messages')</label>
                                        <input type="text" name="endMessage" class="form-control" id="endMessage" value="{{ old('endMessage') }}" placeholder="Describe your end message">
                                        @error('endMessage')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="minimumTravelers">@lang('Minimum Travelers')</label>
                                        <input type="number" name="minimumTravelers" class="form-control" placeholder="e.g. 5" value="{{ old('minimumTravelers') }}" id="minimumTravelers">
                                        @error('minimumTravelers')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="maximumTravelers">@lang('Maximum Travelers')</label>
                                        <input type="number" name="maximumTravelers" class="form-control" placeholder="e.g. 15" value="{{ old('maximumTravelers') }}" id="maximumTravelers">
                                        @error('maximumTravelers')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="tourDuration">@lang('Tour Duration')</label>
                                        <input type="text" name="tourDuration" class="form-control" placeholder="e.g. 5 days 4 night" value="{{ old('tourDuration') }}" id="tourDuration">
                                        @error('tourDuration')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label for="video">@lang('Video Link')</label>
                                        <input type="text" name="video" class="form-control" placeholder="enter a video link" value="{{ old('video') }}" id="video">
                                        @error('video')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <div class=" justify-content-between">
                                            <div class="form-group">
                                                <a href="javascript:void(0)" class="btn btn-success float-left mt-3 generate">
                                                    <i class="fa fa-plus-circle"></i> @lang('Included Facility')</a>
                                            </div>
                                            <div class="row addedField mt-3 col-12"></div>
                                        </div>
                                        @error('facility')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <div class=" justify-content-between">
                                            <div class="form-group">
                                                <a href="javascript:void(0)" class="btn btn-success float-left mt-3 generateExcluded">
                                                    <i class="fa fa-plus-circle"></i> @lang('Excluded Facility')</a>
                                            </div>
                                            <div class="row addedExcludedField mt-3 col-12"></div>
                                        </div>
                                        @error('excluded')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <div class=" justify-content-between">
                                            <div class="form-group">
                                                <a href="javascript:void(0)" class="btn btn-success float-left mt-3 generateExpect">
                                                    <i class="fa fa-plus-circle"></i> @lang('What We Expect')</a>
                                            </div>
                                            <div class="row addedExpectField mt-3"></div>
                                        </div>
                                        @error('expect')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 mb-lg-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label" for="details">@lang('Package Details')</label>
                                    <textarea
                                        name="details"
                                        class="form-control summernote"
                                        cols="30"
                                        rows="5"
                                        id="details"
                                        placeholder="Package details"
                                    >{{ old('details') }}</textarea>
                                    @error('details')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-body">
                            <label class="form-label" for="packageThumbnail">@lang('Package Thumbnail')</label>
                            <label class="form-check form-check-dashed" for="logoUploader" id="content_img">
                                <img id="previewImage"
                                     class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                     src="{{ asset("assets/admin/img/oc-browse-file.svg") }}"
                                     alt="Image Preview" data-hs-theme-appearance="default">
                                <span class="d-block">@lang("Browse your file here")</span>
                                <input type="file" class="js-file-attach form-check-input" name="thumb"
                                       id="logoUploader" data-hs-file-attach-options='{
                                                                  "textTarget": "#previewImage",
                                                                  "mode": "image",
                                                                  "targetAttr": "src",
                                                                  "allowTypes": [".png", ".jpeg", ".jpg"]
                                                               }'>
                            </label>
                            <p class="pt-2">@lang('For better resolution, please use an image with a size of') {{ config('filelocation.package_thumb.size') }} @lang(' pixels.')</p>
                            @error('thumb')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-body">
                            <label class="form-label" for="packageImage">@lang('Package Images')</label>
                            <div class="input-images" id="packageImage"></div>
                            @if($errors->has('images'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('images') }}</strong>
                                </span>
                            @endif
                            <p class="pt-2">@lang('For better resolution, please use an image with a size of') {{ config('filelocation.package.size') }} @lang(' pixels.')</p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">@lang("Save")</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/image-uploader.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/flatpickr.min.css') }}">

    <style>
        .note-editor.note-frame{
            border: .0625rem solid rgba(231, 234, 243, .7) !important;
        }
        .image-uploader{
            border:  .0625rem solid rgba(231, 234, 243, .7) !important;
        }
    </style>
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/image-uploader.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/timepicker-bs4.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dateandtime.js') }}"></script>
    <script>
        "use strict";
        flatpickr('#Date', {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: 'today'
        });
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('nameLabel');
            const slugInput = document.getElementById('slugLabel');

            nameInput.addEventListener('input', function () {
                slugInput.value = generateSlug(nameInput.value);
            });

            function generateSlug(text) {
                return text
                    .toString()
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9 -]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });
        document.getElementById('logoUploader').addEventListener('change', function() {
            let file = this.files[0];
            let reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            }

            reader.readAsDataURL(file);
        });
        $(document).ready(function(){
            $(".generate").on('click', function () {
                let form = `<div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="facility[]" class="form-control " type="text" value="" required placeholder="{{trans('Enter a included facility')}}">

                                        <span class="input-group-btn">
                                            <button class="btn btn-white delete_desc" type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;
                $(this).parents('.form-group').siblings('.addedField').append(form)

            });
            $(".generateExcluded").on('click', function () {
                let form = `<div class="col-md-6 pb-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="excluded[]" class="form-control " type="text" value="" required placeholder="{{trans('Enter a excluded facility')}}">

                                        <span class="input-group-btn">
                                            <button class="btn btn-white delete_desc" type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;
                $(this).parents('.form-group').siblings('.addedExcludedField').append(form)

            });
            $(".generateExpect").on('click', function () {
                let form = `<div class="col-md-6 pb-2 expectationArea">
                                <div class="form-group">
                                    <div class="inputArea">
                                        <input name="expect[]" class="form-control expect" type="text" value="" required placeholder="{{trans('Enter a expect title')}}">
                                        <textarea
                                            name="expect_details[]"
                                            class="form-control summernote"
                                            cols="30"
                                            rows="5"
                                            id="details"
                                            placeholder="Expectation details"
                                        ></textarea>
                                    </div>
                                    <div class="deleteExpectArea ms-1">
                                        <span class="input-group-btn">
                                            <button class="btn btn-white delete_desc" type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;
                $(this).parents('.form-group').siblings('.addedExpectField').append(form)

            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });

            $('.summernote').summernote({
                height: 200,
                disableDragAndDrop: true,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });

            HSCore.components.HSTomSelect.init('#category_id', {
                maxOptions: 250,
                placeholder: 'Select Category'
            });

            HSCore.components.HSTomSelect.init('#destination_id', {
                maxOptions: 250,
                placeholder: 'Select Destination'
            });

            $('.input-images').imageUploader();
        });
    </script>
@endpush
