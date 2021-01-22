@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Directory Listing')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
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
                        <h3 class="text-center w-100">Browser by Category</h3>
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-4 mt-3">
                                    <a href="{{route('directory.category', $category->slug)}}" class="d-block position-relative hover-box-3 hover-overlay-show">
                                        <figure data-href="{{$category->getFirstMediaUrl('image')}}" class="w-100 progressive replace">
                                            <img src="{{$category->getFirstMediaUrl('image', 'thumb')}}"
                                                 alt="{{$category->name}}"
                                                 class=" preview"
                                            >
                                        </figure>
                                        <div class="overlay"></div>
                                        <div class="absolute-item-center"><span class="text-shadow">{{$category->name}} ({{$category->approved_items_count}})</span></div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="directory-ads-position-1112 text-center"></div>

                    <div class="directory_item_area">
                        <div class="row featured_listing_area">
                            <div class="text-center w-100">
                                <i class="fa fa-spin fa-spinner fa-2x"></i>
                            </div>
                        </div>
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
    <input type="hidden" id="category_id" value="0">
    <input type="hidden" id="tag_id" value="0">
    <input type="hidden" id="disable_listings" value="0">
    <input type="hidden" id="adtype" value="home">
    <input type="hidden" id="adid" value="0">
@endsection
@section('script')
    <script>var directory_url = "{{route('directory.index')}}"</script>
    <script src="{{asset('assets/js/front/directory/index.js')}}"></script>
    @publishedModule("directoryAds")
        <script>var directoryads_getData = "{{route('directoryAds.getData')}}"</script>
        <script src="{{asset('assets/js/front/directoryAds/get.js')}}"></script>
    @endpublishedModule
@endsection
