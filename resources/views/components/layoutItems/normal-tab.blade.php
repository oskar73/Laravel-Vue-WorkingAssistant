@props(['title'=>'', 'active'=>0, 'link'=>'', 'disabled'=>''])
<li class="tab-item">
    <a class="tab-link {{$active==1? 'tab-active':''}} {{$disabled}}" data-area="#{{$link}}" href="#/{{$link}}">{{$title}}</a>
</li>
