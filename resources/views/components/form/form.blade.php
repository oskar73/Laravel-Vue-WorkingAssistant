<form action="{{$action}}" id="{{$id?? 'submit_form'}}" method="{{$method?? 'post'}}" enctype="multipart/form-data">
    @csrf
    {{$slot}}
</form>
