<div class="m-portlet__head bg-333">
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text text-white">
                {!! $label?? '' !!}
            </h3>
        </div>
    </div>
    <div class="m-portlet__head-tools">
        {{$slot}}
    </div>
</div>
