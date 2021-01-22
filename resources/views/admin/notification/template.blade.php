@extends('layouts.master')

@section('title', 'Notification Templates')
@section('style')

@endsection
@section('breadcrumb')
    <div class="col-md-4 text-left">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Notification</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Templates</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-4">
        <select id="category_filter" class="form-control selectpicker">
            <option selected>All Categories</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 text-right">
        <a href="{{route('admin.notification.template.create')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 createBtn">Create</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all"> All Templates  (<span class="all_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50 area-active" id="all_area">
        <div class="m-portlet__body">
            @include("components.admin.notificationTemplateTable", ['selector'=>'datatable-all'])
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/notification/template.js')}}"></script>
@endsection
