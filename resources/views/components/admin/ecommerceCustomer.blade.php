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
                    Phone
                </th>
                <th>
                    Address
                </th>
                <th>
                    Payment Method
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
        @foreach($customers as $customer)
            <tr>
                <td>
                    <input type="checkbox"
                           class="checkbox"
                           data-id="{{$customer->id}}"
                    >
                </td>
                <td>
                    {{ $customer->name }}
                </td>
                <td>{{ $customer->email }}</td>
                <td>
                    {{ $customer->phone }}
                </td>
                <td>
                    {{ $customer->address }}
                </td>
                <td>
                    {{ $customer->method }}
                </td>
                <td>
                    {{ $customer->created_at }}
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
