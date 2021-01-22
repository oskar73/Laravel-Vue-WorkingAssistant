<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
                <tr>
                    <th class="text-center">
                        Listing Spot
                    </th>
                    <th class="text-center">
                        Status
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
                    <td>{{$todo->spot->name}}</td>
                    <td>
                        @if($todo->status==='paid')
                            <span class="c-badge c-badge-info" >Newly Paid</span>
                        @else
                            <span class="c-badge c-badge-danger" >{{ucfirst($todo->status)}}</span>
                        @endif
                    </td>
                    <td>{{$todo->created_at->toDateTimeString()}}</td>
                    <td>
                        <a href="{{route('user.blogAds.edit', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Do Now</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
