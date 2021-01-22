@extends('layouts.master')

@section('title', 'Setting - Custom Script')
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
                    <span class="m-nav__link-text">Custom Script</span>
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
                        Custom Script
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <form action="{{route('admin.setting.script.store')}}" id="submit_form">
                    @csrf

                    <div class="form-group">
                        <label for="frontside_head_code">
                            Front Side Additional Head Script
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This script will be put between 'head' tag in website frontend."
                            ></i>
                        </label>
                        <div class="position-relative">
                            <div id="frontside_head_code" class="ace_editor">{{$script['front_head']}}</div>
                        </div>
                        <div class="form-control-feedback error-frontside_head_code"></div>
                    </div>

                    <div class="form-group">
                        <label for="frontside_bottom_code">
                            Front Side Additional Bottom Script
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This script will be put before `body` tag in website frontend."
                            ></i>
                        </label>
                        <div class="position-relative">
                            <div id="frontside_bottom_code" class="ace_editor">{{$script['front_bottom']}}</div>
                        </div>
                        <div class="form-control-feedback error-frontside_bottom_code"></div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label for="backside_head_code">
                            User/Admin Side Additional Head Script
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This script will be put between 'head' tag in website frontend."
                            ></i>
                        </label>
                        <div class="position-relative">
                            <div id="backside_head_code" class="ace_editor">{{$script['back_head']}}</div>
                        </div>
                        <div class="form-control-feedback error-backside_head_code"></div>
                    </div>

                    <div class="form-group">
                        <label for="backside_bottom_code">
                            User/Admin Side Additional Bottom Script
                            <i class="la la-info-circle tipso2"
                               data-tipso-title="What is this?"
                               data-tipso="This script will be put before `body` tag in website frontend."
                            ></i>
                        </label>
                        <div class="position-relative">
                            <div id="backside_bottom_code" class="ace_editor">{{$script['back_bottom']}}</div>
                        </div>
                        <div class="form-control-feedback error-backside_bottom_code"></div>
                    </div>

                    <div class="text-right">
                        <button class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 smtBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/ace.js"></script>
    <script src="{{asset('assets/js/admin/setting/script.js')}}"></script>
@endsection
