<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
            </th>
            <th style="max-width:300px;">
                Post Title
            </th>
            <th>
                Comment
            </th>
            <th>
                User
            </th>
            <th>
                <i class="fa fa-thumbs-up tooltip_3" title="Liked Count"></i>
            </th>
            <th>
                <i class="fa fa-thumbs-down tooltip_3" title="Disliked Count"></i>
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
        <tbody class="loading-tbody"><tr><td colspan="9" style="height:200px;"></td></tr></tbody>
    </table>
</div>
