<script type="text/javascript">
    @if($errors->any())
    @foreach($errors->all() as $error)
    itoastr('error','{{$error}}');
    @endforeach
    @endif
    @if ($message = Session::get('success'))
    itoastr('success','{!! $message !!}');
    @endif
    @if ($message = Session::get('status'))
    itoastr('success','{!! $message !!}');
    @endif
    @if ($message = Session::get('error'))
    itoastr('error','{!! $message !!}');
    @endif
    @if ($message = Session::get('info'))
    itoastr('info','{!! $message !!}');
    @endif
</script>
