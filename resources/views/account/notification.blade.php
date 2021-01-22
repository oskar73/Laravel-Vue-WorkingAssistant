@extends('layouts.master')

@section('title', 'Notifications')
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
                    <span class="m-nav__link-text">Notifications</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn m-1" data-action="read">Mark as Read</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn  m-1" data-action="unread">Mark as unread</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn m-1" data-action="delete">Delete</a>
        </div>
    </div>
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#unread" href="#/unread">Unread Notifications (<span class="unread_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#all" href="#/all">All Notifications (<span class="all_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile md-pt-50 tab_area area-active" id="unread_area">
        <div class="m-portlet__body">
            @include('components.account.notificationTable', ['selector'=>'datatable-unread'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile md-pt-50 tab_area" id="all_area">
        <div class="m-portlet__body">
            @include('components.account.notificationTable', ['selector'=>'datatable-all'])
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/account/notification.js')}}"></script>
@endsection
