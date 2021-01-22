@extends('layouts.master')

@section('title', 'Blog Comments')
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
                    <span class="m-nav__link-text">Blog</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Comments</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn m-1" data-action="approve">Approve</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn  m-1" data-action="deny">Deny</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn  m-1" data-action="delete">Delete</a>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Comments  (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#pending" href="#/pending"> Pending Approval  (<span class="pending_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#approved" href="#/approved"> Approved Comments  (<span class="approved_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#denied" href="#/denied"> Denied Comments  (<span class="denied_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            @include("components.admin.blogCommentTable", ['selector'=>'datatable-all'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="pending_area">
        <div class="m-portlet__body">
            @include("components.admin.blogCommentTable", ['selector'=>'datatable-pending'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="approved_area">
        <div class="m-portlet__body">
            @include("components.admin.blogCommentTable", ['selector'=>'datatable-approved'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="denied_area">
        <div class="m-portlet__body">
            @include("components.admin.blogCommentTable", ['selector'=>'datatable-denied'])
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/blog/comment.js')}}"></script>
@endsection
