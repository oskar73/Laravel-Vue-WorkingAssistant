@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')
{{--    <x-front.blog-hero></x-front.blog-hero>--}}
<div class="blog_template2">
    <div class="container-fluid  mt-1">
        <div class="row justify-content-between">
            @if(isset($featured_posts[0]))
            <figure data-href="{{$featured_posts[0]->getFirstMediaUrl("image")}}" class="progressive replace img-bg-effect-container text-center banner_post_1">
                <img src="{{$featured_posts[0]->getFirstMediaUrl("image", "thumb")}}" alt="" class="img-bg preview img-bg-effect">
                <div class="banner_post_iner text-center">
                    <a href="{{route('blog.category', $featured_posts[0]->category->slug)}}" class="post_cat_title">{{$featured_posts[0]->category->name}}</a>
                    <a href="{{route('blog.detail', $featured_posts[0]->slug)}}" class="post_title">{{$featured_posts[0]->title}}</a>
                    <p class="post_info_p">
                        <span class="post_small_info">{{$featured_posts[0]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[0]->view_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[0]->approved_comments_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[0]->favoriters_count}}
                    </p>
                </div>
            </figure>
            @endif
            @if(isset($featured_posts[1]))
            <figure data-href="{{$featured_posts[1]->getFirstMediaUrl("image")}}" class="progressive replace img-bg-effect-container text-center banner_post_1">
                <img src="{{$featured_posts[1]->getFirstMediaUrl("image", "thumb")}}" alt="" class="img-bg preview img-bg-effect">
                <div class="banner_post_iner text-center">
                    <a href="{{route('blog.category', $featured_posts[1]->category->slug)}}" class="post_cat_title">{{$featured_posts[1]->category->name}}</a>
                    <a href="{{route('blog.detail', $featured_posts[1]->slug)}}" class="post_title">{{$featured_posts[1]->title}}</a>
                    <p class="post_info_p">
                        <span class="post_small_info">{{$featured_posts[1]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[1]->view_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[1]->approved_comments_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[1]->favoriters_count}}
                    </p>
                </div>
            </figure>
            @endif
            @if(isset($featured_posts[2]))
            <figure data-href="{{$featured_posts[2]->getFirstMediaUrl("image")}}" class="progressive replace img-bg-effect-container text-center banner_post_1">
                <img src="{{$featured_posts[2]->getFirstMediaUrl("image", "thumb")}}" alt="" class="img-bg preview img-bg-effect">
                <div class="banner_post_iner text-center">
                    <a href="{{route('blog.category', $featured_posts[2]->category->slug)}}" class="post_cat_title">{{$featured_posts[2]->category->name}}</a>
                    <a href="{{route('blog.detail', $featured_posts[2]->slug)}}" class="post_title">{{$featured_posts[2]->title}}</a>
                    <p class="post_info_p">
                        <span class="post_small_info">{{$featured_posts[2]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[2]->view_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[2]->approved_comments_count}} &nbsp;
                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[2]->favoriters_count}}
                    </p>
                </div>
            </figure>
                @endif
        </div>
    </div>
    <div class="mt-100 content py-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <div class="blog-ads-position-11110 text-right"></div>
                </div>
                <div class="col-lg-8">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                @if(isset($featured_posts[3]))
                                <div class="position-relative blog-ads-position-1111">
                                    @include("components.front.template2.postItem", ["post"=>$featured_posts[3]])
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if(isset($featured_posts[4]))
                                    @include("components.front.template2.postItem", ["post"=>$featured_posts[4]])
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if(isset($featured_posts[5]))
                                <div class="position-relative blog-ads-position-1112">
                                    @include("components.front.template2.postItem", ["post"=>$featured_posts[5]])
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="container template2_container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="blog-ads-position-1113"></div>

                                @if(isset($featured_posts[3]))
                                <div class="single_post post_1 feature_post">
                                    <div class="single_post_img">
                                        <figure data-href="{{$featured_posts[3]->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item mb-3">
                                            <img src="{{$featured_posts[3]->getFirstMediaUrl("image", "thumb")}}" alt="{{$featured_posts[3]->title}}" class="preview">
                                        </figure>
                                    </div>
                                    <div class="single_post_text text-center">
                                        <a href="{{route('blog.category', $featured_posts[3]->category->slug)}}" class="post_cat_title">{{$featured_posts[3]->category->name}}</a>
                                        <a href="{{route('blog.detail', $featured_posts[3]->slug)}}" class="post_title">{{$featured_posts[3]->title}}</a>
                                        <p class="post_info_p">
                                            <span class="post_small_info">{{$featured_posts[3]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[3]->view_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[3]->approved_comments_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[3]->favoriters_count}}
                                        </p>
                                    </div>
                                </div>
                                @endif

                                <div class="blog-ads-position-1115"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="blog-ads-position-1116"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="blog-ads-position-1117"></div>
                                    </div>
                                </div>

                                <div class="all_post_area">

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="blog-ads-position-1114"></div>
                                <div class="single_sidebar_wiget">
                                    <div class="sidebar_tittle">
                                        <h3 class="font-weight-bold">Popular Feeds</h3>
                                    </div>
                                    @foreach($popular_posts as $post)
                                        <div class="single_catagory_post post_2 ">
                                            <div class="category_post_img">
                                                <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursort">
                                                    <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
                                                </figure>
                                            </div>
                                            <div class="post_text_1">
                                                <a href="{{route('blog.detail', $post->slug)}}" class="d-block post_title">{{$post->title}}</a>
                                                <p class="post_info_p">
                                                    <span class="post_small_info">{{$post->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                                    <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$post->view_count}} &nbsp;
                                                    <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$post->approved_comments_count}} &nbsp;
                                                    <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$post->favoriters_count}}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="blog-ads-position-1118"></div>
                                <div class="blog-ads-position-1119"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="blog-ads-position-11111"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        var ads_type="home",
            ads_item_id=null,
            blogAjaxUrl = "{{route('blog.ajaxPage')}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/index.js')}}"></script>
    @publishedModule("blogAds")
    <script>var blogAds_getData="{{route('blogAds.getData')}}", blogAds_impClick="{{route('blogAds.impClick')}}";</script>
    <script src="{{asset('assets/js/front/blogAds/getAds.js')}}"></script>
    @endpublishedModule
@endsection
