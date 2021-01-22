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
                Assigned Categories
            </th>
            <th>
                Status
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
        @foreach($tags as $tag)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$tag->id}}"></td>
                <td>{{$tag->name}}</td>
                <td>
                    @foreach($tag->categories as $category)
                        <span class="c-badge c-badge-info">{{$category->name}}</span>
                    @endforeach
                </td>
                <td>
                    @if($tag->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>{{$tag->created_at}}</td>
                <td>
                    <a href="javascript:void(0);"
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                       data-category="{{$tag}}"
                       data-categories="{{$tag->categories->pluck('id')}}"
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
