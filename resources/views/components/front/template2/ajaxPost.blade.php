<div class="row">
    @forelse($posts as $post)
        <div class="col-sm-6">
            @include("components.front.template2.postItem", ["post"=>$post])
        </div>
    @empty
        <div class="col-md-12 text-center">
            No posts.
        </div>
    @endforelse
</div>
{{ $posts->links() }}
