<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@lang(basicControl()->site_title) | @if(isset($pageSeo->page_title))@lang($pageSeo->page_title)@else
            @yield('title')@endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ getFile(basicControl()->favicon_driver, basicControl()->favicon) }}" rel="icon">


    <link href="{{ asset($themeTrue . 'css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <link href="{{ asset($themeTrue . 'css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
    @yield('content')
</div>


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<script src="{{ asset($themeTrue.'js/jquery-3.6.1.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/bootstrap.min.js') }}"></script>

</body>

</html>
