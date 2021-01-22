@foreach($items as $thread)
    <div class="text-right">{{$thread->created_at}}</div>
    <div class="ticket_item">
        <div class="img_area">
            <img src="{{$thread->user->avatar()}}" alt="">
        </div>
        <div class="item_box  @if($thread->user_id==user()->id) mine @endif">
            {{$thread->text}}
            @if($thread->getMedia("attachment")->count()!=0)
                <br><br> Attached Files:
            @endif
            @foreach($thread->getMedia("attachment") as $media)
                <a href="{{$media->getUrl()}}" class="attachment_file p-1" target="_blank">{{$media->file_name}}</a>
            @endforeach
            <hr>
            <div class="item_detail">
                <div class="d-flex justify-content-between">
                    <div>by {{$thread->user->name}}, {{$thread->created_at}}</div>
                    <div>Thread ID: #{{$thread->id}}</div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="pagination_area text-xs-center">
    {{$items->links()}}
</div>
