@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
    <section class="sign-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="sign-in-container">
                        <div class="sign-in-container-inner">
                            <div class="sign-in-form">
                                <form class="login-form" action="{{route('user.sms.verify')}}"  method="post">
                                    @csrf

                                    <div class="row mb-4">
                                        <div class="sign-in-form-group">
                                            <h3 class="mt-5 ">@lang('Verify Your Mobile Number')</h3>
                                            <div class="mt-3 mb-3">
                                                <p class="d-flex flex-wrap">@lang("Your Mobile Number is") {!! maskString(auth()->user()->phone) !!}</p>
                                            </div>
                                        </div>
                                        <div class="sign-in-form-group">
                                            <input class="sign-in-input" type="text" name="code" value="{{old('code')}}"
                                                   placeholder="@lang('Code')" autocomplete="off">

                                            @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn-1 mt-30 w-100">@lang('Submit')</button>
                                    <div class="pt-20 text-center">
                                        @if (Route::has('user.resend.code'))
                                            <div class="login-query mt-30 text-center">
                                                <p>@lang('Didn\'t get Code? Click to') <a
                                                        href="{{route('user.resend.code')}}?type=mobile"
                                                        class="text-info pt-2"> @lang('Resend code')</a></p>
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
                <div class="col-lg-7">
                    <div class="sign-in-image text-end">
                        <img src="{{ getFile($content->media->image->driver,  $content->media->image->path)}}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
