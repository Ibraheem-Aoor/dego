@extends('admin.layouts.app')
@section('page_title', __('Edit Country'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <h1 class="page-header-title">@lang("Edit Country")</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang("Edit Country")</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title mt-2">@lang("Edit Country")</h3>
                            <a href="{{ route('admin.all.country') }}" class="btn btn-info btn-sm">@lang("Back")</a>
                        </div>
                        <div class="card-body mt-2">
                            <form action="{{ route('admin.country.update', $country->id) }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NameLabel" class="form-label  ">@lang("Country Name")</label>
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control change_name_input" name="name"
                                                       id="NameLabel" value="{{ $country->name }}"
                                                       placeholder="@lang("Country Name")" autocomplete="off">
                                            </div>
                                            @error("name")
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="ISO TWO" class="form-label  ">@lang("Iso2")</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="iso2" class="form-control" placeholder="Country Two Character ISO" value="{{ $country->iso2 }}" aria-label="Country Two Character ISO" aria-describedby="Country Two Character ISO">

                                                @error("iso2")
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="iso3" class="form-label  ">@lang("Iso3")</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="iso3" class="form-control" placeholder="Country Three Character ISO" value="{{ $country->iso3 }}" aria-label="Country Three Character ISO" aria-describedby="ISO Three">

                                                @error("iso3")
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NameLabel"
                                                   class="form-label ">@lang("Phone Code")</label>
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control change_name_input" name="phone_code"
                                                       id="NameLabel" value="{{ $country->phone_code }}"
                                                       placeholder="@lang("Country Phone Code")" autocomplete="off">
                                            </div>
                                            @error("phone_code")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NameLabel"
                                                   class="form-label">@lang("Region")
                                                <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="@lang('Add Country Region.')" data-bs-original-title="@lang('Add Country Region.')"></i>
                                            </label>
                                            <input type="text" class="form-control change_name_input"
                                                   name="region"
                                                   id="NameLabel" value="{{ $country->region }}"
                                                   placeholder="@lang("Country Region")"
                                                   autocomplete="off">

                                            @error("region")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="NameLabel"
                                                   class="form-label ">@lang("Sub Region")
                                                <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="@lang('Add Country Sub Region.')" data-bs-original-title="@lang('Add Country Sub Region.')"></i>
                                            </label>
                                            <input type="text" class="form-control" name="subregion"
                                                   placeholder="@lang('Country Sub Region')"
                                                   aria-label=""
                                                   value="{{ $country->subregion }}"
                                                   aria-describedby="">
                                            @error("subregion")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-box">
                                            <div class="row g-4 mt-1">
                                                <label>@lang('Country image')</label>
                                                <div class="input-field mt-0">
                                                    <input type="file" name="image" class="form-control" value="{{$country->image}}"  id="image"   />
                                                    <img id="showImage" class="countryImage" alt="image"  src="{{getFile($country->image_driver,$country->image)}}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center pt-5">
                                            <div class="col-sm mb-2 mb-sm-0 mt-3">
                                                <h5 class="mb-0">@lang('Status')</h5>
                                                <p class="fs-5 text-body mb-0">@lang('Country status enable or Disable for hide or unhide country. ')</p>
                                            </div>
                                            <div class="col-sm-auto d-flex align-items-center">
                                                <div class="form-check form-switch form-switch-google">
                                                    <input type="hidden" name="status" value="0">
                                                    <input class="form-check-input" name="status"
                                                           type="checkbox" id="status" value="1" {{ $country->status == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                           for="status"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start mt-4">
                                    <button type="submit" class="btn btn-primary submit_btn btn-sm">@lang("Save")</button>
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
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            HSCore.components.HSTomSelect.init('.js-select');
            new HSFileAttach('.js-file-attach')
            $(document).on('input', ".change_name_input", function (e) {
                let inputValue = $(this).val();
                let final_value = inputValue.toLowerCase().replace(/\s+/g, '-');
                $('.set-slug').val(final_value);
            });
            $('.dropdown-toggle').dropdown();

            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script src="{{ asset("assets/admin/js/hs-file.min.js") }}"></script>
@endpush








