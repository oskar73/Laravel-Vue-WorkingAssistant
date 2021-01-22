<div class="row nestable_area">
    <div class="col-md-6 mb-4">
        <div class="heading_title">Active Header Items</div>
        <div class="dd" id="nestable">
            @if($headers->count())
                {!! \App\Models\Page::buildAdminHeader($headers) !!}
            @else
                <ol class="dd-list">
                    <div class="dd-empty"></div>
                </ol>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="heading_title">Possible Navigation Items</div>
        <div class="inactive_item_area">
            @foreach($others as $other)
                <div class="dd-item " data-id="{{$other->id}}">
                    <div class="dd-handle pl-5 hover-cursor-normal">{{$other->name}}</div>
                    <div class="menu_left ">
                        <a href="javascript:void(0);" title="Active" class="tipso2 menu_switch"
                           data-menu="{{$other->id}}"><i class="la la-arrow-left"></i></a>
                    </div>
                    @if($other->type==='custom')
                        <div class="menu_right">
                            <a href="javascript:;" class="menu_edit biz_tipso1" data-menu="{{$other}}"
                               data-tipso='Edit'><i class='la la-edit'></i></a>
                            <a href="javascript:;" class="menu_delete biz_tipso1" data-id="{{$other->id}}"
                               data-tipso='Delete'><i class='la la-remove'></i></a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
