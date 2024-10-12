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
                                <form class="login-form" action="{{route('user.twoFA-Verify')}}"  method="post">
                                    @csrf

                                    <div class="row mb-4">
                                        <div class="sign-in-form-group">
                                            <h3 class="title mb-30">@lang('Two Fa Code')</h3>
                                        </div>
                                        <div class="sign-in-form-group">
                                            <input class="sign-in-input" type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')" autocomplete="off">

                                            @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn-1 mt-30 w-100">@lang('Submit')</button>
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
