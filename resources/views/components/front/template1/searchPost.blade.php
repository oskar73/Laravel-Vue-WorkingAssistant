<div class="container search_result_area">
    <div class="row">
        <div class="col-md-12 text-center mb-3 font-size20">
            {{$posts->total()}} results
        </div>
        @forelse($posts as $post)
            <div class="col-sm-4 mb-3">
                <a href="{{route('blog.detail', $post->slug)}}">
                    <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item">
                        <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
                        <div class="position-absolute text-white post-title-bg z-index-2 w-100 bottom-0 p-3">
                            <p class="blog_title_medium">{{$post->title}}</p>
                            <span class="post_small_info text-white">{{$post->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
                            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$post->view_count}} &nbsp;
                            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$post->approved_comments_count}} &nbsp;
                            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$post->favoriters_count}}
                        </div>
                    </figure>
                </a>
            </div>
        @empty
            <div class="col-md-12 text-center">
                No posts.
            </div>
        @endforelse
    </div>
    {{ $posts->links() }}
</div>
