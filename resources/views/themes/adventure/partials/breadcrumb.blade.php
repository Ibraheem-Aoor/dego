@php
    use Illuminate\Support\Facades\Request;
    $currentPath = Request::path();
    $pageTitle = $pageSeo['page_title'] ?? (
        (request()->route()->getName() == 'package.details') ? 'Package Details' :
         ((request()->route()->getName() == 'blog.details') ? 'Blog Details' : 'Default Title')
    );
@endphp

@if(isset($pageSeo['breadcrumb_status']) && $pageSeo['breadcrumb_status'] == 1)
    @if(isset($pageSeo['breadcrumb_image']))
        <div class="banner-area" style="background-image:linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{ getFile($pageSeo['breadcrumb_image_driver'], $pageSeo['breadcrumb_image']) }});">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-area">
                            <h3>{{ isset($pageSeo['page_title']) ? $pageSeo['page_title'] : $pageTitle }}</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('page','/') }}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ isset($pageSeo['page_title']) ? $pageSeo['page_title'] : $pageTitle}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
