<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
                </th>
                @if($user)
                <th>
                    User
                </th>
                @endif
                <th>
                    Product Type
                </th>
                <th>
                    Product Name
                </th>
                <th>
                    Title
                </th>
                <th>
                    Description
                </th>
                <th>
                    Status
                </th>
                <th>
                    Read At
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="{{$user?10:9}}" style="height:200px;"></td></tr></tbody>
    </table>
</div>
