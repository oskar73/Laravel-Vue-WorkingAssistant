@props(["active"=>0, "label"=>'', "id"=>''])

<div class="m-portlet m-portlet--mobile tab_area {{$active==1? 'area-active':''}}" id="{{$id}}">
    {{$slot}}
</div>
