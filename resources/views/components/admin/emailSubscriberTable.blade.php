<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
                </th>
                <th>
                    Email
                </th>
                <th>
                    Status
                </th>
                <th>
                    Subscribed Date
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="5" style="height:200px;"></td></tr></tbody>
    </table>
</div>
