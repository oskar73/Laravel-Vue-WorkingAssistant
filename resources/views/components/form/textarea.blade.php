<div class="form-group">
    <label for="{{$name}}" class="form-control-label">{{$label}}:</label>
    <textarea
        class="form-control m-input--square minh-100 white-space-pre-line {{$class?? ''}}"
        name="{{$name}}"
        id="{{$name}}"
    >
        {{$slot}}
    </textarea>
    <div class="form-control-feedback error-{{$name}}"></div>
</div>
