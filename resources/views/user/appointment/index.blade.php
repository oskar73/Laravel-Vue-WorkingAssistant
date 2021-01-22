@extends('layouts.master')

@section('title', 'Appointments')
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
                    <span class="m-nav__link-text">Appointments</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="javascript:void(0)" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 newAppointment">New Appointment</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#coming" href="#/coming"> Coming Listings </a></li>
            <li class="tab-item"><a class="tab-link"  data-area="#all" href="#/all"> Appointments (<span class="all_count">0</span>)</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="coming_area">
        <div class="m-portlet__body">
            <div id="calendar" class="calendar_area appointment_calendar">

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
                                Status
                            </th>
                            <th>
                                Product
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

    <div class="m-portlet m-portlet--mobile tab_area" id="all_area">
        <div class="m-portlet__body">
            <div class="tab_btn_area text-center">
                <div class="show_checked d-none">
                    <a href="javascript:void(0);" class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger switchBtn " data-action="delete">Delete</a>
                </div>
            </div>
            @include("components.admin.appointmentTable", ['selector'=>'datatable-all', 'user'=>null])
        </div>
    </div>

    @include("components.user.addAppointmentModal")
@endsection
@section('script')
    <script src="{{ asset('assets/vendors/calendar/fullcalendar.js') }}"></script>
    <script src="{{asset('assets/js/user/appointment/index.js')}}"></script>
@endsection
