@extends('layouts.app')

@section('title', $tag->name)

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')
    <x-front.blog-hero></x-front.blog-hero>

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
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="p-area-title font-size30">{{$tag->name}} ({{$tag->visible_posts_count}})</h1>
                        <div class="blog-ads-position-11119"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="blog-ads-position-11116"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="blog-ads-position-11115"></div>
                            </div>
                        </div>

                        <div class="all_tag_post_area">
                            <div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog-ads-position-11112"></div>

                        <x-front.blog-popular></x-front.blog-popular>

                        <div class="blog-ads-position-11113"></div>

                        <x-front.blog-discussed></x-front.blog-discussed>

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
@endsection
@section('script')
    <script>
        var ads_type="tag",
            ads_item_id="{{$tag->id}}",
            blog_ajaxTag = "{{route("blog.ajaxTag", $tag->id)}}"
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/tag.js')}}"></script>
    @publishedModule("blogAds")
        <script>var blogAds_getData="{{route('blogAds.getData')}}", blogAds_impClick="{{route('blogAds.impClick')}}";</script>
        <script src="{{asset('assets/js/front/blogAds/getAds.js')}}"></script>
    @endpublishedModule
@endsection
