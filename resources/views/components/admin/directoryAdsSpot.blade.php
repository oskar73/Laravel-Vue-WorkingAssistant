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
                Page
            </th>
            <th>
                Ad Position (Type)
            </th>
            <th>
                Price
            </th>
            <th>
                Sponsored Link
            </th>
            <th>
                Featured
            </th>
            <th>
                New
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
        @foreach($spots as $spot)
            <tr>
                <td><input type="checkbox" class="checkbox" data-id="{{$spot->id}}"></td>
                <td>{{$spot->name}}</td>
                <td>{{$spot->getPageName()}}</td>
                <td>

                    {{$spot->position->name}} <br>
                    (Width:{{json_decode($spot->type)->width}}px, Height:{{json_decode($spot->type)->height}}px)

                </td>
                <td>
                    @forelse($spot->approvedPrices as $price)
                        <div  @if($price->standard)title="Standard Price" class="text-active tooltip_1" @endif>
                            <span class="slashed_price_text">{{$price->slashed_price? '$'. $price->slashed_price: ''}}</span>
                            <span>${{$price->price}}</span> /  {{$price->getUnit()}}<br>
                        </div>
                    @empty
                        Not set yet
                    @endforelse
                </td>
                <td>
                    @if($spot->sponsored_visible===1)
                        <span class="c-badge c-badge-success hover-handle">Visible</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="invisible">InVisible?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InVisible</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="visible">Visible?</a>
                    @endif
                </td>
                <td>
                    @if($spot->featured)
                        <span class="c-badge c-badge-success hover-handle">Featured</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="unfeatured">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="featured">Featured?</a>
                    @endif
                </td>
                <td>
                    @if($spot->new)
                        <span class="c-badge c-badge-success hover-handle">New</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="undonew">Cancel?</a>
                    @else
                        <a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="new">New?</a>
                    @endif
                </td>
                <td>
                    10
                </td>
                <td>
                    @if($spot->status===1)
                        <span class="c-badge c-badge-success hover-handle">Active</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >InActive</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.directoryAds.spot.edit', $spot->id)}}"
                       class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon"
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
