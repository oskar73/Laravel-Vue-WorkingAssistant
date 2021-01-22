
<div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-item-center">
            <thead>
            <tr>
                <td>Ticket Subject</td>
                <td>Date</td>
                <td>Do Now</td>
            </tr>
            </thead>
            <tbody id="table_body">
            @foreach($todos as $todo)
                <tr>
                    <td>{{$todo->text}}</td>
                    <td>{{$todo->updated_at->toDateTimeString()}}</td>
                    <td>
                        <a href="{{route('user.ticket.edit', $todo->id)}}" class="btn btn-outline-success m-btn--sm">Reply Now</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$todos->links()}}

