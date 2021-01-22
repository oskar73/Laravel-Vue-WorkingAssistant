<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    <input name="select_all" class="selectAll checkbox" value="1" type="checkbox" data-area="{{$selector}}">
                </th>
                <th>
                    Spot
                </th>
                <th >
                    Page
                </th>
                @if($user==1)
                <th>
                    User
                </th>
                @endif
                <th>
                    Duration / Impression
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
        <tbody class="loading-tbody"><tr><td colspan="{{$user==1?8:7}}" style="height:200px;"></td></tr></tbody>
    </table>
</div>
