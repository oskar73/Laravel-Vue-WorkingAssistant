@extends('layouts.app')

@section('title', 'Portfolios')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/lightgallery/css/lightgallery.min.css')}}">
@endsection
@section('content')
    <x-front.portfolio-hero></x-front.portfolio-hero>

    <div class="container pb-5">
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item"><a href="{{route('portfolio.index')}}">Portfolios</a></li>
            @if($item->category->category->name!==null)
                <li class="breadcrumb-item"><a href="{{route('portfolio.index')}}#/{{$item->category->category->slug}}">{{$item->category->category->name}}</a></li>
            @endif
            <li class="breadcrumb-item active"><a href="{{route('portfolio.index')}}#/{{$item->category->slug}}">{{$item->category->name}}</a></li>
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

                    <div class="margin-20px-bottom white-space-pre-line">
                        {{ $item->description }}
                    </div>

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
                    <x-front.socialShare></x-front.socialShare>

                </div>
            </div>
        </div>

        <x-front.gallery :item="$item" :order="$item->order"></x-front.gallery>

        @publishedModule("review")
            <x-front.reviewForm type="portfolio" :id="$item->id"></x-front.reviewForm>
        @endpublishedModule

    </div>

@endsection
@section('script')
    <script src="{{asset('assets/vendors/lightgallery/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('assets/js/front/portfolio/detail.js')}}"></script>
    @publishedModule("review")
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <script>
            var get_review = "{{route('review.index')}}",
                type = "portfolio",
                model_id="{{$item->id}}";
        </script>
        <script src="{{asset('assets/js/front/review/getReview.js')}}"></script>
    @endpublishedModule
@endsection
