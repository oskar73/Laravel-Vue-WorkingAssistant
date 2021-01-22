<div class="form-group">
    <label for="{{$name}}" class="form-control-label">
        {{$label}}:

        <i class="la la-info-circle tooltip_icon"
           title='{{$tooltip[705]}}'
           data-page="{{$view_name}}"
           data-id="705"
        ></i>


    </label>
    <div class="input-group">
        <input type="{{$type?? 'number'}}" class="form-control text-right m-input--square" value="{{$value?? ''}}" name="{{$name}}" id="{{$name}}">
        <div class="input-group-append" style="width:150px;">
            <select class="form-control m-bootstrap-select selectpicker" name="{{$dropdown}}" id="{{$dropdown}}">
                {{$slot}}
            </select>
        </div>
    </div>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
