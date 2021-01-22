<div class="row mt-5">
    @forelse($items as $item)
        <div class="col-lg-4 mb-5  m-auto">
            <div class="project-grid-style3">
                <a href="{{route('directory.package.detail', $item->slug)}}" class="inner-box">
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
                                    <div class="text">{{\Str::limit($item->description, 300)}}</div>
                                    <div  class="read-more"><span class="fa fa-angle-right"></span> See detail</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-desc  pb-2">
                        <div class="category">{{$item->name}}</div>
                        <div class="price_area mt-3 font-size18">
                            <div class="text-dark">

                                @if($item->standardPrice)
                                    @if($item->standardPrice->slashed_price!==null)
                                        <span class="slashed_price_text ml-1 font-size16">
                                                ${{formatNumber($item->standardPrice->slashed_price)}}
                                            </span>
                                    @endif
                                    ${{formatNumber($item->standardPrice->price)}}
                                    @if($item->standardPrice->recurrent) / {{periodName($item->standardPrice->period, $item->standardPrice->period_unit)}} @endif
                                @else
                                    Unset Price
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="btn btn-success m-1 border-radius-0 add_to_cart font-size12" data-id="{{$item->id}}">
                                <i class="fas fa-shopping-cart margin-5px-right"></i> Add to cart
                            </span>
                            <span class="btn btn-success m-1 border-radius-none d-none gotocart font-size12">
                                Go to cart <i class="fas fa-arrow-right margin-5px-left"></i>
                            </span>
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
