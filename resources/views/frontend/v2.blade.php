<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>
        @if(isset($seo) && !is_null($seo['meta_title'])) {{$seo['meta_title']}}
        @else @yield('title')
        @endif
        | Bizinabox
    </title>

    <link rel="icon" href="{{empty($website->data->favicon->url) ? asset('assets/img/favicon.ico') : $website->data->favicon->url}}"/>

    @if($seo['meta_title']??null)
        <meta name="title" content="{{$seo['meta_title']}}" />
        <meta property="og:title" content="{{$seo['meta_title']}}" />
    @endif
    <link rel="canonical" href="{{url()->current()}}"/>
    <meta name="keywords" content="{{isset($seo) && !is_null($seo['meta_keywords']) ? $seo['meta_keywords'] : 'Bizinabox, Preview, Template, Business, Website'}}"/>
    <meta name="description" content="{{isset($seo) && !is_null($seo['meta_description']) ? $seo['meta_description'] : 'Bizinabox, Preview, Template, Business, Website'}}">
    <meta name="og:description" content="{{isset($seo) && !is_null($seo['meta_description']) ? $seo['meta_description'] : 'Bizinabox, Preview, Template, Business, Website'}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta property="og:type" content="website"/>
    @if(isset($seo['meta_image'])) <meta property="og:image" content="{{$seo['meta_image']}}" />@endif
    @if(isset($seo['meta_image'])) <meta name="twitter:image" content="{{$seo['meta_image']}}" /> @endif
    <meta property="og:url" content="{{url()->current()}}" />
    <meta name="twitter:url" content="{{url()->current()}}" />

    {!! $website->css??'' !!}

    @yield('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link href="{{mix('assets/css/dev1/preview.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="{{asset('assets\vendors\izitoastr\iziToast.min.css')}}" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
</head>

<body>

<div class="out_content min-vh-100">
    <div id="app" class="bz-page">
    </div>
</div>

<a href="#" class="scroll-to-top" style="display: inline;">
    &#8593;
</a>

@routes

@include('components.global.toast')

@include('components.global.builder')

{!! $website->script ?? '' !!}
</body>
</html>
