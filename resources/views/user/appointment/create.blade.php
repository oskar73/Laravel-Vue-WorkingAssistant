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
        </ul>
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
            <div class="container appointment_area">
                <div class="text-right">
                    <a href="{{route('user.appointment.index')}}" class="ml-auto btn m-btn--square m-btn--sm btn-outline-info mb-2">Back</a>
                    <span class="ml-auto btn m-btn--square m-btn--sm btn-outline-success mb-2" id="smtBtn">Submit</span>
                </div>
                <div class="mt-3">
                    <p class="fs-20">Choose available product.</p>
                    @foreach($meetings as $meeting)
                        <span class="btn m-btn--square  btn-outline-accent m-btn m-btn--custom m-1 text-dark product_item {{$meeting->available_number<=0?'unavailable':'available'}}" data-id="{{$meeting->id}}">({{$meeting->userModelToName($meeting->model_type)}}) {{$meeting->model->getName()}} ({{$meeting->available_number}})</span>
                    @endforeach
                </div>
                <div class="mt-3">
                    <p class="fs-20">Choose category</p>
                    @foreach($categories as $category)
                        <span class="btn m-btn--square  btn-outline-info m-btn m-btn--custom m-1 category_item" data-id="{{$category->id}}">{{$category->name}}</span>
                    @endforeach
                </div>
                <div class="mt-3">
                    <p class="fs-20">Choose date</p>
                    <div class="form-group maxw-300">
                        <div class='input-group'>
                            <input type="text" class="form-control m-input--square" id='choose_date' name="choose_date" readonly/>
                        </div>
                        <div class="form-control-feedback error-choose_date"></div>
                    </div>
                    <div class="choose_date_area"></div>
                    <hr>
                    <div class="period_area">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/js/user/appointment/create.js')}}"></script>
@endsection
