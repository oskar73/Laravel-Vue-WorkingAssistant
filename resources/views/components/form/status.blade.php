<div class="form-group">
    <label for="{{$name}}" class="form-control-label">{{$label}}</label>
    <div>
        <span class="m-switch m-switch--icon m-switch--info">
            <label>
                <input type="checkbox" {{$checked?? ''}} {{$disabled?? ''}} name="{{$name}}" id="{{$name}}">
                <span></span>
            </label>
        </span>
    </div>
</div>
