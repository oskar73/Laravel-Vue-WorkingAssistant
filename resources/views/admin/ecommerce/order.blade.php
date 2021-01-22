@extends('layouts.master')

@section('title', 'Ecommerce Store')
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
                    <span class="m-nav__link-text">Ecommerce Store</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Order</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        {{-- <a href="" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success createBtn mb-2">Add New Product</a> --}}
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Orders (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#pending" href="#/pending">Pending Orders (<span class="pending_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#confirmed" href="#/confirmed">Confirmed Orders (<span class="confirmed_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#completed" href="#/completed">Completed Orders (<span class="completed_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#canceled" href="#/canceled">Canceled Orders (<span class="canceled_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="pending_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="confirmed_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="completed_area">
    <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="canceled_area">
        <div class="m-portlet__body">
            <div class="text-center"><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/ecommerce/order.js')}}"></script>
@endsection
