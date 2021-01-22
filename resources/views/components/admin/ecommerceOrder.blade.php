<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th class="no-sort">
                    <input name="select_all"
                           class="selectAll checkbox"
                           value="1" type="checkbox"
                           data-area="{{$selector}}"
                    >
                </th>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Address
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Tracking Code
                </th>
                <th>
                    Created At
                </th>
                <th class="no-sort">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>
                    <input type="checkbox"
                           class="checkbox"
                           data-id="{{$order->id}}"
                    >
                </td>
                <td>
                    {{ $order->customer->name }}
                </td>
                <td>{{ $order->customer->email }}</td>
                <td>
                    @php
                        $addressObject = json_decode($order->shipping_address);
                    @endphp
                    {{ $addressObject->address }}, {{ $addressObject->city }}, {{ $addressObject->state }}, {{ $addressObject->zip }}
                </td>
                <td>
                    ${{ $order->total }}
                </td>
                <td>
                    {{ $order->tracking_code }}
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
                <td>
                    {{-- <a href=""
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                    >
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a> --}}
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                        <span>
                            <span>Delete</span>
                        </span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
