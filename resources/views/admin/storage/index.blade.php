@extends('layouts.master')

@section('title', 'Storage Management')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Storage Management</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0);" class="text-dark open_window"><i class="fa fa-external-link-alt"></i> Open New Window</a>
    </div>
@endsection

@section('content')
    <iframe src="/admin/storage/getData" frameborder="0" class="file_iframe"></iframe>
@endsection
@section('script')
    <script>
        $(".open_window").on("click", function() {
            window.open('/admin/storage/getFrame', "Chat Box", "width=800, height=600");
        })
    </script>
@endsection
