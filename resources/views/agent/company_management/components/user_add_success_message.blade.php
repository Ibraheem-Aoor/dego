@extends('admin.layouts.app')
@section('page_title',__('Success Message'))

@section('content')
    <div class="content container-fluid">
        <div class="row justify-content-lg-center">
            <div class="col-lg-8">
                <div id="successMessageContent">
                    <div class="text-center">
                        <img class="img-fluid mb-3 customImageStyle"
                             src="{{ asset('assets/admin/img/oc-hi-five.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="default">
                        <img class="img-fluid mb-3 customImageStyle"
                             src="{{ asset('assets/admin/img/oc-hi-five-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="dark">
                        <div class="mb-4">
                            <h2>@lang("Successful")</h2>
                            <p>@lang("New") <span
                                    class="fw-semibold text-dark">@lang($user->name)</span> @lang("Company has been successfully
                                created.")</p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-white me-3" href="{{ route('agent.company.index') }}">
                                <i class="bi-chevron-left ms-1"></i> @lang("Back to Companies")
                            </a>
                            <a class="btn btn-primary" href="{{ route('agent.company.add') }}">
                                <i class="bi-person-plus-fill me-1"></i> @lang("Add new Company")
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection





