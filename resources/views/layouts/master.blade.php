<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') {{$basic['sign']?? '|'}} {{$basic['name']?? 'Website'}}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ empty($website->favicon) ? asset('assets/img/favicon.ico') : $website->favicon }}" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="{{mix('assets/css/all.css')}}" rel="stylesheet"/>

    {!! $basic['back_head'] !!}

    @yield('style')

</head>

@routes

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default m-aside-left--fixed">

    <div class="m-grid m-grid--hor m-grid--root m-page">

        @include("components.account.header")

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

            @if(user()->hasRole('admin')&&Request::is('admin*'))
                <x-admin.sidebar></x-admin.sidebar>
            @elseif(user()->hasRole('employee')&&Request::is('employee*'))
                <x-employee.sidebar></x-employee.sidebar>
            @elseif(user()->hasRole('client')&&Request::is('client*'))
                <x-client.sidebar></x-client.sidebar>
            @elseif(Auth::check()&&Request::is('account*'))
                <x-user.sidebar></x-user.sidebar>
            @endif

            <div class="m-grid__item m-grid__item--fluid m-wrapper">

                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        @yield('breadcrumb')
                    </div>
                </div>

                <div class="m-content position-relative md-plr-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>

    <script src="{{mix('assets/js/all.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>

    <script>
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>

    @include('components.global.toast')
    @if(user()->hasRole('admin')&&Request::is('admin*'))
        <script src="{{asset('assets/js/admin/sidebar.js')}}"></script>
    @else
        <script src="{{asset('assets/js/user/sidebar.js')}}"></script>
    @endif
    @yield('script')

    {!! $basic['back_bottom'] !!}

</body>

</html>
