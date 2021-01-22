@extends('layouts.app')

@section('title', $category->name)

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
    @livewireStyles
@endsection
@section('content')
    <x-front.blog-hero></x-front.blog-hero>

    <div class="blog_template2">
        <div class="container-fluid mt-3" >
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <x-front.blog-nav></x-front.blog-nav>
                </div>
            </div>
            <div class="row mt-5 blog_search_remove_section">
                <div class="col-lg-2">
                    <div class="blog-ads-position-11117 text-right"></div>
                </div>
                <div class="col-lg-8 content">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="p-area-title font-size30">{{$category->name}}</h1>
                            <figure data-href="{{$category->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item mb-3">
                                <img src="{{$category->getFirstMediaUrl("image", "thumb")}}" alt="{{$category->name}}" class="preview">
                            </figure>
                            <div class="description my-3 white-space-pre-line">
                                {{$category->description}}
                            </div>
                            <p class="p-area-title font-size24">Posts ({{$category->visible_posts_count}})</p>
                            <div class="blog-ads-position-11119"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="blog-ads-position-11116"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="blog-ads-position-11115"></div>
                                </div>
                            </div>
                            <div class="all_category_post_area">
                                <div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="blog-ads-position-11112"></div>
                            <x-front.template2.blog-popular></x-front.template2.blog-popular>

                            <div class="blog-ads-position-11113"></div>
                            <div class="single_sidebar_wiget">
                                <div class="sidebar_tittle">
                                    <h3 class="font-weight-bold">Subscribe to this <br> category.</h3>
                                </div>
                                <div class="mb-3">To get notification about update, comments to this category, please subscribe.</div>
                                <div class="text-center">
                                    <livewire:subscribe-category :category="$category" />
                                </div>
                            </div>

                            <div class="blog-ads-position-11114"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="blog-ads-position-11118"></div>
                </div>
            </div>
        </div>
        <div class="blog_append_section"></div>
    </div>
@endsection
@section('script')
    @livewireScripts
    <script>
        var ads_type="category",
            ads_item_id="{{$category->id}}",
            blog_AjaxCategory = "{{route('blog.ajaxCategory', $category->id)}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/category.js')}}"></script>
    @publishedModule("blogAds")
        <script>var blogAds_getData="{{route('blogAds.getData')}}", blogAds_impClick="{{route('blogAds.impClick')}}";</script>
        <script src="{{asset('assets/js/front/blogAds/getAds.js')}}"></script>
    @endpublishedModule
@endsection
