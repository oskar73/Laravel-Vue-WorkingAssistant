@props(['name'=>'', 'active'=>0, 'count'=>0, 'label'=>''])
<li class="tab-item">
    <a class="tab-link {{$active==1? 'tab-active':''}}" data-area="#{{$name}}" href="#/{{$name}}"> {{$label}} (<span class="{{$name}}_count">{{$count}}</span>)</a>
</li>
