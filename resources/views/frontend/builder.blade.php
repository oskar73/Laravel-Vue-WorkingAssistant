@extends('layouts.app')

@section('style')
    <link type="text/css" rel="stylesheet" href="{{asset('css/website.css')}}">
@endsection

@section('content')
    <div class="out_content overflow-hidden min-vh-100">
        <div id="app" class="bz-page">
            <template-view></template-view>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.template = {!! $template !!};
    </script>
    <script src="{{asset('js/website.js')}}" type="text/javascript"></script>
@endsection
