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
                    Order
                </th>
                <th>
                    Name
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Fees
                </th>
                <th>
                    Status
                </th>
                <th>
                    Payment Method
                </th>
                <th>
                    Created At
                </th>
                {{-- <th class="no-sort">
                    Action
                </th> --}}
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>
                    <input type="checkbox"
                           class="checkbox"
                           data-id="{{$payment->id}}"
                    >
                </td>
                <td>
                    {{ $payment->order->id }}
                </td>
                <td>{{ $payment->customer->name }}</td>
                <td>
                    ${{ $payment->amount }}
                </td>
                <td>
                    ${{ $payment->fees }}
                </td>
                <td>
                    @if ($payment->payment_status === 'APPROVED' || $payment->payment_status === 'succeeded')
                    <span class="c-badge c-badge-success">succeeded</span>
                    @else
                    <span class="c-badge c-badge-danger">{{ $payment->payment_status }}</span>
                    @endif
                </td>
                <td>
                    {{ $payment->method }}
                </td>
                <td>
                    {{ $payment->created_at }}
                </td>
                {{-- <td>
                    <a href=""
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                    >
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                        <span>
                            <span>Delete</span>
                        </span>
                    </a>
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
