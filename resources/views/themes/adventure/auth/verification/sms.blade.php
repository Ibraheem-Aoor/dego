@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
    <section class="login-signup-page pt-0 pb-0 min-vh-100 h-100">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                @include(template().'sections.account_partials')

                <div class="col-md-6 p-0 d-flex justify-content-center flex-column">
                    <div class="login-signup-form">
                        <form class="login-form" action="{{route('user.sms.verify')}}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3 class="mt-5 ">@lang('Verify Your Mobile Number')</h3>
                                <div class="mt-3 mb-3">
                                    <p class="d-flex flex-wrap">@lang("Your Mobile Number is") {!! maskString(auth()->user()->phone) !!}</p>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="code" value="{{old('code')}}"
                                           placeholder="@lang('Code')" autocomplete="off">

                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn2 mt-30 w-100">@lang('Submit')</button>
                            <div class="pt-20 text-center">
                                @if (Route::has('user.resend.code'))
                                    <div class="login-query mt-30 text-center">
                                        <p>@lang('Didn\'t get Code? Click to') <a
                                                    href="{{route('user.resend.code')}}?type=mobile"
                                                    class="text-info"> @lang('Resend code')</a></p>
                                        @error('resend')
                                        <p class="text-danger  mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
