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
                    Category
                </th>
                <th>
                    Title
                </th>
                <th>
                    Image
                </th>
                <th>
                    Featured
                </th>
                <th>
                    New
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
        @foreach($products as $product)
            <tr>
                <td>
                    <input type="checkbox"
                           class="checkbox"
                           data-id="{{$product->id}}"
                    >
                </td>
                <td>
                    {{$product->category->name}}
                </td>
                <td>{{$product->title}}</td>
                <td>
                    <a href="{{$product->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                        <img src="{{$product->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$product->name}}" class="width-150 preview">
                    </a>
                </td>
                <td>
                    @if($product->featured===1)
                        <span class="c-badge c-badge-success hover-handle">Featured</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="unfeatured">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="featured">Featured?</a>
                    @endif
                </td>
                <td>
                    @if($product->new===1)
                        <span class="c-badge c-badge-info hover-handle">New</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="undonew">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-info hover-vis hover-box switchOne" data-action="new">New?</a>
                    @endif
                </td>

                <td>
                    @if($product->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.ecommerce.product.edit', $product->id)}}"
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
