<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th class="no-sort">
                    <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
                </th>
                <th>
                    Name
                </th>
                <th>
                    Type
                </th>
                <th>
                    Image
                </th>
                <th>
                    Active Spots
                </th>
                <th>
                    Active Listings
                </th>
                <th>
                    Status
                </th>
                <th class="no-sort">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($positions as $position)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$position->id}}"></td>
                <td>{{$position->name}}</td>
                <td>{{$position->type_name}}</td>
                <td>
                    <a href="{{$position->image}}" class="width-150 progressive replace m-auto">
                        <img src="{{$position->image}}"
                             alt="{{$position->name}}"
                             class="width-150 preview"
                        >
                    </a>
                </td>
                <td>1</td>
                <td>1</td>
                <td>
                    @if($position->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>
                    <a href="javascript:void(0);"
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                       data-id="{{$position->id}}"
                       data-name="{{$position->name}}"
                       data-type="{{$position->type_name}}"
                       data-status="{{$position->status}}"
                       data-image="{{$position->image}}">
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
