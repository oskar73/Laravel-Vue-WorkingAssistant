<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                Page
            </th>
            <th>
                Ad Type
            </th>
            <th>
                Spots Count
            </th>
            <th class="no-sort">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            @foreach($types as $type)
                <tr>
                    <td>{{$page->name}}</td>
                    <td>
                        {{$type->name}} ({{$type->width}} x {{$type->height}} px)
                    </td>
                    <td>
                        @php $count = 0;@endphp
                        @if($page->spots_count&&$type->spots_count)
                            @foreach($spots as $spot)
                                @php
                                    if($spot->page_id==$page->id&&$spot->type_id==$type->id) $count++;
                                @endphp
                            @endforeach
                        @endif
                        {{$count}}
                    </td>
                    <td>
                        <a href="{{route('admin.siteAds.spot.page', ['page_id'=>$page->id, 'type_id'=>$type->id])}}"
                           class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon"
                        >
                            <span>
                                <i class="la la-eye"></i>
                                View Spots
                            </span>
                        </a>
                        <a href="{{route('admin.siteAds.spot.create', ['page_id'=>$page->id, 'type_id'=>$type->id])}}" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon">
                            <span>
                                + Add New Spot
                            </span>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
