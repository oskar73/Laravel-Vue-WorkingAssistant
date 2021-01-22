@php
    if($listing_type=='default')
    {
        $type = $spot->parentType;
    }else{
        $type = json_decode($listing->type);
    }
@endphp
<div class="d-inline-block position-relative mb-2 droppable-disabled">
    @if($listing_type=='default'&&$listing->google_ads==1)
        <div style="width:{{$type->width}}px;height:{{$type->height}}px">
            {!! $listing->code !!}
        </div>
    @else
        <div
           class="position-relative ad_preview_div h-move d-flex droppable-disabled"
        >
            <div class="img_preview_div d-inline-block position-relative droppable-disabled"
                 style="width:{{$type->width}}px;height:{{$type->height}}px;background:{{$listing->getFirstMediaUrl("image")? 'url('.$listing->getFirstMediaUrl("image").')':'#80ff00'}}"
            >
                @if($type->title_char!=0&&$listing->title!=null)
                    <p class="title_pos pos_center">{{$listing->title}}</p>
                @endif
            </div>
            @if($type->text_char!=0&&$listing->text!=null)
                <p class="text_pos mb-0">{{$listing->text}}</p>
            @endif
        </div>
    @endif
    <div>
        @if($listing_type=='listing'&&$listing->cta_action)
            <span class="blog_sponsored_btn float-left h-cursor blogAds-click-funnel" data-url="{{$listing->cta_url}}" data-id="{{$listing->id}}">{{$listing->cta_type}}</span>
        @endif
        @if($spot->sponsored_visible)
            <a href="{{route('siteAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
        @endif
        <div class="clearfix droppable-disabled"></div>
    </div>
</div>
