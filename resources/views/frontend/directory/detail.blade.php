@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Directory Listing')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/lightgallery/css/lightgallery.min.css')}}">
@endsection
@section('content')

    <x-front.directory-hero></x-front.directory-hero>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="directory-ads-position-1114 text-right"></div>
                <div class="directory-ads-position-1115 text-right"></div>
            </div>
            <div class="col-lg-8">

                <x-front.directory-nav></x-front.directory-nav>

                <div class="search_append_area py-4">
                    <div class="directory-ads-position-1111 text-center"></div>
                    <div class="directory_category_area">
                        <a href="{{route('directory.index')}}"><i class="fa fa-home"></i></a>
                        @if($listing->category->category->name!==null)
                        &rarr; <a href="{{route('directory.category', $listing->category->category->slug)}}">{{$listing->category->category->name}}</a>
                        &rarr; <a href="{{route('directory.subCategory', ['category'=>$listing->category->category->slug, 'subCategory'=>$listing->category->slug])}}">{{$listing->category->name}}</a>
                        @else
                        &rarr; <a href="{{route('directory.category', $listing->category->slug)}}">{{$listing->category->name}}</a>
                        @endif
                    </div>
                    <div class="directory-ads-position-1112 text-center"></div>
                    <div class="directory_item_area ">
                        <div class="directory_listing_detail_area">
                            @if($listing->new)
                            <span class="py-1 px-3 border-color-new font-size14">New</span>
                            @endif
                            @if($listing->featured)
                            <span class="py-1 px-3 border-color-featured font-size14">Featured</span>
                            @endif
                            <div class="d-flex justify-content-between">
                                <h1>
                                    {{$listing->title}}
                                </h1>
                               <div>
                                   <a href="{{$listing->url}}" class="btn btn-outline-info">Visit Site <i class="fa fa-external-link-alt"></i></a>
                               </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="h-30px">
                                    @publishedModule("review")
                                        <div class="d-inline-block" id="review_rating"></div>
                                        <div class="d-inline-block">  (<span class="review_count">0</span> <a href="#review">Reviews</a>)</div>
                                    @endpublishedModule
                                </div>
                                <div class="position-relative social-share-area">
                                    <div class="share position-absolute bottom-0 right-0">
                                        <x-front.socialShare></x-front.socialShare>
                                    </div>
                                </div>
                            </div>

                            <hr class="m-0">
                            <div class="description">
                                {!! $listing->description !!}
                            </div>
                            <div class="gallery_area">
                                <x-front.gallery :item="$listing" :order="$listing->order"></x-front.gallery>
                            </div>
                            <div class="text_posted_on">
                                Posted on {{$listing->created_at->toDateTimeString()}}
                            </div>
                                <br>
                            <a href="{{$listing->url}}" class="btn btn-outline-info">Visit Site <i class="fa fa-external-link-alt"></i></a>
                        </div>
                        @publishedModule("review")
                            <x-front.reviewForm type="directory" :id="$listing->id"></x-front.reviewForm>
                        @endpublishedModule
                    </div>
                    <div class="directory-ads-position-1113 text-center"></div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="directory-ads-position-1116 text-left"></div>
                <div class="directory-ads-position-1117 text-left"></div>
            </div>
        </div>
    </div>
    <input type="hidden" id="tag_id" value="0">
    <input type="hidden" id="category_id" value="0">
    <input type="hidden" id="disable_listings" value="1">

    <input type="hidden" id="adtype" value="detail">
    <input type="hidden" id="adid" value="{{$listing->category->category->id?? $listing->category->id}}">
@endsection
@section('script')
    <script src="{{asset('assets/vendors/lightgallery/js/lightgallery-all.min.js')}}"></script>
    <script>
        var directory_url = "{{route('directory.index')}}"
    </script>
    <script src="{{asset('assets/js/front/directory/index.js')}}"></script>
    <script src="{{asset('assets/js/front/directory/detail.js')}}"></script>
    @publishedModule("directoryAds")
        <script>var directoryads_getData = "{{route('directoryAds.getData')}}"</script>
        <script src="{{asset('assets/js/front/directoryAds/get.js')}}"></script>
    @endpublishedModule
    @publishedModule("review")
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <script>
            var get_review = "{{route('review.index')}}",
                type = "directory",
                model_id="{{$listing->id}}";
        </script>
        <script src="{{asset('assets/js/front/review/getReview.js')}}"></script>
    @endpublishedModule
@endsection
