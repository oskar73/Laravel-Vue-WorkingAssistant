<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
            </th>
            <th>
                Type
            </th>
            <th>
                Product
            </th>
            <th>
                User
            </th>
            <th>
                Rating
            </th>
            <th>
                Comment
            </th>
            <th>
                Status
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="10" style="height:200px;"></td></tr></tbody>
    </table>
</div>
