<div class="form-group">
    <label for="thumbnail" class="form-control-label">{{$label?? 'Thumbnail'}}</label>
    <input type="file" accept="image/*"
           class="form-control m-input--square"
           id="thumbnail"
           name="origin_image"
           data-target="thumbnail_image"
    >
    <div class="form-control-feedback error-thumbnail" ></div>
    <img id="thumbnail_image" class="w-100" src="{{$slot}}"/>
</div>
