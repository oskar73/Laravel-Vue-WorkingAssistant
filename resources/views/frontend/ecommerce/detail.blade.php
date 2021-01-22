@extends('layouts.app')

@section('title', 'Product-')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/lightgallery/css/lightgallery.min.css')}}">
@endsection
@section('content')
    <x-front.ecommerce-hero></x-front.ecommerce-hero>

    <div class="container pb-5">
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item"><a href="{{route('ecommerce.index')}}">All Products</a></li>
            @if($item->category->category->name!==null)
                <li class="breadcrumb-item"><a href="{{route('ecommerce.index')}}#/{{$item->category->category->slug}}">{{$item->category->category->name}}</a></li>
            @endif
            <li class="breadcrumb-item active"><a href="{{route('ecommerce.index')}}#/{{$item->category->slug}}">{{$item->category->name}}</a></li>
        </ol>
        <div class="row mt-5">
            <div class="col-md-6 mb-5 mb-md-0">
                <a href="{{$item->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                    <img src="{{$item->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$item->title}}" class="w-100 preview">
                </a>
            </div>
            <div class="col-md-6">
                <div class="product-detail">
                    <h3 class="margin-8px-bottom">
                        {{$item->title}} @if($item->featured)<span class="label-sale bg-theme text-white text-uppercase font-size14">Featured</span> @endif
                    </h3>

                    <div class="bg-theme separator-line-horrizontal-full margin-20px-bottom"></div>


                    @publishedModule("review")
                    <div class="margin-20px-bottom">
                        <div class="d-inline-block margin-15px-right padding-15px-right border-right border-color-extra-medium-gray">
                            <div id="review_rating"></div>
                        </div>
                        <div class="d-inline-block">
                            <a class="text-theme-color" href="#review">Write a review</a>
                        </div>
                    </div>
                    @endpublishedModule

                    <div class="margin-20px-bottom">
                        @if($price->slashed_price!==null)
                            <span class="slashed_price_text margin-15px-right font-size18 font-weight-600 offer-price ">
                                $<span class="i_slashed_price_area">{{formatNumber($price->slashed_price)}}</span>
                            </span>
                        @endif
                        <span class="font-size18 font-weight-700 text-theme-color">
                            $<span class="i_price_area">{{formatNumber($price->price)}}</span>
                            @if($price->recurrent) / {{periodName($price->period, $price->period_unit)}} (Subscription)@endif
                        </span>
                    </div>
                    @if($item->size)
                       <p>Size</p>
                        @foreach($item->sizes as $size)
                           <span class="variant_size_item variant_select_item" data-variant="size" data-id="{{$size->id}}">{{$size->name}}</span>
                        @endforeach
                    @endif
                    @if($item->color)
                        <p>Color</p>
                        @foreach($item->colors as $color)
                            <span class="variant_color_item variant_select_item" data-variant="color"  data-id="{{$color->id}}">{{$color->name}}</span>
                        @endforeach
                    @endif
                    @if($item->variant)
                        <p>{{$item->variant_name}}</p>
                        @foreach($item->variants as $variant)
                            <span class="variant_custom_item variant_select_item"  data-variant="custom" data-id="{{$variant->id}}">{{$variant->name}}</span>
                        @endforeach
                    @endif
                    <div class="row mt-3">
                        <div class="col-4 col-lg-2">
                            <label>Qty:</label>
                            <input type="number" value="1" placeholder="1" class="margin-20px-bottom fcustom-input" name="quantity" id="quantity">
                        </div>
                    </div>

                    <div class="margin-20px-bottom white-space-pre-line">
                        {!! $item->description !!}
                    </div>
                    <div class="row margin-20px-bottom">
                        <div class="col-lg-12">
                            <a href="javascript:void(0);" class="butn theme margin-15px-right xs-margin-10px-bottom addToCartBtn toggleBtn" data-cart="0">
                                <span><i class="fas fa-shopping-cart margin-5px-right"></i> Add to Cart</span>
                            </a>
                            <a href="{{route('cart.index')}}" class="butn theme margin-15px-right xs-margin-10px-bottom toggleBtn d-none">
                                <span> Go to Cart <i class="fas fa-arrow-right margin-5px-left"></i></span>
                            </a>
                            <button class="butn text-uppercase addToCartBtn" data-cart="1"><span> Buy Now</span></button>
                        </div>
                    </div>

                    <x-front.socialShare></x-front.socialShare>

                </div>
            </div>
        </div>

        <x-front.gallery :item="$item" :order="$item->order"></x-front.gallery>

        @publishedModule("review")
            <x-front.reviewForm type="ecommerce" :id="$item->id"></x-front.reviewForm>
        @endpublishedModule
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/lightgallery/js/lightgallery-all.min.js')}}"></script>
    <script>
        var add_to_cart_url = "{{route('ecommerce.addtocart', $item->slug)}}",
            mix = @JSON($mix),
            d_price="{{$price->price}}",
            d_slashed_price="{{$price->slashed_price}}",
            is_size = "{{$item->size}}",
            is_color = "{{$item->color}}",
            is_custom = "{{$item->variant}}",
            custom_name = "{{$item->variant_name}}"
    </script>
    <script src="{{asset('assets/js/front/ecommerce/detail.js')}}"></script>
    @publishedModule("review")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        var get_review = "{{route('review.index')}}",
            type = "ecommerce",
            model_id="{{$item->id}}";
    </script>
    <script src="{{asset('assets/js/front/review/getReview.js')}}"></script>
    @endpublishedModule
@endsection
