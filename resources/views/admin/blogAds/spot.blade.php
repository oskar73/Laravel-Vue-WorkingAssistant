@extends('layouts.master')

@section('title', 'Blog Advertisement Spots')
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
                    <span class="m-nav__link-text">Blog Advertisement</span>
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
        <a href="{{route('admin.blogAds.spot.create')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2">Create</a>
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
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Spots (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#active" href="#/active"> Active Spots (<span class="active_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#inactive" href="#/inactive"> InActive Spots (<span class="inactive_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="active_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="inactive_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/blogAds/spot.js')}}"></script>
@endsection
