@extends('layouts.master')

@section('title', 'Setting - Google Analytics')
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
                    <span class="m-nav__link-text">Setting</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Google Analytics</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Google Analytics
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <form action="{{route('admin.setting.analytics.store')}}" id="submit_form">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="view_id">
                                    Google Analytics View ID
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is your google analytics view ID. <a href='' target='_blanket'>here</a>"
                                    ></i>
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control m-input m-input--square" name="view_id" id="view_id" value="{{$google_services['ga_view_id']}}">
                                </div>
                                <div class="form-control-feedback error-view_id"></div>
                            </div>

                            <div class="form-group">
                                <label for="config_file" class="form-control-label">
                                    Config Json File
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is google analytics config file. You need to upload it. You can download your config file <a href='' target='_blanket'>here</a>"
                                    ></i>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="config_file" name="config_file">
                                    <label class="custom-file-label" for="config_file">
                                        @if($google_services['ga_file'])
                                            File Already Uploaded! <i class="fa fa-check text-success"> </i>
                                        @else
                                            Choose File
                                        @endif
                                    </label>
                                </div>
                                <div class="form-control-feedback error-config_file"></div>
                            </div>
                            <div class="alert alert-primary  m-alert m-alert--air m-alert--outline text-dark" role="alert">
                                Make sure you copy google analytics code (from your google account) and paste in custom script section.
                                <a href="{{route('admin.setting.script.index')}}">HERE</a>. <br>
                                You can track for only front pages or you can track for both front and user pages.
                            </div>
                            <div class="text-right">
                                <button class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 smtBtn">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/setting/analytics.js')}}"></script>
@endsection
