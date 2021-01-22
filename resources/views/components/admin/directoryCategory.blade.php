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
                    @if($selector==='datatable-subcategory')
                        Parent Category
                    @else
                        Subcategories
                    @endif
                </th>
                <th>
                    Recommend Tags
                </th>
                <th>
                    Image
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
        @foreach($categories as $category)
            <tr>
                <td>
                    <input type="checkbox"
                           class="checkbox"
                           data-id="{{$category->id}}"
                    >
                </td>
                <td>{{$category->name}}</td>
                <td>
                    @if($selector==='datatable-subcategory')
                        {{$category->category->name}}
                    @else
                        {{$category->subcategories_count}}
                    @endif
                </td>
                <td>
                    @foreach($category->tags as $tag)
                        <span class="c-badge c-badge-info">{{$tag->name}}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{$category->getFirstMediaUrl('image')}}" class="width-300 progressive replace m-auto">
                        <img src="{{$category->getFirstMediaUrl('image', 'thumb')}}"
                             alt="{{$category->name}}"
                             class="width-300 preview"
                        >
                    </a>
                </td>
                <td x-data="{hover:false}">
                    @if($category->status===1)
                        <span class="c-badge c-badge-success" @mouseenter="hover=true"  x-show="!hover">Active</span>

                        <a href="javascript:void(0);"
                           class="h-cursor c-badge c-badge-danger switchOne"
                           data-action="inactive"
                           x-show="hover"
                           @mouseleave="hover=false"
                        >Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger" @mouseenter="hover=true" x-show="!hover">InActive</span>

                        <a href="javascript:void(0);"
                           class="h-cursor c-badge c-badge-success switchOne"
                           data-action="active"
                           x-show="hover"
                           @mouseleave="hover=false"
                        >Active?</a>
                    @endif
                </td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="javascript:void(0);"
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                       data-category="{{$category}}"
                       data-thumbnail ="{{$category->getFirstMediaUrl('image')}}"
                       data-tags="{{$category->tags->pluck('id')}}"
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
