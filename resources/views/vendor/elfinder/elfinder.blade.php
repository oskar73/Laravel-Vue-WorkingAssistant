<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>Storage Management</title>
        @php
            $dir = 'assets/vendors/elfinder';
        @endphp
        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
{{--        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/themes/windows-10/css/theme.css') }}">--}}
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">

        <style>
            .biz_progress {
                border:1px solid grey !important;
                border-radius:5px;
            }
            .biz_progressbar {
                background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent) !important;
                background-size: 1rem 1rem;
                background-color: #007bff !important;
                height:20px;
            }
        </style>
        <!-- elFinder JS (REQUIRED) -->
        <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $().ready(function() {
                $('#elfinder').elfinder({
                    // set your elFinder options here
                    @if($locale)
                        lang: '{{ $locale }}', // locale
                    @endif
                    customData: {
                        _token: '{{ csrf_token() }}'
                    },
                    url : '{{ route("elfinder.connector") }}',  // connector URL
                    soundPath: '{{ asset($dir.'/sounds') }}'
                }).elfinder('instance').exec('fullscreen');
            });
            loadSize();
            function loadSize()
            {
                $.ajax({
                    url: "/admin/storage/loadSize",
                    success: function(result)
                    {
                        $("#place-root-elfinder-elfinder").html(result).removeClass("ui-corner-all elfinder-navbar-dir  elfinder-navbar-root")
                    }
                });
            }
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
