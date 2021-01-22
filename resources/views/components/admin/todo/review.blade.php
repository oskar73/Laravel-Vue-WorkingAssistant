<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
            <tr>
                <th class="text-center">
                    Product
                </th>
                <th class="text-center">
                    Rating
                </th>
                <th class="text-center">
                    User
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
                    <td>{!! ucfirst($todo->getProduct()) !!}</td>
                    <td>{{ucfirst($todo->rating)}}</td>
                    <td>
                        <a href="{{route('admin.userManage.detail', $todo->user->id)}}">
                            {{$todo->user->name}} ({{$todo->user->email}})
                        </a>
                    </td>
                    <td>{{$todo->created_at->toDateTimeString()}}</td>
                    <td><a href="{{route('admin.content.review.show', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Do Now</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
