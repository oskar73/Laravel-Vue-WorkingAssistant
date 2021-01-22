<div>
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
</div>
