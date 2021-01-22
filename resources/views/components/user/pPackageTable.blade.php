<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    Order
                </th>
                <th>
                    Name
                </th>
                <th>
                    Payment
                </th>
                <th>
                    status
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Due Date
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="loading-tbody">
            @foreach($items as $item)
                <tr>
                    <td>
                        <a href="{{route('user.purchase.order.detail', $item->orderItem->order_id)}}">Order #{{$item->orderItem->order_id}}</a>
                    </td>
                    <td>{{$item->orderItem->getName()}}</td>
                    <td>{{$item->orderItem->recurrent==1?'Recurrent':'Onetime'}}</td>
                    <td>
                        @if($item->status=='active')
                            <span class="c-badge c-badge-success">Active</span>
                        @else
                            <span class="c-badge c-badge-info">{{$item->status}}</span>
                        @endif
                    </td>
                    <td>{{$item->created_at->toDateTimeString()}}</td>
                    <td>{{$item->orderItem->due_date}}</td>
                    <td>
                        <a href="{{route('user.purchase.'.$type.'.detail', $item->id)}}" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon">
                            <span>
                                <i class="la la-eye"></i>
                                <span>Detail</span>
                            </span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
