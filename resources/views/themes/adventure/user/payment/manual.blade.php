@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-capitalize" href="{{ route('page','/') }}">@lang('home')</a></li>
                    <li class="breadcrumb-item active">@lang($deposit->gateway->name)</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center manualPaymentOption">
            <div class="col-xl-10 col-lg-10 card manualPaymentOptionCard">
                <div class="instruction-form">
                    <div class="header-text ">
                        <h3 class="title text-center">{{trans('Please follow the instruction below')}}</h3>
                        <p class="mt-2 mx-auto text-center">{{trans('You have requested to deposit')}} <b
                                class="text--base">{{currencyPosition($deposit->payable_amount_in_base_currency)}}
                            </b> , {{trans('Please pay')}}
                            <b class="text--base">{{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</b> {{trans('for successful payment')}}
                        </p>
                        <p class="mt-2 mx-auto text-center">
                            {{optional($deposit->gateway)->note}}
                        </p>
                    </div>
                    <div class="sidebar-wrapper">
                        <form action="{{route('addFund.fromSubmit',$deposit->trx_id)}}" method="post"
                              enctype="multipart/form-data"
                              class="form-row  preview-form">
                            @csrf
                            <div class="row g-3">
                                @if(optional($deposit->gateway)->parameters)
                                    @foreach($deposit->gateway->parameters as $k => $v)
                                        @if($v->type == "text")
                                            <div class="col-md-6">
                                                <div class="input-box">
                                                    <label class="form-label">{{trans($v->field_label)}} @if($v->validation == 'required')
                                                            <span class="text--danger">*</span>
                                                        @endif </label>
                                                    <input type="text" name="{{$k}}"
                                                           placeholder="{{'e.g. ' . $v->field_label }}"
                                                           class="form-control bg-transparent"
                                                           @if($v->validation == "required") required @endif>
                                                    @if ($errors->has($k))
                                                        <span
                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($v->type == "number")
                                            <div class="col-md-6">
                                                <div class="form-group  ">
                                                    <label class="form-label">{{trans($v->field_label)}} @if($v->validation == 'required')
                                                            <span class="text--danger">*</span>
                                                        @endif </label>
                                                    <input type="text" name="{{$k}}"
                                                           class="form-control bg-transparent"
                                                           @if($v->validation == "required") required @endif>
                                                    @if ($errors->has($k))
                                                        <span
                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($v->type == "textarea")
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{trans($v->field_label)}} @if($v->validation == 'required')
                                                            <span class="text--danger">*</span>
                                                        @endif </label>
                                                    <textarea name="{{$k}}" class="form-control bg-transparent"
                                                              rows="3"
                                                              @if($v->validation == "required") required @endif></textarea>
                                                    @if ($errors->has($k))
                                                        <span
                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($v->type == "file")
                                            <div class="col-md-6">
                                                <label class="form-label">{{ trans($v->field_label) }}
                                                    @if($v->validation == 'required')
                                                        <span class="text--danger">*</span>
                                                    @endif
                                                </label>
                                                <div class="image-input">
                                                    <input type="file" class="form-control" name="{{ $k }}" id="image" accept="image/*"
                                                           @if($v->validation == "required") required @endif onchange="previewManualImage(event)">
                                                    <img class="manualImagePreview" id="image-preview-{{ $k }}" src="#" alt="Image Preview">
                                                </div>
                                                @error($k)
                                                <span class="text-danger">@lang($message)</span>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div class="col-md-12 ">
                                    <button type="submit" class="cmn-btn">
                                        <span>@lang('Confirm Now')</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('style')
    <style>
        .card{
            padding: 35px !important;
        }
        .form-control{
           background-color: var(--white)!important;
            height: 38px !important;
        }
        .sidebar-wrapper{
            padding-top: 20px ;
        }
    </style>
@endpush
@push('script')
    <script>
        'use strict'
        $(document).on("change", '#image', function () {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview_container').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        function previewManualImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview-' + input.name);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.height = '100px';
                    preview.style.width = '100px';
                    preview.style.borderRadius = '10px';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
@endpush
