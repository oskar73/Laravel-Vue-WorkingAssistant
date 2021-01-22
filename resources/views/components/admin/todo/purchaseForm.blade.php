<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
            <tr>
                <th class="text-center">
                    Form Title
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
                    <td>{{$todo->title}}</td>
                    <td>
                        <a href="{{route('admin.userManage.detail', $todo->user->id)}}">
                            {{$todo->user->name}} ({{$todo->user->email}})
                        </a>
                    </td>
                    <td>{{$todo->created_at->toDateTimeString()}}</td>
                    <td><a href="{{route('admin.purchase.form.detail', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Do Now</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
