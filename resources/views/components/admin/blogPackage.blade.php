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
                Price
            </th>
            <th>
                Post Number
            </th>
            <th>
                Thumbnail
            </th>
            <th class="width-70px">
                Status
            </th>
            <th class="width-70px">
                Featured
            </th>
            <th class="width-70px">
                New
            </th>
            <th class="no-sort">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$item->id}}"></td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    @foreach($item->approvedPrices as $price)
                        {{ $price->getPriceText()}}
                        <br>
                    @endforeach
                </td>
                <td>
                    {{$item->post_number==-1? 'Unlimit': $item->post_number}}
                </td>
                <td>
                    <a href="{{$item->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                        <img src="{{$item->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$item->name}}" class="width-150 preview">
                    </a>
                </td>
                <td>
                    @if($item->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>
                    @if($item->featured===1)
                        <span class="c-badge c-badge-success hover-handle">Featured</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="unfeatured">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="featured">Featured?</a>
                    @endif
                </td>
                <td>
                    @if($item->new===1)
                        <span class="c-badge c-badge-info hover-handle">New</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="undonew">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-info hover-vis hover-box switchOne" data-action="new">New?</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.blog.package.edit', $item->id)}}" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn">
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
