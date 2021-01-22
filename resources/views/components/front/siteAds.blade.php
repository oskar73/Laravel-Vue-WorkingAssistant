@php
    if($listing_type=='default')
    {
        $type = $spot->parentType;
    }else{
        $type = json_decode($listing->type);
    }
@endphp
<div class="d-inline-block position-relative mb-2">
    @if($listing_type=='default'&&$listing->google_ads==1)
        <div style="width:{{$type->width}}px;height:{{$type->height}}px">
            {!! $listing->code !!}
        </div>
    @else
        <a href="{{$listing->url}}"
           class="d-inline-block position-relative ad_preview_div h-cursor {{$listing_type=='listing'? 'siteAds-click-funnel':''}} "
           data-url="{{$listing->url}}"
           data-id="{{$listing->id}}"
           target="_blank"
        >
            <div class="img_preview_div d-inline-block position-relative">
                @if($type->title_char!=0&&$listing->title!=null)
                    <p class="title_pos pos_center">{{$listing->title}}</p>
                @endif
                <img src="{{$listing->getFirstMediaUrl("image")}}" id="preview_img" >
            </div>
            @if($type->text_char!=0&&$listing->text!=null)
                <p class="text_pos mb-0">{{$listing->text}}</p>
            @endif
        </a>
    @endif
    <div class="mb-2">
        @if($listing_type=='listing'&&$listing->cta_action)
            <span class="blog_sponsored_btn float-left h-cursor siteAds-click-funnel" data-url="{{$listing->cta_url}}" data-id="{{$listing->id}}">{{$listing->cta_type}}</span>
        @endif
        @if($spot->sponsored_visible)
            <a href="{{route('siteAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
        @endif
        <div class="clearfix"></div>
    </div>
</div>
