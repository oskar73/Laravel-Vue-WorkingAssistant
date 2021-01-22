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
                    Description
                </th>
                <th>
                    Image Width (Px)
                </th>
                <th>
                    Image Height (Px)
                </th>
                <th>
                    Title Chars
                </th>
                <th>
                    Text Chars
                </th>
                <th>
                   Active Spots
                </th>
                <th>
                   Active Listings Spots
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
        @foreach($types as $type)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$type->id}}"></td>
                <td>{{$type->name}}</td>
                <td>{{$type->description}}</td>
                <td>{{$type->width}}</td>
                <td>{{$type->height}}</td>
                <td>{{$type->title_char}}</td>
                <td>{{$type->text_char}}</td>
                <td>1</td>
                <td>1</td>
                <td>
                    @if($type->status===1)
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
                       data-type="{{$type}}"
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
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
