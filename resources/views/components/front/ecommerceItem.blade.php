<ul class="breadcrumb">
    {!! $title !!}
</ul>
@if($category!==null)
    <a href="{{$category->getFirstMediaUrl('image')}}" class="w-100 progressive replace">
        <img src="{{$category->getFirstMediaUrl('image', 'thumb')}}"
             alt="{{$category->name}}"
             class=" preview"
        >
    </a>
    <div class="mt-5 white-space-pre-line">
        {{$category->description}}
    </div>
@endif
<div class="row mt-5">
    @forelse($items as $key=>$item)
        <div class="col-lg-3 col-md-4 mb-2">
            <div class="project-grid-style3 ">
                <a href="{{route('ecommerce.detail', $item->slug)}}" class="inner-box">
                    <div class="position-relative">
                        <div class="position-absolute z-index-99 w-100 p-2">
                            @if($item->featured) <span class="float-left text-success border-all pl-1 pr-1 border-success"> Featured </span> @endif
                            @if($item->new) <span class="float-right text-danger border-all pl-1 pr-1 border-danger"> New </span> @endif
                        </div>
                        <figure data-href="{{$item->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                            <img src="{{$item->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$item->title}}" class="preview w-100"/>
                        </figure>
                        <div class="overlay">
                            <div class="overlay-inner">
                                <div class="description">
                                    <div class="text">{{$item->title}}</div>
                                    <div  class="read-more"><span class="fa fa-angle-right"></span> See detail</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-desc">
                        <div class="category">{{$item->title}}</div>

                        <div class="price_area mt-3 font-size18">
                            <div class="text-dark">
                                @if($item->standardPrice->slashed_price!==null)
                                    <span class="slashed_price_text ml-1 font-size16">
                                        ${{formatNumber($item->standardPrice->slashed_price)}}
                                    </span>
                                @endif
                                ${{formatNumber($item->standardPrice->price)}}
                                @if($item->standardPrice->recurrent) / {{periodName($item->standardPrice->period, $item->standardPrice->period_unit)}} @endif
                            </div>
                        </div>
                        <div class="button_area">
                            <span class="btn btn-success m-auto border-radius-none font-size12 py-1 border-radius-0 px-3 w-100" data-id="{{$item->id}}">
                                View Detail
                            </span>
{{--                            <span class="btn btn-success m-auto border-radius-none add_to_cart font-size12 py-1 border-radius-0 px-3 w-100" data-id="{{$item->id}}">--}}
{{--                                <i class="fas fa-shopping-cart margin-5px-right"></i> View Detail--}}
{{--                            </span>--}}
{{--                            <span class="btn btn-success m-auto border-radius-none d-none gotocart font-size12 py-1 border-radius-0 px-3 w-100">--}}
{{--                                Go to cart <i class="fas fa-arrow-right margin-5px-left"></i>--}}
{{--                            </span>--}}
                        </div>

                    </div>
                </a>
            </div>
        </div>
    @empty
        <div class="col-md-12 text-center">
            <h3>No item..</h3>
        </div>
    @endforelse
</div>
<div>
    {{ $items->links() }}
</div>
