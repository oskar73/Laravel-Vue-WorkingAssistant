<div class="d-block p-3" style="padding:10px !important;">
    <div class="w-50">
        <img src="{{ asset('assets/img/filemanager.jpg') }}" class="w-100" style="max-width:80px;">
    </div>
    <div class="w-50">
        <p>Total Files:{{$data['count']}}</p>
        <p>Disk: {{$data['current']}} / {{$data['total']}}</p>
    </div>
    <div class="progress biz_progress">
        <div class="progress-bar progress-bar-striped biz_progressbar" role="progressbar"
             style="width: {{$data['percent']}}%;" aria-valuenow="{{$data['percent']}}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p>Used Storage: {{$data['percent']}}% </p>
</div>
<hr style="!important;border: 1px solid grey !important;">
