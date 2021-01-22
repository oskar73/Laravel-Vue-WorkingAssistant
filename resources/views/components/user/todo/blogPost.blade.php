
<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
                <tr>
                    <th class="text-center">
                        Regarding purchase
                    </th>
                    <th class="text-center">
                        Date
                    </th>
                    <th class="text-center">
                        Do Now
                    </th>
                </tr>
            </thead>
            <tbody id="table_body">
                @foreach($todos as $todo)
                    @for($i=0;$i<$todo->remain_post;$i++)
                    <tr>
                        <td>
                            {{$todo->getName()}} @if($todo->post_number===-1)(Unlimited) @endif
                        </td>
                        <td>{{$todo->created_at->toDateTimeString()}}</td>
                        <td><a href="{{route('user.blog.create')}}" class="btn btn-outline-success m-btn--sm">Do Now</a></td>
                    </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
