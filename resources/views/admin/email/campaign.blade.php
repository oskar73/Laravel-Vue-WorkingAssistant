@extends('layouts.master')

@section('title', 'Email Campaigns')
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
                    <span class="m-nav__link-text">Email Campaign</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Listings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.email.campaign.create')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 createBtn">Create</a>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none">
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success switchBtn m-1" data-action="active">Active</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn  m-1" data-action="inactive">Inactive</a>
            <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn  m-1" data-action="delete">Delete</a>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Campaigns  (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#active" href="#/active"> Active Campaigns  (<span class="active_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#inactive" href="#/inactive"> Inactive Campaigns  (<span class="inactive_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#sent" href="#/sent"> Sent Campaigns  (<span class="sent_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50 area-active" id="all_area">
        <div class="m-portlet__body">
            @include("components.admin.emailCampaignTable", ['selector'=>'datatable-all'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="active_area">
        <div class="m-portlet__body">
            @include("components.admin.emailCampaignTable", ['selector'=>'datatable-active'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="inactive_area">
        <div class="m-portlet__body">
            @include("components.admin.emailCampaignTable", ['selector'=>'datatable-inactive'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="sent_area">
        <div class="m-portlet__body">
            @include("components.admin.emailCampaignTable", ['selector'=>'datatable-sent'])
        </div>
    </div>


    <div class="modal fade" id="preview_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/email/campaign.js')}}"></script>
@endsection
