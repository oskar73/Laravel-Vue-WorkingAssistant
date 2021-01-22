<div class="single_post post_1">
    <div class="single_post_img">
        <figure data-href="{{$post->getFirstMediaUrl("image")}}" class="progressive replace h-cursor f_post_item mb-3">
            <img src="{{$post->getFirstMediaUrl("image", "thumb")}}" alt="{{$post->title}}" class="preview">
        </figure>
    </div>
    <div class="single_post_text text-center">
        <a href="{{route('blog.category', $post->category->slug)}}" class="post_cat_title">{{$post->category->name}}</a>
        <a href="{{route('blog.detail', $post->slug)}}" class="post_title">{{$post->title}}</a>
        <p class="post_info_p">
            <span class="post_small_info">{{$post->created_at->diffForHumans()}}</span> &nbsp;&nbsp;
            <span class="post_small_info"><i class="fa fa-eye"></i> </span>{{$post->view_count}} &nbsp;
            <span class="post_small_info"><i class="fa fa-comment"></i> </span>{{$post->approved_comments_count}} &nbsp;
            <span class="post_small_info"><i class="fa fa-heart"></i> </span>{{$post->favoriters_count}}
        </p>
    </div>
</div>
