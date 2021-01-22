@extends('layouts.app')

@section('title', $page->name)

@section('style')
{{--    <link href="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.css')}}" rel="stylesheet" type="text/css" />--}}
    <style>
        .out_content{ background-color:{{$data['back_color']?? 'fff'}}; }
        #wholecontainer {margin:auto;max-width: @if($data['width']=='100%'){{'100%'}} @elseif($data['width']==null){{'1200px'}} @else {{$data['width'].'px'}} @endif; }
        #site-ads-spot-{{$position_id}} .ad_preview_div {border:1px solid green;}
    </style>
    {!! $page->css !!}

@endsection
@section('content')
    <div class="out_content overflow-hidden min-vh-100">
        <div id="wholecontainer">
            @if($spot->position_id==null)
                <div class="site_ads_spot_area drag" id="site-ads-spot-{{$position_id}}" contenteditable="false">
                    <div
                        contenteditable="false"
                        class="ad_preview_div"
                        style="
                            border:1px solid #13ae10;
                            background:{{$spot->gag->getFirstMediaUrl("image")? 'url('.$spot->gag->getFirstMediaUrl("image").')':'#80ff00'}};
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            cursor:move;
                            width:{{$spot->parentType->width}}px;
                            height:{{$spot->parentType->height}}px;
                            "
                    >
                    </div>
                    <div class="mb-2" contenteditable="false">
                        @if($spot->sponsored_visible)
                            <span class="blog_sponsored_btn float-right" contenteditable="false">Sponsored</span>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endif

            @if(empty($page->content)==true||$page->type=='box')
               @include('components.admin.defaultBuilder')
            @else
                {!! $page->content !!}
            @endif
        </div>
    </div>

    <div class="control-panel">
        <div>Control Panel</div><br>

        <form action="{{route('admin.siteAds.spot.updatePosition', $spot->id)}}" id="controlForm" method="post">
            @csrf
            <a href="{{route('admin.siteAds.spot.edit', $spot->id)}}" class="btn-primary btn-white m-btn--square btn-sm">Back</a><br><br>
            <button type="submit" id="btnSave" class="btn-success m-btn--square btn-sm">SAVE</button><br><br>
            <div>
                <label>
                    <input type="checkbox" id="getcheckbox" name="fullWidth" onclick="switchWidth()" @if($data['width']=='100%')checked @endif>
                    FullWidth
                </label>
            </div>
            <div class="max-area" style="display:{{$data['width']=='100%'? 'none': 'block'}}">
                <div>MaxWidth</div>
                <input type="number" id="max-width" name="maxWidth" class="form-control m-input m-input--square box_input"
                       value="@if($data['width']!='100%'&&$data['width']!=null){{$data['width']}}@else{{'1200'}}@endif"
                       onchange="changeWidth()" step="50">
            </div>
            <div class="color-area">
                <div>Background</div>
                <input type="text" id="back_color" name="back_color" autocomplete="off" class="form-control m-input m-input--square box_input"
                       value="{{$data['back_color']?? '#ffffff'}}">
            </div>
            <input type="hidden" id="inpHtml" name="inpHtml"/>
            <input type="hidden" id="position_id" name="position_id" value="{{$position_id}}"/>
        </form>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
{{--    <script src="{{asset('assets/vendors/contentbuilder/contentbuilder/contentbuilder.min.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('assets/vendors/contentbuilder/assets/minimalist-blocks/content.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('assets/vendors/colorpicker/jqColorPicker.min.js')}}"></script>
    <script> var $path = "{{asset('/')}}", page_id = "{{$page->id}}"</script>
    <script src="{{asset('assets/js/admin/siteAds/spotPositionBuilder.js')}}"></script>
    {!! $page->script !!}
@endsection

