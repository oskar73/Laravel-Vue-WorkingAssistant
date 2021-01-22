<form action="{{route('blog.postComment', $post_id)}}" method="POST" class="post_comment_form reply">
    @csrf
    @honeypot
    <div class="leave_comment_area my-3">
        <input type="hidden" name="comment_id" value="{{$comment_id}}">
        <div id="comment" class="minh-100 comment_box"></div>
        <div class="form-control-feedback error-comment "></div>
        <div class="text-right">
            <button class="btn btn-outline-success mt-2 smtBtn border-success" type="submit">Submit</button>
        </div>
    </div>
</form>
