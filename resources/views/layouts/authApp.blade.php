<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') {{$basic['sign']?? '|'}} {{$basic['name']?? 'Website'}}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <link rel="icon" href="{{empty($website->favicon) ? asset('assets/img/favicon.ico') : $website->favicon }}" />

    <link rel="stylesheet" href="{{mix('assets/css/style.css')}}" />

    {!! $basic['front_head'] !!}

    @yield('style')
</head>
<body>
    <div id="app" class="auth_area">
        <div class="authApp">
            <a href="{{route('home')}}" class="logo">
                <img src="{{ empty($website->logo) ? asset('assets/img/default_logo.png') : $website->logo}}" alt="logo">
            </a>
            <div class="main_area">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{mix('assets/js/script.js')}}"></script>

    @include('components.global.toast')

    @yield('script')


{!! $basic['front_bottom'] !!}
</body>

</html>
