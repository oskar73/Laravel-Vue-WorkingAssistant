<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Published?
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
                    <div class="d-flex justify-content-between">
                        {{$module->name}}
                        @if($module->featured)
                        <div class="text-right">
                            <span class="c-badge c-badge-success mr-2">Featured</span>
                        </div>
                        @endif
                    </div>
                </td>
                <td>
                    @if($module->publish===1)
                        <span class="c-badge c-badge-success hover-handle">Published</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchModule" data-action="unpublish" data-slug="{{$module->slug}}">Unpublish?</a>
                    @else
                        <span class="c-badge c-badge-danger hover-handle" >Unpublished</span>
                        <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchModule" data-action="publish" data-slug="{{$module->slug}}">Publish?</a>
                    @endif
                </td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchModule" data-action="cancel" data-slug="{{$module->slug}}">
                        Cancel Module
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

