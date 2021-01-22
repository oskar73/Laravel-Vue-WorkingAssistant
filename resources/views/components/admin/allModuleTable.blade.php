<div class="table-responsive">
    <table class="table table-hover ajaxTable datatable {{$selector}}">
        <thead>
        <tr>
            <th>
                Category
            </th>
            <th>
                Module Name
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
                        {{$module->category->name}}
                        @if($module->featured||$module->new)
                        <div class="text-right">
                            @if($module->featured)<span class="c-badge c-badge-success mr-2">Featured</span>@endif
                            @if($module->new)<span class="c-badge c-badge-info mr-2">New</span>@endif
                        </div>
                    @endif
                        </div>
                    </td>

                    <td>
                        <a href="//{{config('custom.bizinabox.domain')}}/modules/{{$module->slug}}" target="_blank">{{$module->name}}</a>
                    </td>

                    <td>
                        @if(in_array($module->slug, $c_modules))
                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon disabled">
                                Already using this module now
                            </a>
                        @else
                            @if($limits["module"])
                                @if($limits['fmodule']==0&&$module->featured)
                                    <a href="//{{config('custom.bizinabox.domain')}}/account/purchase/package" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon" target="_blank">
                                        Upgrade plan to get this Module
                                    </a>
                                @else

                                    <a href="javascript:void(0);" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon getModule" data-slug="{{$module->slug}}">
                                        Get this Module
                                    </a>
                                @endif
                            @else
                                <a href="//{{config('custom.bizinabox.domain')}}/account/purchase/package" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon" target="_blank">
                                    Upgrade plan to get this Module
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

