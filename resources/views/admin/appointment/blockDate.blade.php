@extends('layouts.master')

@section('title', 'Appointment Unavailable Dates')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendors/calendar/fullcalendar.css')}}">
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
                    <span class="m-nav__link-text">Appointment</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Unavailable Dates</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2" id="create_modal_btn">Add New</span>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" href="#"> Unavailable Dates </a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="category_area">
        <div class="m-portlet__body">
            <div id="calendar" class="calendar_area">

            </div>
            <div class="list_view mt-5">
                <div class="table-responsive">
                    <table class="table table-hover ajaxTable datatable block-datatable">
                        <thead>
                            <tr>
                                <th>
                                    Date
                                </th>
                                <th >
                                    Time
                                </th>
                                <th>
                                    Reason
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table_body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include("components.admin.blockDateModal")

@endsection
@section('script')
    <script>var id = 0, type="appointment";</script>
    <script src="{{ asset('assets/vendors/calendar/fullcalendar.js') }}"></script>
    <script src="{{asset('assets/js/admin/appointment/blockDate.js')}}"></script>
@endsection
