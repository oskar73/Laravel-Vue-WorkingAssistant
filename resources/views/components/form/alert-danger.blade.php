<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="flaticon-exclamation-1"></i>
        <span></span>
    </div>
    <div class="m-alert__text">
        <strong>{{$title }}</strong> {{$slot}}
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
</div>
