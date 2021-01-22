<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th class="no-sort">
                <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
            </th>
            <th>
                Subject
            </th>
            <th>
                Created At
            </th>
            <th>
                Read At
            </th>
            <th>
                Quick Link
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody class="loading-tbody"><tr><td colspan="6" style="height:200px;"></td></tr></tbody>
    </table>
</div>
