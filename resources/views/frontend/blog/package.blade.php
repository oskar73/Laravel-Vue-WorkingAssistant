@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog Package')

@section('meta')
    @include("components.front.seo", $seo)
@endsection

@section('style')
@endsection
@section('content')
    <x-front.blog-hero></x-front.blog-hero>

    <div class="container mt-3" >
        <x-front.blog-nav></x-front.blog-nav>

        <div class="items_result blog_search_remove_section">
           <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
        </div>
    </div>
    <div class="blog_append_section py-4"></div>

@endsection
@section('script')
    <script>
        var blog_package = "{{route('blog.package')}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/package.js')}}"></script>
@endsection
