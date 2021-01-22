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
            <th style="max-width:300px;">
                Title
            </th>
            @if($user==1)
            <th>
                Author
            </th>
            @endif
            <th>
                <i class="fa fa-eye tooltip_3" title="View Count"></i>
            </th>
            <th>
                <i class="fa fa-heart tooltip_3" title="Liked Count"></i>
            </th>
            <th>
                <i class="fa fa-comment tooltip_3" title="Total Comments Count"></i>
            </th>
            <th>
                <i class="fa fa-bell tooltip_3" title="Subscribers Count"></i>
            </th>
            <th>
                Type
            </th>
            <th>
                Featured
            </th>
            <th>
                Published
            </th>
            <th>
                Status
            </th>
            <th>
                Live Date
            </th>
            <th>
                Created At
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="{{$user==1?15:14}}" style="height:200px;"></td></tr></tbody>
    </table>
</div>
