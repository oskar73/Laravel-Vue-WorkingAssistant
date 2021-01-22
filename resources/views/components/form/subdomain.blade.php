<div class="form-group">
    <label for="{{$name}}">
        {{$label?? ''}}
        {{$slot}}
    </label>
    <div class="input-group">
        <input type="text" class="form-control m-input text-right" name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder?? ''}}" autocomplete="off" value="{{$value?? ''}}">
        <div class="input-group-append">
            <span class="input-group-text bizinasite_domain">{{$domain}}</span>
        </div>
    </div>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
