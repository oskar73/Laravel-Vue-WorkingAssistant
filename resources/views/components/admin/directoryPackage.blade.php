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
                Thumbnail
            </th>
            <th>
                Listing Limit
            </th>
            <th>
                Features
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
                    <a href="{{$item->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                        <img src="{{$item->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$item->name}}" class="width-150 preview">
                    </a>
                </td>
                <td>
                    {{$item->listing_limit==-1? 'Unlimit': $item->listing_limit}}
                </td>
                <td class="text-right pr-2">
                    <b>Thumbnail:</b> <img src="{{optional($item->property)['thumbnail']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Featured:</b> <img src="{{optional($item->property)['featured']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Social Share:</b> <img src="{{optional($item->property)['social']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Tracking:</b> <img src="{{optional($item->property)['tracking']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Image Gallery:</b> <img src="{{optional($item->property)['image']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Video Links:</b> <img src="{{optional($item->property)['links']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
                    <b>Video Upload:</b> <img src="{{optional($item->property)['videos']? asset('assets/img/checked.png'):asset('assets/img/remove1.png')}}" alt="" class="width-20px">
                        <br>
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
                    <a href="{{route('admin.directory.package.edit', $item->id)}}" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn">
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
