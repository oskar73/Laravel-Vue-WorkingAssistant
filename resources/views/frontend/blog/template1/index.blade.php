@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
@endsection
@section('content')
    <x-front.blog-hero></x-front.blog-hero>
    <div class="container-fluid mt-3" >
        <div class="row">
            <div class="col-lg-2">

            </div>
            <div class="col-lg-8">

                <x-front.blog-nav></x-front.blog-nav>

                <div class="h-720x h-sm-auto blog_search_remove_section">
                    <div class="h-2-3 h-sm-auto">
                        <div class="h-100 w-2-3 w-sm-100 float-left p-1 h-sm-360px">
                            @if(isset($featured_posts[0]))
                                <a href="{{route('blog.detail', $featured_posts[0]->slug)}}" class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                    <figure data-href="{{$featured_posts[0]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container tw-h-full">
                                        <img src="{{$featured_posts[0]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[0]->title}}" class="preview img-bg-effect">
                                    </figure>
                                    <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                        <p class="blog_title_large">{{$featured_posts[0]->title}}</p>
                                        <span class="post_small_info text-white">{{$featured_posts[0]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[0]->view_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[0]->approved_comments_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[0]->favoriters_count}}
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="h-100 w-1-3 w-sm-100 float-left h-sm-720px">
                            <div class="h-50 w-100 p-1 position-relative blog-ads-position-1111">
                                @if(isset($featured_posts[1]))
                                    <a href="{{route('blog.detail', $featured_posts[1]->slug)}}" class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                        <figure data-href="{{$featured_posts[1]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                                            <img src="{{$featured_posts[1]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[1]->title}}" class="preview img-bg-effect">
                                        </figure>
                                        <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                            <p class="blog_title_medium">{{$featured_posts[1]->title}}</p>
                                            <span class="post_small_info text-white">{{$featured_posts[1]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[1]->view_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[1]->approved_comments_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[1]->favoriters_count}}
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="h-50 w-100 p-1">
                                @if(isset($featured_posts[2]))
                                    <a href="{{route('blog.detail', $featured_posts[2]->slug)}}" class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                        <figure data-href="{{$featured_posts[2]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                                            <img src="{{$featured_posts[2]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[2]->title}}" class="preview img-bg-effect">
                                        </figure>
                                        <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                            <p class="blog_title_medium">{{$featured_posts[2]->title}}</p>
                                            <span class="post_small_info text-white">{{$featured_posts[2]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[2]->view_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[2]->approved_comments_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[2]->favoriters_count}}
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="h-1-3 h-sm-auto">
                        <div class="h-100 w-1-3 w-sm-100 float-left p-1 h-sm-360px position-relative blog-ads-position-1112">
                            @if(isset($featured_posts[3]))
                                <a href="{{route('blog.detail', $featured_posts[3]->slug)}}" class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                    <figure data-href="{{$featured_posts[3]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                                        <img src="{{$featured_posts[3]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[3]->title}}" class="preview img-bg-effect">
                                    </figure>
                                    <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                        <p class="blog_title_medium">{{$featured_posts[3]->title}}</p>
                                        <span class="post_small_info text-white">{{$featured_posts[3]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[3]->view_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[3]->approved_comments_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[3]->favoriters_count}}
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="h-100 w-1-3 w-sm-100 float-left p-1 h-sm-360px">
                            @if(isset($featured_posts[4]))
                                <a href="{{route('blog.detail', $featured_posts[4]->slug)}}"class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                    <figure data-href="{{$featured_posts[4]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                                        <img src="{{$featured_posts[4]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[4]->title}}" class="preview img-bg-effect">
                                    </figure>
                                    <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                        <p class="blog_title_medium">{{$featured_posts[4]->title}}</p>
                                        <span class="post_small_info text-white">{{$featured_posts[4]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[4]->view_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[4]->approved_comments_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[4]->favoriters_count}}
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="h-100 w-1-3 w-sm-100 float-left p-1 h-sm-360px">
                            @if(isset($featured_posts[5]))
                                <a href="{{route('blog.detail', $featured_posts[5]->slug)}}" class="h-100 d-block position-relative h-cursor f_post_item border-solid-1px">
                                    <figure data-href="{{$featured_posts[5]->getFirstMediaUrl("image")}}" class="img-bg progressive replace mb-0 img-bg-effect-container">
                                        <img src="{{$featured_posts[5]->getFirstMediaUrl("image", 'thumb')}}" alt="{{$featured_posts[5]->title}}" class="preview img-bg-effect">
                                    </figure>
                                    <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                        <p class="blog_title_medium">{{$featured_posts[5]->title}}</p>
                                        <span class="post_small_info text-white">{{$featured_posts[5]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                        <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$featured_posts[5]->view_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$featured_posts[5]->approved_comments_count}} &nbsp;
                                        <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$featured_posts[5]->favoriters_count}}
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="blog_append_section pb-5">
            <div class="row mt-5">
                <div class="col-lg-2">
                    <div class="blog-ads-position-11110 text-right"></div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="p-area-title">Recent News</h5>
                            <div class="blog-ads-position-1113"></div>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    @if(isset($recent_posts[0]))
                                        <a href="{{route('blog.detail', $recent_posts[0]->slug)}}">
                                            <figure data-href="{{$recent_posts[0]->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item border-solid-1px">
                                                <img src="{{$recent_posts[0]->getFirstMediaUrl("image", "thumb")}}" alt="{{$recent_posts[0]->title}}" class="preview">
                                                <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                                                    <p class="blog_title_medium">{{$recent_posts[0]->title}}</p>
                                                    <span class="post_small_info text-white">{{$recent_posts[0]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                                    <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$recent_posts[0]->view_count}} &nbsp;
                                                    <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$recent_posts[0]->approved_comments_count}} &nbsp;
                                                    <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$recent_posts[0]->favoriters_count}}
                                                </div>
                                            </figure>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    @if(isset($recent_posts[1]))
                                        <a href="{{route('blog.detail', $recent_posts[1]->slug)}}" class="d-block mb-3">
                                            <figure data-href="{{$recent_posts[1]->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item width-100px float-left">
                                                <img src="{{$recent_posts[1]->getFirstMediaUrl("image", "thumb")}}" alt="{{$recent_posts[1]->title}}" class="preview">
                                            </figure>
                                            <div class="ml-120px">
                                                {{$recent_posts[1]->title}}
                                                <hr class="m-0">
                                                <span class="post_small_info">{{$recent_posts[1]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                                <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$recent_posts[1]->view_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$recent_posts[1]->approved_comments_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$recent_posts[1]->favoriters_count}}
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    @endif
                                    @if(isset($recent_posts[2]))
                                        <a href="{{route('blog.detail', $recent_posts[2]->slug)}}" class="d-block mb-3">
                                            <figure data-href="{{$recent_posts[2]->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item width-100px float-left">
                                                <img src="{{$recent_posts[2]->getFirstMediaUrl("image", "thumb")}}" alt="{{$recent_posts[2]->title}}" class="preview">
                                            </figure>
                                            <div class="ml-120px">
                                                {{$recent_posts[2]->title}}
                                                <hr class="m-0">
                                                <span class="post_small_info">{{$recent_posts[2]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                                <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$recent_posts[2]->view_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$recent_posts[2]->approved_comments_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$recent_posts[2]->favoriters_count}}
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    @endif
                                    @if(isset($recent_posts[3]))
                                        <a href="{{route('blog.detail', $recent_posts[3]->slug)}}" class="d-block mb-3">
                                            <figure data-href="{{$recent_posts[3]->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item width-100px float-left">
                                                <img src="{{$recent_posts[3]->getFirstMediaUrl("image", "thumb")}}" alt="{{$recent_posts[3]->title}}" class="preview">
                                            </figure>
                                            <div class="ml-120px">
                                                {{$recent_posts[3]->title}}
                                                <hr class="m-0">
                                                <span class="post_small_info">{{$recent_posts[3]->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                                <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$recent_posts[3]->view_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$recent_posts[3]->approved_comments_count}} &nbsp;
                                                <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$recent_posts[3]->favoriters_count}}
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <h5 class="p-area-title">All Posts</h5>
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
                            <h5 class="p-area-title">Popular Posts</h5>
                            <div class="mb-5">
                                @foreach($popular_posts as $post)
                                    <a href="{{route('blog.detail', $post->slug)}}" class="d-block mb-3">
                                        <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item width-100px float-left">
                                            <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
                                        </figure>
                                        <div class="ml-120px">
                                            {{$post->title}}
                                            <hr class="m-0">
                                            <span class="post_small_info">{{$post->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$post->view_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$post->approved_comments_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$post->favoriters_count}}
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="blog-ads-position-1118"></div>
                            <h5 class="p-area-title">Most Discussed Posts</h5>
                            <div class="mb-5">
                                @foreach($most_discussed_posts as $post)
                                    <a href="{{route('blog.detail', $post->slug)}}" class="d-block mb-3">
                                        <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item width-100px float-left">
                                            <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
                                        </figure>
                                        <div class="ml-120px">
                                            {{$post->title}}
                                            <hr class="m-0">
                                            <span class="post_small_info">{{$post->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$post->view_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$post->approved_comments_count}} &nbsp;
                                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$post->favoriters_count}}
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="blog-ads-position-1119"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="blog-ads-position-11111"></div>
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
