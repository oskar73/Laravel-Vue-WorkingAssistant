@extends('layouts.master')

@section('title', 'Purchase Management - Forms')
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
                    <span class="m-nav__link-text">Purchase Management</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Forms</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn" data-action="filled">Filled</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-primary switchBtn " data-action="needtofill">Need to fill</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info switchBtn " data-action="needrevision">Need Revision</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn " data-action="completed">Completed</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn " data-action="read">Mark as read</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-primary switchBtn " data-action="unread">Mark as unread</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn " data-action="delete">Delete</a>
        </div>
    </div>

    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Forms (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#unread" href="#/unread"> Unread Forms (<span class="unread_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#read" href="#/read"> Read Forms (<span class="read_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            @include('components.admin.formTable', ['selector'=>'datatable-all', 'user'=>1])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="unread_area">
        <div class="m-portlet__body">
            @include('components.admin.formTable', ['selector'=>'datatable-unread', 'user'=>1])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="read_area">
        <div class="m-portlet__body">
            @include('components.admin.formTable', ['selector'=>'datatable-read', 'user'=>1])
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/purchase/form.js')}}"></script>
@endsection
