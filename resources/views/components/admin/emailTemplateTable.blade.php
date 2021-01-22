<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
                </th>
                <th>
                    Category
                </th>
                <th>
                    Name
                </th>
                <th>
                    Thumbnail
                </th>
                <th>
                    Description
                </th>
                <th>
                    Status
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($templates as $template)
                <tr>
                    <td><input type="checkbox" class="checkbox" data-id="{{$template->id}}"></td>
                    <td>{{$template->category->name}}</td>
                    <td>{{$template->name}}</td>
                    <td>
                        <a href="{{$template->getFirstMediaUrl('thumbnail')}}" class="width-300 progressive replace m-auto">
                            <img src="{{$template->getFirstMediaUrl('thumbnail', 'thumb')}}"
                                 alt="{{$template->name}}"
                                 class="width-300 preview"
                            >
                        </a>
                    </td>
                    <td>{{$template->description}}</td>
                    <td>
                        @if($template->status===1)
                            <span class="c-badge c-badge-success hover-handle">Active</span>
                            <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                        @else
                            <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                            <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                        @endif
                    </td>
                    <td>{{$template->created_at}}</td>
                    <td>
                        <a href="{{route('admin.email.template.show', $template->id)}}" class="btn btn-outline-primary btn-sm m-1	p-2 m-btn m-btn--icon previewBtn">
                            <span>
                                <i class="la la-eye"></i>
                                <span>Preview</span>
                            </span>
                        </a>
                        <a href="{{route('admin.email.template.edit', $template->id)}}" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon">
                            <span>
                                <i class="la la-edit"></i>
                                <span>Edit</span>
                            </span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                            <span>
                                <i class="la la-remove"></i>
                                <span>Delete</span>
                            </span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
