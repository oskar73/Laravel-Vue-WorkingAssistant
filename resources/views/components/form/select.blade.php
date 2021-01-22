<div class="form-group">
    <label for="{{$name}}" class="form-control-label">{{$label?? ''}}</label>
    <select name="{{$name}}" id="{{$id?? $name}}" class="{{$class?? ''}}" {{$multiple?? ''}}>
        {{$slot}}
    </select>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
