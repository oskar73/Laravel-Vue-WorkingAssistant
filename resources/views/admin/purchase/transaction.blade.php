@extends('layouts.master')

@section('title', 'Purchase Management - Transactions')
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
                    <span class="m-nav__link-text">Transactions</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Transactions (<span class="all_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#onetime" href="#/onetime"> Onetime Transactions (<span class="onetime_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#recurrent" href="#/recurrent"> Recurrent Transactions (<span class="recurrent_count">0</span>)</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#refunded" href="#/refunded"> Refunded Transactions (<span class="refunded_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            @include('components.admin.transactionTable', ['selector'=>'datatable-all'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="onetime_area">
        <div class="m-portlet__body">
            @include('components.admin.transactionTable', ['selector'=>'datatable-onetime'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="recurrent_area">
        <div class="m-portlet__body">
            @include('components.admin.transactionTable', ['selector'=>'datatable-recurrent'])
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="refunded_area">
        <div class="m-portlet__body">
            @include('components.admin.transactionTable', ['selector'=>'datatable-refunded'])
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/admin/purchase/transaction.js')}}"></script>
@endsection
