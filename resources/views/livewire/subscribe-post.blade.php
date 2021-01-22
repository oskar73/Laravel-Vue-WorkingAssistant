<a href="javascript:void(0);"
   class="post_subscribe_btn {{$isSubscribed? 'active': ''}}"
   wire:click="toggle"
>
    {{$isSubscribed? 'Subscribed': 'Subscribe'}} <i class="fa fa-bell"></i>
    @if($subscribers_count!==0) <span class="font-size14">({{$subscribers_count}})</span> @endif
</a>
