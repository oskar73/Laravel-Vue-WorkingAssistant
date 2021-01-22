<div class="form-group">
    <label for="{{$name}}" class="form-control-label">{{$label?? ''}}</label>
    <select name="{{$name}}" id="{{$name}}" class="{{$class?? ''}} selectpicker" data-live-search="{{$search?? 'true'}}" data-width="100%" {{$multiple?? ''}}>
        {{$slot}}
    </select>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
