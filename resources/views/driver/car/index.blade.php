@extends('admin.layouts.app')
@section('page_title', __('My Car'))
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
                            <li class="breadcrumb-item active" aria-current="page">@lang('My Car')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Car Add')</h1>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <form action="{{ route($base_route_path . 'update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <a type="button" href="#" class="btn btn-info float-end"><i
                                    class="bi bi-arrow-left"></i>@lang('Back')</a>
                            <h4 class="card-header-title">@lang('Car information')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Name') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Type your car name here..."></i></label>
                                        <input type="text" class="form-control" name="name" id="nameLabel"
                                            placeholder="@lang('e.g. BMW X5 2019')" aria-label="name"
                                            value="{{ old('name', $car?->name) }}">

                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Type') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Select Your Car Type from here...')"></i></label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">@lang('Select Car Type')</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ old('type') == $type->value || $car?->type == $type->value ? 'selected' : '' }}>
                                                    @lang($type->value)</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="adultPriceLabel">@lang('Max Passengers')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your Car max passengers capacity Here...')"></i></label>
                                        <div class="input-group">
                                            <input type="max_passengers')" class="form-control wid1" name="max_passengers"
                                                id="max_passengers" value="{{ old('max_passengers' , $car?->max_passengers) }}" placeholder="e.g 4">
                                        </div>
                                        @error('max_passengers')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="adultPriceLabel">@lang('model')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your year model Here...')"></i></label>
                                        <div class="input-group">
                                            <input type="model" class="form-control wid1" name="model" id="model"
                                                value="{{ old('model' , $car?->model) }}" placeholder="e.g 4">
                                        </div>
                                        @error('model')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="adultPriceLabel">@lang('Plate  number')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your Plate Number Here...')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="number"
                                                id="number" value="{{ old('number' , $car?->number) }}" placeholder="e.g 4">
                                        </div>
                                        @error('number')
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
                        <div class="card-body">
                            <label class="form-label" for="packageThumbnail">@lang('Car Thumbnail')</label>
                            <label class="form-check form-check-dashed" for="logoUploader" id="content_img">
                                <img id="previewImage" class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                    src="{{  getFile($car?->thumb_driver, $car?->thumb) ?? asset('assets/admin/img/oc-browse-file.svg') }}" alt="Image Preview"
                                    data-hs-theme-appearance="default">
                                <span class="d-block">@lang('Browse your file here')</span>
                                <input type="file" class="js-file-attach form-check-input" name="thumb"
                                    id="logoUploader"
                                    data-hs-file-attach-options='{
                                                                  "textTarget": "#previewImage",
                                                                  "mode": "image",
                                                                  "targetAttr": "src",
                                                                  "allowTypes": [".png", ".jpeg", ".jpg"]
                                                               }'>
                            </label>
                            <p class="pt-2">@lang('For better resolution, please use an image with a size of') {{ config('filelocation.cars.size') }}
                                @lang(' pixels.')</p>
                            @error('thumb')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">@lang('Save')</button>
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
        .note-editor.note-frame {
            border: .0625rem solid rgba(231, 234, 243, .7) !important;
        }

        .image-uploader {
            border: .0625rem solid rgba(231, 234, 243, .7) !important;
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
        document.getElementById('logoUploader').addEventListener('change', function() {
            let file = this.files[0];
            let reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            }

            reader.readAsDataURL(file);
        });
        $(document).ready(function() {

            $(document).on('click', '.delete_desc', function() {
                $(this).closest('.input-group').parent().remove();
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
