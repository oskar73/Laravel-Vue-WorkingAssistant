@props(["order"=>1, "name"=>'order'])
<div class="form-group">
    <label for="{{$name}}">Choose Gallery Order:</label>
    <div class="row">
        <div class="col-lg-6">
            <label class="m-option h-cursor">
                <span class="m-option__control">
                    <span class="m-radio m-radio--brand m-radio--check-bold">
                        <input type="radio" name="{{$name}}" value="1" @if($order==1) checked @endif>
                        <span></span>
                    </span>
                </span>
                <span class="m-option__label">
                    <span class="m-option__head">
                        <span class="m-option__title">
                            Image Gallery

                            <hr/>

                            Video Gallery
                        </span>
                    </span>
                </span>
            </label>
        </div>
        <div class="col-lg-6">
            <label class="m-option h-cursor">
                <span class="m-option__control">
                    <span class="m-radio m-radio--brand m-radio--check-bold">
                        <input type="radio" name="{{$name}}" value="0" @if($order==0) checked @endif>
                        <span></span>
                    </span>
                </span>
                <span class="m-option__label">
                    <span class="m-option__head">
                        <span class="m-option__title">
                             Video Gallery

                            <hr/>

                             Image Gallery

                        </span>
                    </span>
                </span>
            </label>
        </div>
    </div>
</div>
