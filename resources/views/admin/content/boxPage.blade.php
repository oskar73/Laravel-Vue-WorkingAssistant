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
    {!! $page->css !!}
@endsection
@section('content')
    <div class="is-wrapper" id="builder">
        @if(empty($page->content)==true||$page->type=='builder')
            @include('components.admin.defaultBox')
        @else
            {!! $page->content !!}
        @endif
    </div>

    <div class="control-panel">
        <div>Control Panel</div><br>

        <form action="{{route('admin.content.page.updateContent', ['id'=>$page->id, 'type'=>'box'])}}" id="controlForm" method="post">
            @csrf

            <a href="{{route('admin.content.page.editContent', ['id'=>$page->id, 'type'=>'builder'])}}" class="text-underline switch_a">&#x000AB; Free Style </a><br><br>
            <a href="{{route('admin.content.page.edit', $page->id)}}" class="btn-primary text-white m-btn--square btn-sm">Back</a><br><br>
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
    <script src="{{asset('assets/js/admin/content/boxPage.js')}}"></script>
{{--    <script src="{{asset('assets/vendors/contentbuilder/box/box.js')}}" type="text/javascript"></script>--}}
    {!! $page->script !!}
@endsection
