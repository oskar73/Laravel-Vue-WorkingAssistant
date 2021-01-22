<ul class="breadcrumb">
    {!! $title !!}
</ul>
@if($category!==null)
    <a href="{{$category->getFirstMediaUrl('image')}}" class="w-100 progressive replace">
        <img src="{{$category->getFirstMediaUrl('image', 'thumb')}}"
             alt="{{$category->name}}"
             class=" preview"
        >
    </a>
    <div class="mt-5 white-space-pre-line">
        {{$category->description}}
    </div>
@endif

<div class="row mt-5">
    @forelse($items as $item)
        <div class="col-md-4 mb-5  m-auto">
            <div class="project-grid-style3">
                <a href="{{route('portfolio.detail', $item->slug)}}" class="inner-box">
                    <div class="position-relative">
                        <div class="position-absolute z-index-99 w-100 p-2">
                            @if($item->featured) <span class="float-left text-success border-all pl-1 pr-1 border-success"> Featured </span> @endif
                            @if($item->new) <span class="float-right text-danger border-all pl-1 pr-1 border-danger"> New </span> @endif
                        </div>
                        <figure data-href="{{$item->getFirstMediaUrl('thumbnail')}}" class="w-100 progressive replace">
                            <img src="{{$item->getFirstMediaUrl('thumbnail', 'thumb')}}" alt="{{$item->title}}" class="preview w-100"/>
                        </figure>
                        <div class="overlay">
                            <div class="overlay-inner">
                                <div class="description">
                                    <div class="text">{{\Str::limit($item->description, 300)}}</div>
                                    <div  class="read-more"><span class="fa fa-angle-right"></span> See detail</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-desc">
                        <div class="category">{{$item->title}}</div>
                    </div>
                </a>
            </div>
        </div>
    @empty
        <div class="col-md-12 text-center">
            <h3>No item..</h3>
        </div>
    @endforelse
</div>
<div>
    {{ $items->links() }}
</div>
