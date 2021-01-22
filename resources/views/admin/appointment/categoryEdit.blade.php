@extends('layouts.master')

@section('title', 'Appointment Category')
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
                    <span class="m-nav__link-text">Category</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area = "#detail" href="#/detail"> Category Detail </a></li>
            <li class="tab-item"><a class="tab-link" data-area = "#unavailable" href="#/unavailable"> Unavailable Dates </a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50"  id="detail_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.appointment.category.store')}}" id="submit_form">
                @csrf
                <input type="hidden" name="category_id" value="{{$category->id}}">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Name:</label>
                                <input type="text" class="form-control m-input--square minh-50" name="name" id="name" value="{{$category->name}}">
                                <div class="form-control-feedback error-name"></div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">Description:</label>
                                <textarea class="form-control m-input--square minh-100" name="description" id="description">{{$category->description}}</textarea>
                                <div class="form-control-feedback error-description"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Status</label> <br>
                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                        <label>
                                            <input type="checkbox" @if($category->status==1) checked @endif name="status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-right">
                                        <a href="{{route('admin.appointment.category.index')}}" class="m-1 btn m-btn-square btn-outline-info m-btn m-btn--custom">Back</a>
                                        <button type="submit" class="m-1 btn m-btn-square btn-outline-success m-btn m-btn--custom smtBtn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                Appointment Availability Setting
                <hr>
                <div class="row seven-cols">
                    @php
                        $key = 0;
                    @endphp
                    @foreach($weekArray as $item)
                        <div class="col-md-1">
                            <label class="m-checkbox m-checkbox--state-primary">
                                <input type="checkbox" name="{{$item}}"
                                       class="checkbox"
                                       data-name="{{$item}}"
                                       @if(isset($data[$item])) checked @endif
                                > {{ucfirst($item)}}
                                <span></span>
                            </label>
                            <div class="{{$item}}_table_area" style="display:@if(isset($data[$item])) block @else none @endif">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info p-1 mb-3 add_time_btn" data-name="{{$item}}">+ Add time</a>
                                <table class="table custom-table">
                                    <tbody id="{{$item}}_table">
                                        @if(isset($data[$item]))
                                            @foreach($data[$item]->hours as $key=>$hour)
                                                <tr id="rowe_{{$item.$key}}">
                                                    <td><input class="form-control timepicker start_time_area" name="start_time_{{$item}}[]" placeholder="start" readonly type="text" value="{{$hour->start}}"/></td>
                                                    <td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time_{{$item}}[]" readonly type="text" value="{{$hour->end}}"/></td>
                                                    <td><a href="javascript:void(0);" data-id="rowe_{{$item.$key}}" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="unavailable_area">
        <div class="m-portlet__body">
            <div class="text-right">
                <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2" id="create_modal_btn">Add New</span>
            </div>
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
    <script src="{{asset('assets/js/admin/appointment/categoryCreate.js')}}"></script>
    <script>var id = "{{$category->id}}", type="category";</script>
    <script src="{{ asset('assets/vendors/calendar/fullcalendar.js') }}"></script>
    <script src="{{asset('assets/js/admin/appointment/blockDate.js')}}"></script>
@endsection
