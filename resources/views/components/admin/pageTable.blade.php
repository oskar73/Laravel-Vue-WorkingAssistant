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
                URL
            </th>
            <th>
                Parent Page
            </th>
            <th>
                Status
            </th>
            <th>
                Created At
            </th>
            <th>
                Edit Content
            </th>
            <th class="no-sort">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$page->id}}"></td>
                <td>{{$page->name}}</td>
                <td>
                    <a href="{{Request::root() . '/' .$page->url}}" target="_blank">{{Request::root() . '/' .$page->url}}</a>
                </td>
                <td>
                    @if($page->parent_id==0)
                        <span class="c-badge c-badge-success">Main Page</span>
                    @else
                        <span class="c-badge c-badge-info">{{$page->parent->name}}</span>
                    @endif
                </td>
                <td>
                    @if($page->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>{{$page->created_at}}</td>
                <td>
                    <a href="{{route('admin.content.page.editContent', ['id'=>$page->id, 'type'=>$page->type])}}"
                       class="tab-link btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                    >
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a>
                </td>
                <td>
                    <a href="{{route('admin.content.page.edit', $page->id)}}"
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
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
