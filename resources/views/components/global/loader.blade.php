<div class="fakeLoader"></div>
<link rel="stylesheet" href="{{asset('assets/vendors/loading/demo.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/loading/fakeLoader.min.css')}}">
<script src="{{asset('assets/vendors/loading/fakeLoader.min.js')}}"></script>
<script>
    $.fakeLoader({
        bgColor: '{{$color}}',
        spinner: 'spinner{{$loading}}',
        timeToHide:'{{$time}}'
    });
</script>
