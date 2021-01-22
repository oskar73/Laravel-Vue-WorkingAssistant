@extends('layouts.master')

@section('title', 'Site Advertisement Spots')
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
                    <span class="m-nav__link-text">Site Advertisement</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Spots</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.siteAds.spot.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
        <a href="{{route('admin.siteAds.spot.create', ["page_id"=>$page->id, "type_id"=>$type->id])}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2">Add New Spot</a>
    </div>
@endsection
@section('content')
    <div class="tab_btn_area text-center">
        <div class="show_checked d-none maxw-300 m-auto ">
            <select id="switchAction" class="form-control selectpicker" style="width:auto;">
                <option selected disabled hidden>Choose Action</option>
                <option value="active">Active</option>
                <option value="inactive">InActive</option>
                <option value="visible">Sponsored Link Visible</option>
                <option value="invisible">Sponsored Link InVisible</option>
                <option value="new">New</option>
                <option value="undonew">Cancel New</option>
                <option value="featured">Featured</option>
                <option value="unfeatured">Cancel Featured</option>
                <option value="delete">Delete</option>
            </select>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active text-capitalize" data-area="#spots" href="#/spots"> {{$page->name}} | {{$type->name}} ({{$type->width}} x {{$type->height}} ) (<span class="all_count">{{$spots->count()}}</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="spots_area">
        <div class="m-portlet__body">
            @include("components.admin.siteAdsSpot", ["display"=>0])
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/siteAds/page.js')}}"></script>
@endsection
