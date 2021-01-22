<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
                <tr>
                    <th class="text-center">
                        Regarding Purchase
                    </th>
                    <th class="text-center">
                        Form Title
                    </th>
                    <th class="text-center">
                        Status
                    </th>
                    <th class="text-center">
                        Date
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="table_body">
                @foreach($todos as $todo)
                    <tr>
                        <td>{{$todo->model->getName()}}</td>
                        <td>
                            {{$todo->title}}
                        </td>
                        <td>
                            @if($todo->status==='need to fill')
                                <span class='c-badge c-badge-danger white-space-nowrap'>Need to fill</span>
                            @else
                                <span class='c-badge c-badge-warning white-space-nowrap'>{{ucfirst($todo->status)}}l</span>
                            @endif
                        </td>
                        <td>{{$todo->created_at->toDateTimeString()}}</td>
                        <td><a href="{{route('user.purchase.form.edit', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Do Now</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
