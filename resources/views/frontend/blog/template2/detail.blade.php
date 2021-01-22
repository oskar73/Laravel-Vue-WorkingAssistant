@extends('layouts.app')

@section('title', $seo['meta_title']?? 'Blog')

@section('meta')
    @include("components.front.seo", $seo)
@endsection
@section('style')
    @livewireStyles
@endsection
@section('content')
    <x-front.blog-hero></x-front.blog-hero>

    <div class="container-fluid mt-3 blog_template2" >
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <x-front.blog-nav></x-front.blog-nav>
            </div>
        </div>
        <div class="row mt-5 blog_search_remove_section">
            <div class="col-lg-2">
                <div class="blog-ads-position-11125 text-right"></div>
            </div>
            <div class="col-lg-8 content">
                <div class="row">
                    <div class="col-lg-8 pb-5">
                        <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item mb-3">
                            <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
                        </figure>

                        <div class="blog-ads-position-11123"></div>

                        <h1 class="blog-title-lg mb-4">{{$post->title}}</h1>

                        <div class="mt-4 blog_post_detail_area">

                            {!! $post->body !!}

                            <br>

                            @foreach($post->approvedTags as $tag)
                                <a href="{{route('blog.tag', $tag->slug)}}" class="btn btn-outline-success rounded-0 m-1 blog_tag_btn">{{$tag->name}}</a>
                            @endforeach
                            <br>
                            <div class="d-flex justify-content-between mt-3 position-relative" id="like-area">

                                <livewire:favorite-post :post="$post" />

                                <div class="share position-absolute bottom-0 right-0">
                                    <x-front.socialShare></x-front.socialShare>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-center">
                                    <a href="{{route('blog.author', $post->user->id)}}" class="mr-3">
                                        <img src="{{$post->user->avatar()}}" alt="{{$post->user->name}}" class="rounded-circle width-80px">
                                    </a>
                                    <span class="m-auto">
                                        <small>Written By</small> <br>
                                        <a href="{{route('blog.author', $post->user->id)}}">{{$post->user->name}}</a><b></b>
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <div class="display-inline-block m-auto">

                                        @if(Auth::check()&&$post->user->id==user()->id)
                                        @else
                                            <livewire:following :user="$post->user" />
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="blog-ads-position-11124"></div>
                            <hr>
                            <div class="mt-5">
                                <h5 class="p-area-title">You May Also Like</h5>
                                <div class="row">
                                    @foreach($randomposts as $r_post)
                                        <div class="col-sm-6">
                                            @include("components.front.template2.postItem", ["post"=>$r_post])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="all_comment_area" id="comment_section">

                        </div>
                        <div class="mt-4">
                            <h5 class="p-area-title">Leave a comment</h5>
                        </div>

                        @auth
                        <form action="{{route('blog.postComment', $post->id)}}" method="POST" class="post_comment_form">
                            @csrf
                            @honeypot
                            <div class="leave_comment_area my-3" id="leave_comment">
                                <div id="comment" class="minh-100 comment_box comment default_comment"></div>
                                <div class="form-control-feedback error-comment"></div>
                                <div class="text-right">
                                    <button class="btn btn-outline-success mt-2 smtBtn border-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>

                        @else
                            Please <a href="{{route('cart.login')}}?redirect={{url()->current()}}#leave_comment" class="underline">Login</a> to post comment here.
                        @endauth
                    </div>
                    <div class="col-lg-4">
                        <div class="blog-ads-position-11120"></div>

                        <x-front.template2.blog-popular></x-front.template2.blog-popular>

                        <div class="blog-ads-position-11121"></div>
                        <div class="single_sidebar_wiget">
                            <div class="sidebar_tittle">
                                <h3 class="font-weight-bold">Subscribe to this <br> post.</h3>
                            </div>
                           <div class="mb-3">To get notification about update, comments to this post, please subscribe.</div>
                            <div class="text-center">
                                <livewire:subscribe-post :post="$post" />
                            </div>
                        </div>

                        <div class="blog-ads-position-11122"></div>
                        <div class="blog-ads-position-11127"></div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="blog-ads-position-11126"></div>
            </div>
        </div>
    </div>
    <div class="blog_append_section"></div>
@endsection
@section('script')
    @livewireScripts
    <script>
        var ads_type="detail",
            ads_item_id="{{$post->id}}",
            blog_ajaxComment = "{{route('blog.ajaxComment', $post->slug)}}",
            blog_getCommentForm = "{{route('blog.getCommentForm', $post->id)}}" ,
            blog_favoriteComment = "{{route('blog.favoriteComment')}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/detail.js')}}"></script>
    @publishedModule("blogAds")
        <script>var blogAds_getData="{{route('blogAds.getData')}}", blogAds_impClick="{{route('blogAds.impClick')}}";</script>
        <script src="{{asset('assets/js/front/blogAds/getAds.js')}}"></script>
    @endpublishedModule
@endsection
