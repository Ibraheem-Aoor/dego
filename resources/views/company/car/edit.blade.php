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
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Cars')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Car Edit')</h1>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <form action="{{ route($base_route_path . 'update', $car->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <a type="button" href="{{ route($base_route_path . 'list') }}" class="btn btn-info float-end"><i
                                    class="bi bi-arrow-left"></i>@lang('Back')</a>
                            <h4 class="card-header-title">@lang('Car information')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Name') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Type your package name here..."></i></label>
                                        <input type="text" class="form-control" name="name" id="nameLabel"
                                            placeholder="@lang('e.g. BMW X5 2019')" aria-label="name"
                                            value="{{ old('name', optional($car)->name) }}">

                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Engine Type') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Select Your Engine Type from here...')"></i></label>
                                        <select name="engine_type" id="engine_type" class="form-control">
                                            <option value="">@lang('Select Engine Type')</option>
                                            @foreach ($engine_types as $engine_type)
                                                <option value="{{ $engine_type->value }}"
                                                    {{ old('engine_type', optional($car)->engine_type) == $engine_type->value ? 'selected' : '' }}>
                                                    @lang($engine_type->value)</option>
                                            @endforeach
                                        </select>
                                        @error('engine_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Transmission Type') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Select your Transmission Type name From here...')"></i></label>
                                        <select name="transmission_type" id="transmission_type" class="form-control">
                                            <option value="">@lang('Transmission Type')</option>
                                            @foreach ($transmission_types as $transmission_type)
                                                <option value="{{ $transmission_type->value }}"
                                                    {{ old('transmission_type', optional($car)->transmission_type) == $transmission_type->value ? 'selected' : '' }}>
                                                    @lang($transmission_type->value)</option>
                                            @endforeach
                                        </select>
                                        @error('transmission_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="adultPriceLabel">@lang('Door Count')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your Car Doors Count Here...')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="doors_count"
                                                id="doors_count"
                                                value="{{ old('doors_count', optional($car)->doors_count) }}"
                                                placeholder="e.g 4">
                                        </div>
                                        @error('doors_count')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="passengers_count">@lang('Passengers Count')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type Car Max Capacity Of Passengers')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="passengers_count"
                                                id="passengers_count"
                                                value="{{ old('passengers_count', optional($car)->passengers_count) }}"
                                                placeholder="e.g 4">
                                        </div>
                                        @error('passengers_count')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="storage_bag_count">@lang('Storage Bag No.')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your car  Storage Bag Count')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="storage_bag_count"
                                                id="storage_bag_count"
                                                value="{{ old('storage_bag_count', optional($car)->storage_bag_count) }}"
                                                placeholder="e.g 4">
                                        </div>
                                        @error('storage_bag_count')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="rent_price">@lang('Rent Price')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your car  Rent Price per day here...')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="rent_price"
                                                id="rent_price"
                                                value="{{ old('rent_price', optional($car)->rent_price) }}"
                                                placeholder="e.g 50" aria-label="price">
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>

                                        </div>
                                        @error('rent_price')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="insurance_price">@lang('Insurance Price')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Type your car Insurance Price here...')"></i></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="insurance_price"
                                                id="insurance_price"
                                                value="{{ old('insurance_price', optional($car)->insurance_price) }}"
                                                placeholder="e.g 50" aria-label="price">
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>

                                        </div>
                                        @error('insurance_price')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="pickup_location">@lang('Pickup Location')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Google Map For Client To Pick Car From')"></i>
                                        </label>
                                        <input type="text" name="pickup_location" id="pickup_location"
                                            class="form-control"
                                            value="{{ old('pickup_location', optional($car)->pickup_location) }}"
                                            placeholder="@lang('Google Map For Client To Pick Car From')">
                                        @error('pickup_location')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="drop_location">@lang('Drop Location')
                                            <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="@lang('Google Map For Client To Pick Car From')"></i>
                                        </label>
                                        <input type="text" name="drop_location" id="drop_location"
                                            class="form-control"
                                            value="{{ old('drop_location', optional($car)->drop_location) }}"
                                            placeholder="@lang('Google Map For Client To Drop Car at')">
                                        @error('drop_location')
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
                                    <label class="form-label" for="fuel_policy">@lang('Fuel Policy')
                                        <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="@lang('Describe Fuel Policy')"></i>
                                    </label>
                                    <textarea name="fuel_policy" class="form-control summernote" cols="30" rows="5" id="fuel_policy"
                                        placeholder="@lang('Describe Fuel Policy')">{{ old('fuel_policy', optional($car)->fuel_policy) }}</textarea>
                                    @error('fuel_policy')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 mb-lg-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label" for="insurance_info">@lang('Insurance Info')
                                        <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="@lang('Describe Insurance Policy')"></i>
                                    </label>
                                    <textarea name="insurance_info" class="form-control summernote" cols="30" rows="5" id="insurance_info"
                                        placeholder="@lang('Describe Insurance Policy')">{{ old('insurance_info', optional($car)->insurance_info) }}</textarea>
                                    @error('insurance_info')
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
                            <label class="form-label" for="packageThumbnail">@lang('Car Thumbnail')</label>
                            <label class="form-check form-check-dashed" for="logoUploader" id="content_img">
                                <img id="previewImage" class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                    src="{{ getFile($car->thumb_driver, $car->thumb) }}" alt="Image Preview"
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
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-body">
                            <label class="form-label" for="packageImage">@lang('Car Images')</label>
                            <div class="input-images" id="packageImage"></div>
                            @if ($errors->has('images'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('images') }}</strong>
                                </span>
                            @endif
                            <p class="pt-2">@lang('For better resolution, please use an image with a size of') {{ config('filelocation.cars.size') }}
                                @lang(' pixels.')</p>
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

            $('.summernote').summernote({
                height: 200,
                disableDragAndDrop: true,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable')
                            .val();
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
    <script>
        let images = @json($images);
        let oldImage = @json($oldimg);
        let preloaded = [];

        images.forEach(function(value, index) {
            preloaded.push({
                id: oldImage[index],
                src: value,
            });
        });

        $('.input-images').imageUploader({
            preloaded: preloaded
        });
    </script>
@endpush
