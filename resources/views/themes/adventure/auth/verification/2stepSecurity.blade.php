@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
    <section class="login-signup-page pt-0 pb-0 min-vh-100 h-100">
        <div class="container-fluid h-100">
            <div class="row min-vh-100">
                @include(template().'sections.account_partials')

                <div class="col-md-6 p-0 d-flex justify-content-center flex-column">
                    <div class="login-signup-form">
                        <form class="login-form" action="{{route('user.twoFA-Verify')}}"  method="post">
                            @csrf

                            <div class="section-header">
                                <h3 class="title mb-30">@lang('Two Fa Code')</h3>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')" autocomplete="off">

                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn2 mt-30 w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
