@php
    if($listing_type=='default')
    {
        $type = json_decode($spot->type);
    }else{
        $type = json_decode($listing->type);
    }
@endphp
@if(in_array($spot->position->position_id, [1,2]))
    @if($listing_type=='default'&&$listing->google_ads==1)
        <div style="width:{{$type->width}}px;height:{{$type->height}}px">
            {!! $listing->code !!}
        </div>
    @else
        <a href="{{$listing->url}}"
           class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px {{$listing_type=='listing'? 'blogAds-click-funnel':''}}"
           data-url="{{$listing->url}}"
           data-id="{{$listing->id}}"
           target="_blank"
        >
            <figure data-href="{{$listing->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                <img src="{{$listing->getFirstMediaUrl("image")}}" class="preview img-bg-effect">
            </figure>
            @if(($type->title_char!=0&&$listing->title!=null)||($type->text_char!=0&&$listing->text!=null))
                <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                    <p class="blog_title_medium">{{$listing->title}}</p>
                    <p class="blog_title_medium">{{$listing->text}}</p>
                </div>
            @endif
        </a>
    @endif
    <div class="position-absolute bottom-5 z-index-1111 left-5 right-5">
        @if($listing_type=='listing'&&$listing->cta_action)
            <span class="blog_sponsored_btn float-left h-cursor blogAds-click-funnel" data-url="{{$listing->cta_url}}" data-id="{{$listing->id}}">{{$listing->cta_type}}</span>
        @endif
        @if($spot->sponsored_visible)
            <a href="{{route('blogAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
        @endif
        <div class="clearfix"></div>
    </div>
@elseif(in_array($spot->position->position_id, [6,7, 15, 16]))
    @if($listing_type=='default'&&$listing->google_ads==1)
        <div style="width:{{$type->width}}px;height:{{$type->height}}px">
            {!! $listing->code !!}
        </div>
    @else
        <a href="{{$listing->url}}"
            class="{{$listing_type=='listing'? 'blogAds-click-funnel':''}}"
           data-url="{{$listing->url}}"
           data-id="{{$listing->id}}"
           target="_blank"
        >
            <figure data-href="{{$listing->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item mb-0">
                <img src="{{$listing->getFirstMediaUrl("image")}}" class="preview">
                @if(($type->title_char!=0&&$listing->title!=null)||($type->text_char!=0&&$listing->text!=null))
                    <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                        <p class="blog_title_medium">{{$listing->title}}</p>
                        <p class="blog_title_medium">{{$listing->text}}</p>
                    </div>
                @endif
            </figure>
        </a>
    @endif
        <div class="mb-1">
            @if($listing_type=='listing'&&$listing->cta_action)
                <span class="blog_sponsored_btn float-left h-cursor blogAds-click-funnel" data-url="{{$listing->cta_url}}" data-id="{{$listing->id}}">{{$listing->cta_type}}</span>
            @endif
            @if($spot->sponsored_visible)
                <a href="{{route('blogAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
            @endif
            <div class="clearfix"></div>
        </div>
@else
    <div class="d-inline-block position-relative mb-2">
        @if($listing_type=='default'&&$listing->google_ads==1)
            <div style="width:{{$type->width}}px;height:{{$type->height}}px">
                {!! $listing->code !!}
            </div>
        @else
                <a href="{{$listing->url}}"
                   class="d-inline-block position-relative ad_preview_div h-cursor {{$listing_type=='listing'? 'blogAds-click-funnel':''}} "
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
                <span class="blog_sponsored_btn float-left h-cursor blogAds-click-funnel" data-url="{{$listing->cta_url}}" data-id="{{$listing->id}}">{{$listing->cta_type}}</span>
            @endif
            @if($spot->sponsored_visible)
                <a href="{{route('blogAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@endif
