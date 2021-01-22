
@forelse($listings as $key=>$listing)
    @if($key==0) <div class="col-md-12 directory-ads-position-1118"></div> @endif
    @if($key==4) <div class="col-md-12 directory-ads-position-1119"></div> @endif
    <div class="col-md-12">
        <a href="{{route('directory.detail', $listing->slug)}}" class="directory_listing_item_div {{$listing->featured=='1'? 'featured':''}}">
            @if($listing->featured=='1')
                <div class="featuredRibbons">
                    <span>Featured</span>
                </div>
            @endif
            @if($listing->isProperty("thumbnail"))
            <div class="directory_thum_area w-150px min-width-150px">

                <figure data-href="{{$listing->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace mb-0">
                    <img src="{{$listing->getFirstMediaUrl('thumbnail', 'thumb')}}"
                         alt="{{$listing->title}}"
                         class=" preview"
                    >
                </figure>

            </div>
            @endif
            <div class="description_area pl-3">
                <p class="directory_listing_title">
                    {{$listing->title}}
                </p>
                <div class="description_strip">
                    {!! extractDesc($listing->description, 350) !!}
                </div>
                <p class="text_posted_on">
                   Posted on {{$listing->created_at->toDateTimeString()}}
                </p>
            </div>
        </a>
    </div>
@empty
    <div class="col-md-12 text-center mt-3">
        No listings.
    </div>
@endforelse
<div class="col-md-12 d-flex justify-content-center mt-3">
    {{ $listings->links() }}
</div>


