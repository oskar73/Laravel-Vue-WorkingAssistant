@extends('layouts.footerApp')

@section('title', "Footer")

@section('style')
    <link href="{{asset('assets/vendors/contentbuilder/box/box.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simplelightbox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.css')}}" rel="stylesheet" type="text/css" />
    @if($footer->mainCss!=null)
        {!! $footer->mainCss !!}
    @endif
    @if($footer->sectionCss!=null)
        {!! $footer->sectionCss !!}
    @endif

    {!! $footer->css !!}
@endsection
@section('content')
    <div class="is-wrapper">
        @if(empty($footer->content))
            @include('components.admin.defaultFooter')
        @else
            {!! $footer->content !!}
        @endif
    </div>

    <div class="control-panel">
        <div>Control Panel</div><br>

        <form action="{{route('admin.content.footer.store')}}" id="controlForm" method="post">
            @csrf
            <a href="{{route('admin.content.header.index')}}" class="btn-primary text-white m-btn--square btn-sm">Back</a>
            <button type="submit" id="btnSave" class="btn-success m-btn--square btn-sm">SAVE</button><br><br>
        </form>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/contentbuilder/assets/scripts/simplelightbox/simple-lightbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/contentbuilder/contentbox/contentbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.js')}}" type="text/javascript"></script>
    <script> var $path = "{{asset('/')}}", page_id=0</script>
    <script src="{{asset('assets/js/admin/content/footer.js')}}"></script>
    <script src="{{asset('assets/vendors/contentbuilder/box/box.js')}}" type="text/javascript"></script>
    {!! $footer->script !!}
@endsection
