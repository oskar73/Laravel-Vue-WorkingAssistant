<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Canceled Date
                </th>
                <th class="no-sort">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($modules as $module)
            <tr>
                <td>
                    @if($module->featured)
                        <div class="text-right">
                            <span class="c-badge c-badge-success mr-2">Featured</span>
                        </div>
                    @endif
                    {{$module->name}}
                </td>
                <td>{{$module->updated_at}}</td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon getModule" data-slug="{{$module->slug}}">
                        Enable Module
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

