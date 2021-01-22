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
