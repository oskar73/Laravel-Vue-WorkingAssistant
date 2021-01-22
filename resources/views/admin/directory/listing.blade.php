@extends('layouts.master')

@section('title', 'Directory Listings')
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
                    <span class="m-nav__link-text">Directory Listing</span>
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
        <a href="{{route('admin.directory.listing.create')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Create</a>
    </div>
@endsection

@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none maxw-300 m-auto ">
            <select id="switchAction" class="form-control selectpicker" style="width:auto;">
                <option selected disabled hidden>Choose Action</option>
                <option value="approve">Approve</option>
                <option value="pending">Pending</option>
                <option value="deny">Deny</option>
                <option value="paid">Newly Paid</option>
                <option value="expired">Expired</option>
                <option value="delete">Delete</option>
            </select>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#pending" href="#/pending"> Pending Approval (<span class="pending_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#all" href="#/all"> All Listings (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#approved" href="#/approved"> Approved Listings (<span class="approved_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#denied" href="#/denied"> Denied Listings (<span class="denied_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#expired" href="#/expired"> Expired Listings (<span class="expired_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#new" href="#/new"> Newly Paid Listings (<span class="new_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="pending_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-pending', 'user'=>1])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="all_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-all', 'user'=>1])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="approved_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-approved', 'user'=>1])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="denied_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-denied', 'user'=>1])
        </div>
    </div>

    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="expired_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-expired', 'user'=>1])
        </div>
    </div>

    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="new_area">
        <div class="m-portlet__body">
            @include("components.admin.directoryListingTable", ['selector'=>'datatable-new', 'user'=>1])
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/directory/listing.js')}}"></script>
@endsection
