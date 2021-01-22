<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@if(Request::is('/')) {{$basic['seo_title']}} @else @yield('title') @endif {{$basic['sign']?? '|'}} {{$basic['name']?? 'Website'}}</title>

    @if(Request::is('/'))
        @include("components.front.seo", $seo)
    @else
        @yield('meta')
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="{{$basic['favicon']}}" />

    <!-- Google Front -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <link rel="stylesheet" href="{{mix('assets/css/style.css')}}" />

    <link href="{{asset('assets/vendors/contentbuilder/box/box.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simplelightbox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.css')}}" rel="stylesheet" type="text/css" />

    {!! app('tenant')->css !!}

    @if(app('tenant')->header!==null)
        {!! app('tenant')->header->css !!}
    @endif
    @if(app('tenant')->footer!==null)
        {!! tenant()->footer->mainCss !!}
        {!! tenant()->footer->sectionCss !!}
        {!! tenant()->footer->css !!}
    @endif

    {!! $basic['front_head'] !!}

    @yield('style')

    <x-front.theme-color></x-front.theme-color>
    <x-front.menu-color></x-front.menu-color>

</head>
<body class="bz-page">

    <div id="header">
        <header-view></header-view>
    </div>

    @yield('content')

    <div id="footer">
        <footer-view></footer-view>
    </div>

    <a href="#" class="scroll-to-top" style="display: inline;">
        &#8593;
    </a>

    <div class="newsletter_area"></div>

    <script src="{{mix('assets/js/script.js')}}"></script>

    <script>
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>

    {{--Loader Include--}}
    @if(Request::is('/') && $basic['loading']!=null && $basic['loading']!=0)
        @include('components.global.loader', ['loading'=>$basic['loading'], 'color'=>$basic['loading_color']?? '#333', 'time'=>$basic['loading_time']?? '1000'])
    @endif
    {{--Loader Include End--}}

    @include('components.global.toast')

    {!! tenant()->script !!}

    @publishedModule("email")
        @if(!session("closeNewsletter"))
            <script src="{{asset('assets/js/front/subscribe.js')}}"></script>
        @endif
    @endpublishedModule

    @yield('script')

    {!! $basic['front_bottom'] !!}

    @routes
</body>

@include('components.global.builder')
</html>
