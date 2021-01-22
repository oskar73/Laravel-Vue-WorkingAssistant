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
                Primary Color
            </th>
            <th>
                Secondary Color
            </th>
            <th>
                Background Color
            </th>
            <th>
                Theme Font Color
            </th>
            <th>
                Font Color
            </th>
            <th>
                Link Color
            </th>
            <th>
                Link Hover Color
            </th>
            <th>
                Active Icon Color
            </th>
            <th>
                Status
            </th>
            <th>
                Created At
            </th>
            <th class="no-sort">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($themeColors as $color)
                <tr>
                    <td><input type="checkbox" class="checkbox" data-id="{{$color->id}}"></td>
                    <td>{{$color->name}}</td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("primary")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("secondary")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("background")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("theme_font")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("font")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("link")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("link_hover")}}"></div></td>
                    <td><div class="color_disp_area" style="background-color:#{{$color->themeColor("active_icon")}}"></div></td>
                    <td>
                        @if($color->default)
                            <span class="c-badge c-badge-success">Current</span>
                        @else
                            <a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="current" data-type="theme">Set as Current?</a>
                        @endif
                    </td>
                    <td>{{$color->created_at}}</td>
                    <td>
                        <a href="{{route('admin.setting.color.edit', $color->id)}}"
                           class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
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
