<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
                <tr>
                    <th class="text-center">
                        Regarding Purchase
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
                    @for($i=0;$i<$todo->available_number;$i++)
                        <tr>
                            <td>
                                {{$todo->model->getName()}} @if($todo->meeting_number==-1) (Unlimited) @endif
                            </td>
                            <td>{{$todo->created_at->toDateTimeString()}}</td>
                            <td>
                                <a href="{{route('user.appointment.create')}}" class="btn btn-outline-success m-btn--sm">Do Now</a>
                            </td>
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}
