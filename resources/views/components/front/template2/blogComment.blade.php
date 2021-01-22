<div class="mt-4">
    <h5 class="p-area-title">Comments (<span class="total_comments_count">{{$comments->total()}}</span>)</h5>
</div>
@php
 if(Auth::check())
{
    $favorite_comments = user()->favorite_to_comments->where('pivot.favorite', 1)->pluck("id")->toArray();
    $unfavorite_comments = user()->favorite_to_comments->where('pivot.favorite', 0)->pluck("id")->toArray();
}else {
    $favorite_comments = [];
    $unfavorite_comments = [];
}
@endphp
<div class="blog_comment_ajax_area">
    @forelse($comments as $comment)
        <div class="comment_card">
            <div class="d-flex align-center">
                <a href="{{route('blog.author', $comment->user->id)}}" class="mr-3">
                    <img src="{{$comment->user->avatar()}}" alt="{{$comment->user->name}}" class="rounded-circle width-50px">
                </a>
                <span class="mr-auto">
                    <a href="{{route('blog.author', $comment->user->id)}}">{{$comment->user->name}}</a> <br>
                    {{$comment->created_at->toDateString()}}
                </span>
            </div>
            <div class="mt-3">
                {!! $comment->comment !!}
            </div>

            <hr>

            <div class="d-flex justify-content-between mt-2">
                <div class="like_dislike_area">
                    <a href="javascript:void(0);"
                       class="thumbs_up_area d-inline-block mr-3 {{in_array($comment->id, $favorite_comments) ? 'favorite_post': ''}}"
                       onclick="favoriteComment({{$comment->id}}, 'like')"
                       id="like-comment-{{$comment->id}}"
                    >
                        <i class="far fa-thumbs-up thumb-icon"></i> <span class="thumbs_up_area">{{$comment->favorite_to_users->where('pivot.favorite', 1)->count()}}</span>
                    </a>
                    <a href="javascript:void(0);"
                       class="thumbs_down_area d-inline-block {{in_array($comment->id, $unfavorite_comments) ? 'favorite_post': ''}}"
                       onclick="favoriteComment({{$comment->id}}, 'dislike')"
                       id="dislike-comment-{{$comment->id}}"
                    >
                        <i class="far fa-thumbs-down thumb-icon"></i> <span class="thumbs_down_area">{{$comment->favorite_to_users->where('pivot.favorite', 0)->count()}}</span>
                    </a>
                </div>
                <div class="reply_area">
                    @if($comment->approvedComments->count() !==0)
                        <a href="javascript:void(0);" class="response_btn mr-2" data-id="{{$comment->id}}">{{$comment->approvedComments->count()}} Response</a>
                    @endif
                    <a href="javascript:void(0);" class="reply_btn" data-id="{{$comment->id}}">Reply</a>
                </div>
            </div>
        </div>
        @if($comment->approvedComments->count() !==0)
            <div class="subcomment_area" data-area="{{$comment->id}}" style="display:none">
                @foreach($comment->approvedComments as $subcomment)
                    <div class="comment_card ml-5 ">
                        <div class="d-flex align-center">
                            <a href="{{route('blog.author', $subcomment->user->id)}}" class="mr-3">
                                <img src="{{$subcomment->user->avatar()}}" alt="{{$subcomment->user->name}}" class="rounded-circle width-50px">
                            </a>
                            <span class="mr-auto">
                                <a href="{{route('blog.author', $subcomment->user->id)}}">{{$subcomment->user->name}}</a> <br>
                                {{$subcomment->created_at->toDateString()}}
                            </span>
                        </div>
                        <div class="mt-4">
                            {!! $subcomment->comment !!}
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="like_dislike_area">
                                <a href="javascript:void(0);"
                                   class="thumbs_up_area d-inline-block mr-3 {{in_array($subcomment->id, $favorite_comments) ? 'favorite_post': ''}}"
                                   onclick="favoriteComment({{$subcomment->id}}, 'like')"
                                   id="like-comment-{{$subcomment->id}}"
                                >
                                    <i class="far fa-thumbs-up thumb-icon"></i> <span class="thumbs_up_area">{{$subcomment->favorite_to_users->where('pivot.favorite', 1)->count()}}</span>
                                </a>
                                <a href="javascript:void(0);"
                                   class="thumbs_down_area d-inline-block {{in_array($subcomment->id, $unfavorite_comments) ? 'favorite_post': ''}}"
                                   onclick="favoriteComment({{$subcomment->id}}, 'dislike')"
                                   id="dislike-comment-{{$subcomment->id}}"
                                >
                                    <i class="far fa-thumbs-down thumb-icon"></i> <span class="thumbs_down_area">{{$subcomment->favorite_to_users->where('pivot.favorite', 0)->count()}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @empty
        <div class="text-center">
            No comments yet.
        </div>
    @endforelse
    {{$comments->links()}}
</div>
