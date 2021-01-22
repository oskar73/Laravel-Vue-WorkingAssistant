<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable border-top-none-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Post title</th>
                <th class="text-right"><i class="fa fa-eye tooltip_3" title="View Count"></i></th>
                <th class="text-right"><i class="fa fa-heart tooltip_3" title="Favorite Count"></i></th>
                <th class="text-right"><i class="fa fa-comment tooltip_3" title="Comments Count"></i></th>
                <th class="text-center">Author</th>
                <th class="text-right"> Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $key=>$post)
                <tr>
                    <td class="text-center width-50px fs-15">{{$key+1+(($pageNum-1)*$perpage)}}</td>
                    <td class="text-left fs-15 min-width-150px"><a href="{{route('blog.detail', $post->slug)}}">{{$post->title}}</a></td>
                    <td class="text-right width-50px fs-15">{{$post->view_count}}</td>
                    <td class="text-right width-50px fs-15">{{ $post->favoriters_count }}</td>
                    <td class="text-right width-50px fs-15">{{ $post->approved_comments_count }}</td>
                    <td class="w-150px text-center fs-15">{{ $post->user->name }}</td>
                    <td class="text-right w-100px fs-15">{{ $post->created_at->toDateString() }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No posts</td></tr>
            @endforelse
        </tbody>
    </table>
    {{$posts->links()}}
</div>

