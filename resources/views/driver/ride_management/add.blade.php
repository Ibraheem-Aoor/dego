@extends('admin.layouts.app')
@section('page_title', __('Add Ride Destination'))
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
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Ride Destinations')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Add Rid Destination')</h1>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <a type="button" href="{{ route($base_route_path . 'index') }}"
                                class="btn btn-info float-end"><i class="bi bi-arrow-left"></i>@lang('Back')</a>
                            <h4 class="card-header-title">@lang('Ride Destination information')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('From City') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Type your package name here..."></i></label>
                                        <input type="text" class="form-control" name="from" id="nameLabel"
                                            placeholder="@lang('e.g. BMW X5 2019')" aria-label="name" value="{{ old('from' , $ride?->from) }}">

                                        @error('from')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('To City') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Type your package name here..."></i></label>
                                        <input type="text" class="form-control" name="to" id="nameLabel"
                                            placeholder="@lang('e.g. BMW X5 2019')" aria-label="name" value="{{ old('to' , $ride?->to) }}">

                                        @error('to')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="firstNameLabel"
                                            class="col-sm-3 col-form-label form-label">@lang('Price')</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control wid1" name="price" id="price"
                                                value="{{ old('price' , $ride?->price) }}" placeholder="e.g 50"
                                                aria-label="price">
                                            <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}</h5>
                                        </div>

                                        @error('price')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
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
@endpush
