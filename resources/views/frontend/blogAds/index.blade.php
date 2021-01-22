@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog Advertisement Spots')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')

    <x-front.blog-ads-hero></x-front.blog-ads-hero>

    <div class="container pt-5 pb-5" >
        <x-front.blog-nav></x-front.blog-nav>

        <div class="items_result blog_search_remove_section">
            <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
        </div>
    </div>

    <div class="blog_append_section"></div>

@endsection
@section('script')
    <script>
        var blogads_url = "{{route('blogAds.index')}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blogAds/index.js')}}"></script>
@endsection
