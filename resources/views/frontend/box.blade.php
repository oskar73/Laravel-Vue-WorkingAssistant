@extends('layouts.app')

@section('title', $seo['meta_title']?? $page->name)

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')

{{--    <link href="{{asset('assets/vendors/contentbuilder/box/box.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simplelightbox.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.css')}}" rel="stylesheet" type="text/css" />--}}
    @if($page->mainCss!=null)
        {!! $page->mainCss !!}
    @endif
    @if($page->sectionCss!=null)
        {!! $page->sectionCss !!}
    @endif
    {!! $page->css !!}

@endsection
@section('content')
    <div class="is-wrapper">
        @if($page->content!==null)
            {!! $page->content !!}
        @else
{{--            @include('components.admin.defaultBox')--}}
        @endif
    </div>
    <input type="hidden" id="page_id" value="{{$page->id}}">
@endsection
@section('script')
{{--    <script src="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simple-lightbox.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/box/box.js')}}" type="text/javascript"></script>--}}

    @publishedModule("siteAds")
        <script>
            var siteads_getData = "{{route('siteAds.getData')}}",
                siteads_impClick = "{{route('siteAds.impClick')}}"
        </script>
        <script src="{{asset('assets/js/front/siteAds/getAds.js')}}" type="text/javascript"></script>
    @endpublishedModule

    {!! $page->script !!}
@endsection
