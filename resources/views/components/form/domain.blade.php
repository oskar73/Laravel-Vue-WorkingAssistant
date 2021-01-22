<div class="form-group">
    <label for="{{$name}}" class="form-control-label">
        {{$label}}:

        {{$slot}}

    </label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text">https://</span>
        </div>
        <input type="text" class="form-control m-input" name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder?? ''}}" value="{{$value?? ''}}">
    </div>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
