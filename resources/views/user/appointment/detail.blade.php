@extends('layouts.master')

@section('title', 'Appointments')
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
                    <span class="m-nav__link-text">Appointments</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Details</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('user.appointment.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
        <a href="{{route('user.appointment.listing.edit', $list->id)}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2">Edit</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <div class="clearfix"></div>
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" href="#"> Appointments </a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="category_area">
        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">

                        {{-- <div class="row">
                            <div class="col-md-6">
                                @if($list->status!='done')
                                    @if($list->status!='approved')
                                        <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2 approveBtn">Approve</span>
                                    @endif
                                    @if($list->status!='canceled')
                                        <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-danger mb-2 cancelBtn">Cancel</span>
                                    @endif
                                @endif
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="status">Status: </label>
                            <div class="btn m-btn--square m-btn--sm  {{$list->status=='approved'?'btn-outline-success':'btn-outline-danger'}}">{{ucfirst($list->status)}}</div>
                            <div class="form-control-feedback error-status"></div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" value="{{$list->category->name}}" readonly>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" value="{{$list->date}}" readonly id="date" name="date">
                            <div class="form-control-feedback error-date"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="text" class="form-control timepicker" value="{{$list->start_time}}" readonly id="start_time" name="start_time">
                                    <div class="form-control-feedback error-start_time"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="text" class="form-control timepicker" value="{{$list->end_time}}" readonly id="end_time" name="end_time">
                                    <div class="form-control-feedback error-end_time"></div>
                                </div>
                            </div>
                        </div>
                        @if($list->reason!=null)
                            <div class="m-alert m-alert--outline m-alert--square alert alert-info fade show" role="alert">
                                <strong>Reason:</strong> {{$list->reason}}
                            </div>
                        @endif
                        @if($list->description!=null)
                            <div class="form-group">
                                <label for="description">Description</label>
                                <div class="reason">
                                    {{$list->description}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
