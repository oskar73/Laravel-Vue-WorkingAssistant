<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="datatable-all">
            </th>
            @if($user)
                <th>
                    User
                </th>
            @endif
            <th>
                Date
            </th>
            <th>
                Time
            </th>
            <th>
                Status
            </th>
            <th>
                Product
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="{{$user?7:6}}" style="height:200px;"></td></tr></tbody>
    </table>
</div>
