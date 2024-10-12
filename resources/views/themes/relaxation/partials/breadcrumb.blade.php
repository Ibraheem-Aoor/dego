

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
        <section class="common-banner">
            <div class="bg-layer" style="background: url({{ getFile($pageSeo['breadcrumb_image_driver'], $pageSeo['breadcrumb_image']) }});"></div>
            <div class="common-banner-content">
                <div class="common-banner-content-inner">
                    <h1>{{ isset($pageSeo['page_title']) ? $pageSeo['page_title'] : $pageTitle}}</h1>
                    <div class="common-banner-link">
                        <a href="{{ route('page','/') }}">@lang('Home')</a>
                        <i class="fa-light fa-angle-right"></i>
                        <p>{{ isset($pageSeo['page_title']) ? $pageSeo['page_title'] : $pageTitle}}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
