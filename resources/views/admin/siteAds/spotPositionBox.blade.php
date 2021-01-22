@extends('layouts.app')

@section('title', $page->name)

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
    <style>
        #site-ads-spot-{{$position_id}} .ad_preview_div {border:1px solid green;}
    </style>
    {!! $page->css !!}
@endsection
@section('content')
    <div class="is-wrapper" id="builder">
        @if($spot->position_id==null)
            <div class="site_ads_spot_area drag" id="site-ads-spot-{{$position_id}}" contenteditable="false">
                <div
                    contenteditable="false"
                    class="ad_preview_div"
                    style="border:1px solid #13ae10;background-color:#80ff00;display:flex;align-items:center;justify-content:center;cursor:move;width:{{$spot->parentType->width}}px;height:{{$spot->parentType->height}}px"
                >
                    Put this spot to any position
                </div>
                <div class="mb-2" contenteditable="false">
                    @if($spot->sponsored_visible)
                        <span class="blog_sponsored_btn float-right" contenteditable="false">Sponsored</span>
                    @endif
                </div>
            </div>
        @endif

        @if(empty($page->content)==true||$page->type=='builder')
            @include('components.admin.defaultBox')
        @else
            {!! $page->content !!}
        @endif
    </div>

    <div class="control-panel">
        <div>Control Panel</div><br>

        <form action="{{route('admin.siteAds.spot.updatePosition', $spot->id)}}" id="controlForm" method="post">
            @csrf
            <input type="hidden" id="position_id" name="position_id" value="{{$position_id}}"/>
            <a href="{{route('admin.siteAds.spot.edit', $spot->id)}}" class="btn-primary text-white m-btn--square btn-sm">Back</a><br><br>
            <button type="submit" id="btnSave" class="btn-success m-btn--square btn-sm">SAVE</button><br><br>
        </form>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
{{--    <script src="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simple-lightbox.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.js')}}" type="text/javascript"></script>--}}
    <script> var $path = "{{asset('/')}}", page_id = {{$page->id}}</script>
    <script src="{{asset('assets/js/admin/siteAds/spotPositionBox.js')}}"></script>
{{--    <script src="{{asset('assets/vendors/contentbuilder/box/box.js')}}" type="text/javascript"></script>--}}
    {!! $page->script !!}
@endsection
