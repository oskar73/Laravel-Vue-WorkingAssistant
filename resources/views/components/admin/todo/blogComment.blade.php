
<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
            <tr>
                <th class="text-center">
                    Post Title
                </th>
                <th class="text-center">
                    Comment User
                </th>
                <th class="text-center">
                    Created Date
                </th>
                <th class="text-center">
                    Do Now
                </th>
            </tr>
            </thead>
            <tbody id="table_body">
            @foreach($todos as $todo)
                <tr>
                    <td><a href="{{route('blog.detail', $todo->post->slug)}}" target="_blank">{{$todo->post->title}}</a></td>
                    <td>
                        <a href="{{route('admin.userManage.detail', $todo->user->id)}}">
                            {{$todo->user->name}} ({{$todo->user->email}})
                        </a>
                    </td>
                    <td>{{$todo->created_at->toDateTimeString()}}</td>
                    <td><a href="{{route('admin.blog.comment.show', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Do Now</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
