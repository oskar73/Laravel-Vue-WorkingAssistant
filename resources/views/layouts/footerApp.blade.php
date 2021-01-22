<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Footer Setting</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google Front -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">


    <link rel="stylesheet" href="{{mix('assets/css/style.css')}}" />

    @yield('style')

</head>
<body>

@yield('content')


<script src="{{mix('assets/js/script.js')}}"></script>

<script>
    var token = $('meta[name="csrf-token"]').attr('content');
</script>

@include('components.global.toast')

@yield('script')

</body>

</html>
