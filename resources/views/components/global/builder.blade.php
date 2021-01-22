<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" crossorigin="anonymous" />
<link href="{{asset('assets/builder/website.css')}}" rel="stylesheet" type="text/css" />
<script>
    window.template = @json($website);
    @if (isset($modules))
        window.modules = @json($modules);
    @endif
    window.config = {
        websiteId: window.template.id,
        basePath: '{{$basePath ?? ''}}',
        previewMode: true,
        gateway: @json(tenant()->gateway()),
        auth: false
    }
    @auth
    window.config.auth = true
    @endauth
</script>
<script src="{{asset('assets/builder/website.js')}}" type="text/javascript"></script>
