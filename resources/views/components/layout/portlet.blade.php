@props(["active"=>0, "label"=>'', "id"=>''])

<x-layout.portletFrame active="{{$active}}" id="{{$id}}">
    <x-layout.portletHead label="{!! $label?? '' !!}" />
    <div class="m-portlet__body">
        {{$slot}}
    </div>
</x-layout.portletFrame>
