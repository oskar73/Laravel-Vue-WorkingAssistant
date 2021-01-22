@extends('layouts.app')

@section('title', $user->name)

@section('style')
    @livewireStyles
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
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="p-area-title font-size30">Posts ({{$user->visible_posts_count}})</h1>
                        <div class="all_author_post_area">
                            <div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="author_profile mb-5 mt-3">
                            <div class="width-200px rounded-circle m-auto overflow-hidden">
                                <img src="{{$user->avatar()}}" alt="{{$user->name}}" class="w-100"> <br>
                            </div>
                            <h1 class="font-size24 mt-3 text-center mb-0">
                                {{$user->name}}
                            </h1>
                            <p class="text-muted text-center">{{'@'.$user->username}}</p>
                            <div class="following_area text-center my-3">
                                @if(Auth::check()&&$user->id==user()->id)
                                @else
                                    <livewire:following :user="$user">
                                @endif
                            </div>
                            <div class="mt-3 text-center">
                                <span class="font-size20 mr-3">
                                    <i class="fa fa-edit tipso1" data-tipso="Posts"></i>
                                     {{$user->visible_posts_count}}
                                </span>
                                <span class="font-size20 mr-3">
                                    <i class="fa fa-comment tipso1" data-tipso="Comments"></i>
                                     {{$user->approved_comments_count}}
                                </span>
                                <span class="font-size20 mr-3">
                                    <svg width="22" height="22" viewBox="0 0 33 33" class="tipso1"  data-tipso="Claps">
                                        <path d="M28.86 17.34l-3.64-6.4c-.3-.43-.71-.73-1.16-.8a1.12 1.12 0 0 0-.9.21c-.62.5-.73 1.18-.32 2.06l1.22 2.6 1.4 2.45c2.23 4.09 1.51 8-2.15 11.66a9.6 9.6 0 0 1-.8.71 6.53 6.53 0 0 0 4.3-2.1c3.82-3.82 3.57-7.87 2.05-10.39zm-6.25 11.08c3.35-3.35 4-6.78 1.98-10.47L21.2 12c-.3-.43-.71-.72-1.16-.8a1.12 1.12 0 0 0-.9.22c-.62.49-.74 1.18-.32 2.06l1.72 3.63a.5.5 0 0 1-.81.57l-8.91-8.9a1.33 1.33 0 0 0-1.89 1.88l5.3 5.3a.5.5 0 0 1-.71.7l-5.3-5.3-1.49-1.49c-.5-.5-1.38-.5-1.88 0a1.34 1.34 0 0 0 0 1.89l1.49 1.5 5.3 5.28a.5.5 0 0 1-.36.86.5.5 0 0 1-.36-.15l-5.29-5.29a1.34 1.34 0 0 0-1.88 0 1.34 1.34 0 0 0 0 1.89l2.23 2.23L9.3 21.4a.5.5 0 0 1-.36.85.5.5 0 0 1-.35-.14l-3.32-3.33a1.33 1.33 0 0 0-1.89 0 1.32 1.32 0 0 0-.39.95c0 .35.14.69.4.94l6.39 6.4c3.53 3.53 8.86 5.3 12.82 1.35zM12.73 9.26l5.68 5.68-.49-1.04c-.52-1.1-.43-2.13.22-2.89l-3.3-3.3a1.34 1.34 0 0 0-1.88 0 1.33 1.33 0 0 0-.4.94c0 .22.07.42.17.61zm14.79 19.18a7.46 7.46 0 0 1-6.41 2.31 7.92 7.92 0 0 1-3.67.9c-3.05 0-6.12-1.63-8.36-3.88l-6.4-6.4A2.31 2.31 0 0 1 2 19.72a2.33 2.33 0 0 1 1.92-2.3l-.87-.87a2.34 2.34 0 0 1 0-3.3 2.33 2.33 0 0 1 1.24-.64l-.14-.14a2.34 2.34 0 0 1 0-3.3 2.39 2.39 0 0 1 3.3 0l.14.14a2.33 2.33 0 0 1 3.95-1.24l.09.09c.09-.42.29-.83.62-1.16a2.34 2.34 0 0 1 3.3 0l3.38 3.39a2.17 2.17 0 0 1 1.27-.17c.54.08 1.03.35 1.45.76.1-.55.41-1.03.9-1.42a2.12 2.12 0 0 1 1.67-.4 2.8 2.8 0 0 1 1.85 1.25l3.65 6.43c1.7 2.83 2.03 7.37-2.2 11.6zM13.22.48l-1.92.89 2.37 2.83-.45-3.72zm8.48.88L19.78.5l-.44 3.7 2.36-2.84zM16.5 3.3L15.48 0h2.04L16.5 3.3z" fill-rule="evenodd">
                                        </path>
                                    </svg>  {{$user->visiblePosts->sum('favoriters_count') }}
                                </span>
                                <span class="font-size20 mr-3">
                                    <livewire:follower :user="$user" />
                                </span>
                            </div>
                        </div>
                        <x-front.blog-popular></x-front.blog-popular>
                        <x-front.blog-discussed></x-front.blog-discussed>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    <div class="blog_append_section"></div>
@endsection
@section('script')
    @livewireScripts
    <script>
        var blog_ajaxAuthor = "{{route('blog.ajaxAuthor', $user->id)}}",
            blogSearch="{{route('blog.search')}}";
    </script>
    <script src="{{asset('assets/js/front/blog/search.js')}}"></script>
    <script src="{{asset('assets/js/front/blog/author.js')}}"></script>
@endsection
