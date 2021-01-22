@php
    if($listing_type=='default')
    {
        $type = json_decode($spot->type);
    }else{
        $type = json_decode($listing->type);
    }
@endphp
@if(in_array($spot->position->position_id, [8,9]))
    @if($listing_type=='default'&&$listing->google_ads==1)
        <div style="width:{{$type->width}}px;height:{{$type->height}}px">
            {!! $listing->code !!}
        </div>
    @else
        <a href="{{$listing->url}}" class="directory_listing_item_div sponsored {{$listing_type=='listing'? 'directoryAds-click-funnel':''}}">
            <div class="sponsoredRibbons">
                <span>Sponsored</span>
            </div>
            <div class="directory_thum_area w-150px min-width-150px">

                <figure data-href="{{$listing->getFirstMediaUrl("image")}}" class="w-100 progressive replace mb-0">
                    <img src="{{$listing->getFirstMediaUrl("image")}}"
                         class=" preview"
                    >
                </figure>
            </div>
            <div class="description_area pl-3">
                <p class="directory_listing_title">
                    {{$listing->title}}
                </p>
                <div class="description_strip">
                    {!! extractDesc($listing->text, 350) !!}
                </div>
                <p class="text_posted_on">
                    Posted on {{$listing->created_at->toDateTimeString()}}
                </p>
            </div>
        </a>
    @endif
@else
    <div class="d-inline-block position-relative mb-2">
        @if($listing_type=='default'&&$listing->google_ads==1)
            <div style="width:{{$type->width}}px;height:{{$type->height}}px">
                {!! $listing->code !!}
            </div>
        @else
                <a href="{{$listing->url}}"
                   class="d-inline-block position-relative ad_preview_div h-cursor {{$listing_type=='listing'? 'directoryAds-click-funnel':''}} "
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
                <a href="{{route('directoryAds.spot', $spot->slug)}}" class="blog_sponsored_btn float-right">Sponsored</a>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@endif
