@extends('layouts.master')

@section('title', 'Directory Advertisement Listing')
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
                    <span class="m-nav__link-text">Directory Ads Listings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('directoryAds.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Add New Ad Listing</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Listings (<span class="all_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            @include("components.user.directoryAdsTable", ['selector'=>'datatable-all'])
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/user/directoryAds/index.js')}}"></script>
@endsection
