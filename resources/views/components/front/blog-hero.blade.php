<div>
    @if($data['nav_status']==1)
    <figure data-href="{{$data['nav_image']}}" class="page-top-info  progressive replace img-bg-effect-container text-center">
        <img src="{{$data['nav_image']}}" alt="" class="img-bg preview img-bg-effect">
        <div class="z-index-9 w-100 text-center">
            <h2 class="mb-0 text-white ">
                {!! $data['nav_title'] !!}
            </h2>
        </div>
    </figure>
    @endif
</div>
