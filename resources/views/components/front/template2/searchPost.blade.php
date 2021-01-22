<div class="container search_result_area blog_template2">
    <div class="row">
        <div class="col-md-12 text-center mb-3 font-size20">
            {{$posts->total()}} results
        </div>
        @forelse($posts as $post)
            <div class="col-sm-4">

                @include("components.front.template2.postItem", ["post"=>$post])

            </div>
        @empty
            <div class="col-md-12 text-center">
                No posts.
            </div>
        @endforelse
    </div>
    {{ $posts->links() }}
</div>
